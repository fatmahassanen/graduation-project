<?php

namespace Tests\Unit;

use App\Http\Middleware\FacultyAdminMiddleware;
use App\Models\ContentBlock;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class FacultyAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected FacultyAdminMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new FacultyAdminMiddleware();
    }

    public function test_allows_super_admin_to_access_any_category()
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $request = $this->createRequestWithRoute($user, $page);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_content_editor_to_access_any_category()
    {
        $user = User::factory()->create(['role' => 'content_editor']);
        $page = Page::factory()->create(['category' => 'admissions']);

        $request = $this->createRequestWithRoute($user, $page);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_faculty_admin_to_access_their_faculty_category()
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);

        $request = $this->createRequestWithRoute($user, $page);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_denies_faculty_admin_accessing_different_faculty_category()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access content outside your faculty category');

        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);

        $request = $this->createRequestWithRoute($user, $page);

        $this->middleware->handle($request, fn() => response('OK'));
    }

    public function test_allows_faculty_admin_when_no_category_in_route()
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);

        $request = Request::create('/admin/dashboard', 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/dashboard', []);
        $route->bind($request);
        $request->setRouteResolver(fn() => $route);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_extracts_category_from_explicit_category_parameter()
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);

        $request = Request::create('/admin/pages/category/faculties', 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/pages/category/{category}', []);
        $route->bind($request);
        $route->setParameter('category', 'faculties');
        $request->setRouteResolver(fn() => $route);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_denies_faculty_admin_with_explicit_wrong_category_parameter()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access content outside your faculty category');

        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);

        $request = Request::create('/admin/pages/category/admissions', 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/pages/category/{category}', []);
        $route->bind($request);
        $route->setParameter('category', 'admissions');
        $request->setRouteResolver(fn() => $route);

        $this->middleware->handle($request, fn() => response('OK'));
    }

    public function test_extracts_category_from_content_block_page_relationship()
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $page = Page::factory()->create(['category' => 'faculties']);
        $contentBlock = ContentBlock::factory()->create(['page_id' => $page->id]);

        $request = Request::create('/admin/content-blocks/' . $contentBlock->id, 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/content-blocks/{content_block}', []);
        $route->bind($request);
        $route->setParameter('content_block', $contentBlock);
        $request->setRouteResolver(fn() => $route);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_denies_faculty_admin_accessing_content_block_from_wrong_category()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access content outside your faculty category');

        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $page = Page::factory()->create(['category' => 'admissions']);
        $contentBlock = ContentBlock::factory()->create(['page_id' => $page->id]);

        $request = Request::create('/admin/content-blocks/' . $contentBlock->id, 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/content-blocks/{content_block}', []);
        $route->bind($request);
        $route->setParameter('content_block', $contentBlock);
        $request->setRouteResolver(fn() => $route);

        $this->middleware->handle($request, fn() => response('OK'));
    }

    public function test_allows_unauthenticated_request_to_pass_through()
    {
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => null);
        $route = new Route('GET', '/admin/test', []);
        $request->setRouteResolver(fn() => $route);

        $response = $this->middleware->handle($request, fn() => response('OK'));

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_returns_403_status_code_for_unauthorized_faculty_access()
    {
        try {
            $user = User::factory()->create([
                'role' => 'faculty_admin',
                'faculty_category' => 'faculties'
            ]);
            $page = Page::factory()->create(['category' => 'admissions']);

            $request = $this->createRequestWithRoute($user, $page);

            $this->middleware->handle($request, fn() => response('OK'));
            $this->fail('Expected HttpException was not thrown');
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }

    /**
     * Helper method to create a request with route and page parameter.
     */
    protected function createRequestWithRoute(User $user, Page $page): Request
    {
        $request = Request::create('/admin/pages/' . $page->id, 'GET');
        $request->setUserResolver(fn() => $user);
        $route = new Route('GET', '/admin/pages/{page}', []);
        $route->bind($request);
        $route->setParameter('page', $page);
        $request->setRouteResolver(fn() => $route);

        return $request;
    }
}
