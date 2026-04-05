<?php

namespace Tests\Unit;

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected RoleMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new RoleMiddleware();
    }

    public function test_allows_super_admin_with_super_admin_role()
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle($request, fn() => response('OK'), 'super_admin');

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_content_editor_with_content_editor_role()
    {
        $user = User::factory()->create(['role' => 'content_editor']);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle($request, fn() => response('OK'), 'content_editor');

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_faculty_admin_with_faculty_admin_role()
    {
        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle($request, fn() => response('OK'), 'faculty_admin');

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_user_with_multiple_allowed_roles()
    {
        $user = User::factory()->create(['role' => 'content_editor']);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle(
            $request,
            fn() => response('OK'),
            'super_admin,content_editor'
        );

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_allows_super_admin_when_multiple_roles_specified()
    {
        $user = User::factory()->create(['role' => 'super_admin']);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle(
            $request,
            fn() => response('OK'),
            'super_admin,content_editor,faculty_admin'
        );

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_denies_content_editor_accessing_super_admin_route()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access this resource');

        $user = User::factory()->create(['role' => 'content_editor']);
        $request = Request::create('/admin/users', 'GET');
        $request->setUserResolver(fn() => $user);

        $this->middleware->handle($request, fn() => response('OK'), 'super_admin');
    }

    public function test_denies_faculty_admin_accessing_super_admin_route()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access this resource');

        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $request = Request::create('/admin/users', 'GET');
        $request->setUserResolver(fn() => $user);

        $this->middleware->handle($request, fn() => response('OK'), 'super_admin');
    }

    public function test_denies_faculty_admin_accessing_content_editor_only_route()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You do not have permission to access this resource');

        $user = User::factory()->create([
            'role' => 'faculty_admin',
            'faculty_category' => 'faculties'
        ]);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $this->middleware->handle($request, fn() => response('OK'), 'content_editor');
    }

    public function test_denies_unauthenticated_user()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Unauthorized access');

        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => null);

        $this->middleware->handle($request, fn() => response('OK'), 'super_admin');
    }

    public function test_handles_roles_with_spaces_in_comma_separated_list()
    {
        $user = User::factory()->create(['role' => 'content_editor']);
        $request = Request::create('/admin/test', 'GET');
        $request->setUserResolver(fn() => $user);

        $response = $this->middleware->handle(
            $request,
            fn() => response('OK'),
            'super_admin, content_editor, faculty_admin'
        );

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_returns_403_status_code_for_unauthorized_access()
    {
        try {
            $user = User::factory()->create(['role' => 'content_editor']);
            $request = Request::create('/admin/users', 'GET');
            $request->setUserResolver(fn() => $user);

            $this->middleware->handle($request, fn() => response('OK'), 'super_admin');
            $this->fail('Expected HttpException was not thrown');
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
        }
    }
}
