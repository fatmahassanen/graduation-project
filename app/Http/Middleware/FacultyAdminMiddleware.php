<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacultyAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensures faculty_admin users can only access content in their assigned faculty category.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only apply to faculty_admin users
        if (!$user || !$user->isFacultyAdmin()) {
            return $next($request);
        }

        // Extract category from route parameters
        // Check common parameter names: page, content_block, category
        $category = $this->extractCategory($request);

        // If no category found in route, allow request to proceed
        // (the policy layer will handle authorization)
        if (!$category) {
            return $next($request);
        }

        // Check if faculty_admin is accessing content in their faculty category
        if ($category !== $user->faculty_category) {
            abort(403, 'You do not have permission to access content outside your faculty category');
        }

        return $next($request);
    }

    /**
     * Extract category from route parameters or model.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function extractCategory(Request $request): ?string
    {
        // Check for explicit category parameter
        if ($request->route('category')) {
            return $request->route('category');
        }

        // Check for page model
        if ($page = $request->route('page')) {
            return is_object($page) ? $page->category : null;
        }

        // Check for content_block model
        if ($contentBlock = $request->route('content_block')) {
            if (is_object($contentBlock) && $contentBlock->page) {
                return $contentBlock->page->category;
            }
        }

        // Check for media model (if it has category relationship)
        if ($media = $request->route('media')) {
            // Media doesn't have direct category, so we allow it
            // Policy layer will handle authorization
            return null;
        }

        return null;
    }
}
