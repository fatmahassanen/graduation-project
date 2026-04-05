# Static File Migration Guide

## Overview

The `cms:migrate-static-files` command migrates static HTML files from the `old_files/` directory into the CMS database, creating Page and ContentBlock records.

## Usage

```bash
php artisan cms:migrate-static-files
```

## What It Does

1. **Scans HTML Files**: Reads all `.html` files from the `old_files/` directory
2. **Extracts Metadata**: Parses `<title>`, `<meta>` tags, and page headers
3. **Identifies Content Sections**: Detects common patterns:
   - Hero sections (page headers)
   - Card grids (service items, admission boxes)
   - FAQ sections
   - Video embeds
   - Text content blocks
4. **Copies Media Files**: Extracts and copies images/videos to storage
5. **Creates Database Records**: 
   - Creates Page records with appropriate categories
   - Creates ContentBlock records for each section
   - Creates Media records for uploaded files
6. **Generates Slugs**: Creates URL-friendly slugs from filenames

## Category Mapping

The command automatically determines page categories based on filename keywords:

| Keywords | Category |
|----------|----------|
| admission, apply, accepted | admissions |
| dean, faculty, automotive, energy | faculties |
| event, competition, conference, exhibition | events |
| about, mission, vision, contact | about |
| quality, evaluation | quality |
| media, news, gallery | media |
| campus | campus |
| staff | staff |
| student | student_services |

## Content Block Types Detected

- **hero**: Page headers with title
- **card_grid**: Multiple cards with titles and descriptions
- **faq**: Question and answer sections
- **video**: Video embeds
- **text**: Paragraph content in styled boxes

## Output

The command provides a summary report showing:
- Number of pages created
- Number of content blocks created
- Number of media files copied
- Any errors encountered

## Example Output

```
Starting migration of static HTML files...

Found 75 HTML files to migrate.

 75/75 [============================] 100%

=== Migration Summary ===

+------------------------+-------+
| Metric                 | Count |
+------------------------+-------+
| Pages Created          | 72    |
| Content Blocks Created | 69    |
| Media Files Copied     | 107   |
| Errors                 | 0     |
+------------------------+-------+

✓ Migration completed successfully!
```

## Post-Migration Steps

1. Review migrated pages in the admin panel
2. Update page statuses from `draft` to `published`
3. Verify content blocks are correctly structured
4. Check media files in the media library
5. Adjust content block ordering if needed
6. Add missing metadata (descriptions, keywords)

## Duplicate Prevention

The command checks for existing pages by slug and language before creating new records. Running the command multiple times will not create duplicates.

## System User

The command creates a system user (`system@migration.local`) with super_admin role to attribute the migrated content. This user is created automatically if it doesn't exist.

## Troubleshooting

### No HTML files found
- Ensure the `old_files/` directory exists in the project root
- Check that HTML files have the `.html` extension

### Media files not copied
- Verify media files exist in the paths referenced in HTML
- Check storage permissions for `storage/app/public/media`

### Content sections not detected
- Review the HTML structure to ensure it matches expected patterns
- Check the MigrationService class for supported patterns
- Consider manually creating content blocks for complex layouts

## Technical Details

### Service Class
`App\Services\MigrationService` handles:
- HTML parsing with DOMDocument
- Metadata extraction
- Content section identification
- Media file extraction
- Category determination

### Command Class
`App\Console\Commands\MigrateStaticFiles` handles:
- File iteration
- Database transactions
- Progress reporting
- Error handling
- Summary generation
