<?php

namespace App\Console\Commands;

use App\Models\ContentBlock;
use App\Models\Media;
use App\Models\Page;
use App\Models\User;
use App\Services\MigrationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Signature('cms:migrate-static-files')]
#[Description('Migrate static HTML files from old_files/ directory to CMS database')]
class MigrateStaticFiles extends Command
{
    protected MigrationService $migrationService;
    
    protected int $pagesCreated = 0;
    protected int $blocksCreated = 0;
    protected int $mediaCreated = 0;
    protected int $errors = 0;
    
    public function __construct(MigrationService $migrationService)
    {
        parent::__construct();
        $this->migrationService = $migrationService;
    }
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of static HTML files...');
        $this->newLine();
        
        // Get or create a system user for migration
        $systemUser = $this->getSystemUser();
        
        // Get all HTML files from old_files directory
        $oldFilesPath = base_path('old_files');
        
        if (!is_dir($oldFilesPath)) {
            $this->error('old_files/ directory not found!');
            return 1;
        }
        
        $htmlFiles = glob($oldFilesPath . '/*.html');
        
        if (empty($htmlFiles)) {
            $this->error('No HTML files found in old_files/ directory!');
            return 1;
        }
        
        $this->info('Found ' . count($htmlFiles) . ' HTML files to migrate.');
        $this->newLine();
        
        $progressBar = $this->output->createProgressBar(count($htmlFiles));
        $progressBar->start();
        
        foreach ($htmlFiles as $filePath) {
            try {
                $this->migrateFile($filePath, $systemUser);
            } catch (\Exception $e) {
                $this->errors++;
                $this->newLine();
                $this->error('Error migrating ' . basename($filePath) . ': ' . $e->getMessage());
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        // Output summary report
        $this->outputSummary();
        
        return 0;
    }
    
    /**
     * Migrate a single HTML file.
     */
    protected function migrateFile(string $filePath, User $user): void
    {
        $filename = basename($filePath, '.html');
        
        // Skip navbar, footer, and other non-page files
        if (in_array(strtolower($filename), ['navbar', 'footer', 'layout'])) {
            return;
        }
        
        // Parse HTML file
        $metadata = $this->migrationService->parseHtmlFile($filePath);
        $sections = $this->migrationService->identifyContentSections($filePath);
        $mediaFiles = $this->migrationService->extractMediaFiles($filePath);
        
        // Determine category
        $category = $this->migrationService->determineCategory($filename);
        
        // Generate slug from filename
        $slug = Str::slug($filename);
        
        // Check if page already exists
        $existingPage = Page::where('slug', $slug)->where('language', 'en')->first();
        
        if ($existingPage) {
            // Skip if already migrated
            return;
        }
        
        // Create page
        DB::transaction(function () use ($metadata, $slug, $category, $sections, $mediaFiles, $user) {
            $page = Page::create([
                'title' => $metadata['title'],
                'slug' => $slug,
                'category' => $category,
                'status' => 'draft',
                'language' => 'en',
                'meta_title' => $metadata['meta_title'],
                'meta_description' => $metadata['meta_description'],
                'meta_keywords' => $metadata['meta_keywords'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
            
            $this->pagesCreated++;
            
            // Create content blocks
            foreach ($sections as $index => $section) {
                ContentBlock::create([
                    'page_id' => $page->id,
                    'type' => $section['type'],
                    'content' => $section['content'],
                    'display_order' => $index,
                    'is_reusable' => false,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]);
                
                $this->blocksCreated++;
            }
            
            // Copy media files to storage
            foreach ($mediaFiles as $mediaFile) {
                $this->copyMediaFile($mediaFile, $user);
            }
        });
    }
    
    /**
     * Copy media file to storage and create Media record.
     */
    protected function copyMediaFile(array $mediaFile, User $user): void
    {
        $sourcePath = base_path('old_files/' . $mediaFile['src']);
        
        if (!file_exists($sourcePath)) {
            return;
        }
        
        // Generate unique filename
        $originalName = basename($mediaFile['src']);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $uniqueFilename = Str::slug($nameWithoutExt) . '-' . time() . '-' . Str::random(8) . '.' . $extension;
        
        // Check if media already exists
        $existingMedia = Media::where('original_name', $originalName)->first();
        
        if ($existingMedia) {
            return;
        }
        
        // Copy file to storage
        $destinationPath = 'media/' . $uniqueFilename;
        Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
        
        // Create media record
        Media::create([
            'filename' => $uniqueFilename,
            'original_name' => $originalName,
            'mime_type' => mime_content_type($sourcePath),
            'size' => filesize($sourcePath),
            'path' => $destinationPath,
            'uploaded_by' => $user->id,
            'alt_text' => $mediaFile['alt'] ?? null,
        ]);
        
        $this->mediaCreated++;
    }
    
    /**
     * Get or create system user for migration.
     */
    protected function getSystemUser(): User
    {
        $user = User::where('email', 'system@migration.local')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'System Migration',
                'email' => 'system@migration.local',
                'password' => bcrypt(Str::random(32)),
                'role' => 'super_admin',
            ]);
        }
        
        return $user;
    }
    
    /**
     * Output migration summary report.
     */
    protected function outputSummary(): void
    {
        $this->info('=== Migration Summary ===');
        $this->newLine();
        
        $this->table(
            ['Metric', 'Count'],
            [
                ['Pages Created', $this->pagesCreated],
                ['Content Blocks Created', $this->blocksCreated],
                ['Media Files Copied', $this->mediaCreated],
                ['Errors', $this->errors],
            ]
        );
        
        $this->newLine();
        
        if ($this->errors === 0) {
            $this->info('✓ Migration completed successfully!');
        } else {
            $this->warn('⚠ Migration completed with ' . $this->errors . ' error(s).');
        }
        
        $this->newLine();
        $this->info('Next steps:');
        $this->line('1. Review migrated pages in the admin panel');
        $this->line('2. Update page statuses from draft to published');
        $this->line('3. Verify content blocks are correctly structured');
        $this->line('4. Check media files in the media library');
    }
}
