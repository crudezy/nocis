<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class MenuAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_all_menu_items()
    {
        // Create admin user
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Admin logs in
        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);

        // Admin can access all menu items
        $menuItems = [
            '/admin/dashboard' => 'admin.dashboard',
            '/admin/analytics' => 'admin.analytics',
            '/admin/events' => 'admin.events.index',
            '/admin/workers' => 'admin.workers.index',
            '/admin/categories' => 'admin.categories.index',
            '/admin/sports' => 'admin.sports.index',
            '/admin/reviews' => 'admin.reviews.index',
        ];

        foreach ($menuItems as $url => $routeName) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $response->assertViewIs($this->getExpectedView($routeName));
        }
    }

    /** @test */
    public function customer_cannot_access_any_admin_menu_items()
    {
        // Create customer user
        $customer = User::factory()->create([
            'username' => 'customer',
            'password' => bcrypt('customer123'),
            'role' => 'customer'
        ]);

        // Customer logs in via customer login
        $this->post('/login', [
            'username' => 'customer',
            'password' => 'customer123'
        ]);

        // Customer cannot access any admin menu items
        $adminRoutes = [
            '/admin/dashboard',
            '/admin/analytics',
            '/admin/events',
            '/admin/workers',
            '/admin/categories',
            '/admin/sports',
            '/admin/reviews',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/admin/login');
            $response->assertSessionHas('error');
        }
    }

    /** @test */
    public function customer_can_only_access_customer_features()
    {
        // Create customer user
        $customer = User::factory()->create([
            'username' => 'customer',
            'password' => bcrypt('customer123'),
            'role' => 'customer'
        ]);

        // Customer logs in
        $this->post('/login', [
            'username' => 'customer',
            'password' => 'customer123'
        ]);

        // Customer can access customer features
        $customerRoutes = [
            '/jobs',
            '/jobs/1', // Assuming job exists
        ];

        foreach ($customerRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function admin_can_access_customer_features()
    {
        // Create admin user
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Admin logs in via admin portal
        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);

        // Admin can access public customer features
        $response = $this->get('/jobs');
        $response->assertStatus(200);
    }

    private function getExpectedView($routeName)
    {
        $viewMap = [
            'admin.dashboard' => 'menu.dashboard.dashboard',
            'admin.analytics' => 'menu.dashboard.analytics',
            'admin.events.index' => 'menu.events.index',
            'admin.workers.index' => 'menu.workers.index',
            'admin.categories.index' => 'menu.categories.index',
            'admin.sports.index' => 'menu.sports.index',
            'admin.reviews.index' => 'menu.reviews.index',
        ];

        return $viewMap[$routeName] ?? 'menu.dashboard.dashboard';
    }
}
