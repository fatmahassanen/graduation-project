<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml
     */
    public function index(): Response
    {
        // Cache sitemap for 1 hour
        $xml = Cache::remember('sitemap', 3600, function () {
            return $this->generateSitemap();
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate sitemap XML content
     */
    protected function generateSitemap(): string
    {
        $pages = Page::where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Add homepage
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';

        // Add all published pages
        foreach ($pages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . url('/' . $page->slug) . '</loc>';
            $xml .= '<lastmod>' . $page->updated_at->toAtomString() . '</lastmod>';
            
            // Set changefreq based on category
            $changefreq = $this->getChangefreq($page->category);
            $xml .= '<changefreq>' . $changefreq . '</changefreq>';
            
            // Set priority based on category
            $priority = $this->getPriority($page->category);
            $xml .= '<priority>' . $priority . '</priority>';
            
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Get changefreq based on page category
     */
    protected function getChangefreq(string $category): string
    {
        return match ($category) {
            'events', 'news', 'media' => 'daily',
            'admissions', 'faculties' => 'weekly',
            default => 'monthly',
        };
    }

    /**
     * Get priority based on page category
     */
    protected function getPriority(string $category): string
    {
        return match ($category) {
            'about', 'admissions' => '0.9',
            'faculties', 'events' => '0.8',
            'news', 'media' => '0.7',
            default => '0.6',
        };
    }
}
