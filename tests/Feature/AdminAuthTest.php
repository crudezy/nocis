<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_admin_login_page()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin-login');
    }

    /** @test */
    public function customer_cannot_access_admin_routes()
    {
        // Create a customer user
        $customer = User::factory()->create([
            'username' => 'customer',
            'password' => bcrypt('password'),
            'role' => 'customer'
        ]);

        // Customer logs in via customer login
        $response = $this->post('/login', [
            'username' => 'customer',
            'password' => 'password'
        ]);
        $response->assertRedirect('/jobs');

        // Try to access admin dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_can_login_and_access_admin_dashboard()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Admin tries to login via customer login (should fail)
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors();

        // Admin logs in via admin login
        $response = $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        $response->assertRedirect('/admin/dashboard');

        // Admin can access admin dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('menu.dashboard.dashboard');
    }

    /** @test */
    public function admin_can_logout()
    {
        // Create an admin user
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

        // Admin logs out
        $response = $this->post('/admin/logout');
        $response->assertRedirect('/admin/login');

        // Admin cannot access dashboard after logout
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_cannot_access_customer_jobs_with_authentication()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Admin logs in via admin login
        $this->post('/admin/login', [
            'username' => 'admin',
            'password' => 'admin123'
        ]);

        // Admin tries to access jobs page (should work as it's public)
        $response = $this->get('/jobs');
        $response->assertStatus(200);
    }
}
