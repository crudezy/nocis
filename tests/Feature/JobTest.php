<?php

namespace Tests\Feature;

use App\Models\WorkerOpening;
use App\Models\City;
use App\Models\JobCategory;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_index_route_works()
    {
        $response = $this->get('/jobs');
        $response->assertStatus(200);
    }

    public function test_job_show_route_works()
    {
        // Create test data
        $city = City::create([
            'name' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'type' => 'Kota',
            'is_active' => true,
        ]);

        $category = JobCategory::create([
            'name' => 'Security',
            'description' => 'Security personnel',
            'requires_certification' => true,
            'default_shift_hours' => 8,
            'is_active' => true,
        ]);

        $event = Event::create([
            'title' => 'Test Event',
            'description' => 'Test event description',
            'start_at' => now()->addDays(30),
            'end_at' => now()->addDays(35),
            'venue' => 'Test Venue',
            'city_id' => $city->id,
            'status' => 'active',
            'stage' => 'planning',
        ]);

        $job = WorkerOpening::create([
            'event_id' => $event->id,
            'job_category_id' => $category->id,
            'title' => 'Test Security Officer',
            'description' => 'Test job description',
            'requirements' => ['Requirement 1', 'Requirement 2'],
            'slots_total' => 10,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Test benefits',
            'status' => 'open',
        ]);

        $response = $this->get("/jobs/{$job->id}");
        $response->assertStatus(200);
        $response->assertSee('Test Security Officer');
    }

    public function test_job_filtering_by_city()
    {
        // Create test data
        $jakarta = City::create([
            'name' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'type' => 'Kota',
            'is_active' => true,
        ]);

        $bandung = City::create([
            'name' => 'Bandung',
            'province' => 'Jawa Barat',
            'type' => 'Kota',
            'is_active' => true,
        ]);

        $category = JobCategory::create([
            'name' => 'Security',
            'description' => 'Security personnel',
            'requires_certification' => true,
            'default_shift_hours' => 8,
            'is_active' => true,
        ]);

        $eventJakarta = Event::create([
            'title' => 'Jakarta Event',
            'description' => 'Event in Jakarta',
            'start_at' => now()->addDays(30),
            'end_at' => now()->addDays(35),
            'venue' => 'Jakarta Venue',
            'city_id' => $jakarta->id,
            'status' => 'active',
            'stage' => 'planning',
        ]);

        $eventBandung = Event::create([
            'title' => 'Bandung Event',
            'description' => 'Event in Bandung',
            'start_at' => now()->addDays(40),
            'end_at' => now()->addDays(45),
            'venue' => 'Bandung Venue',
            'city_id' => $bandung->id,
            'status' => 'active',
            'stage' => 'planning',
        ]);

        $jobJakarta = WorkerOpening::create([
            'event_id' => $eventJakarta->id,
            'job_category_id' => $category->id,
            'title' => 'Jakarta Security Officer',
            'description' => 'Security job in Jakarta',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Jakarta benefits',
            'status' => 'open',
        ]);

        $jobBandung = WorkerOpening::create([
            'event_id' => $eventBandung->id,
            'job_category_id' => $category->id,
            'title' => 'Bandung Security Officer',
            'description' => 'Security job in Bandung',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Bandung benefits',
            'status' => 'open',
        ]);

        // Test filtering by Jakarta
        $response = $this->get('/jobs?city=Jakarta');
        $response->assertStatus(200);
        $response->assertSee('Jakarta Security Officer');
        $response->assertDontSee('Bandung Security Officer');
    }

    public function test_job_filtering_by_category()
    {
        // Create test data
        $city = City::create([
            'name' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'type' => 'Kota',
            'is_active' => true,
        ]);

        $securityCategory = JobCategory::create([
            'name' => 'Security',
            'description' => 'Security personnel',
            'requires_certification' => true,
            'default_shift_hours' => 8,
            'is_active' => true,
        ]);

        $medicalCategory = JobCategory::create([
            'name' => 'Medical',
            'description' => 'Medical personnel',
            'requires_certification' => true,
            'default_shift_hours' => 8,
            'is_active' => true,
        ]);

        $event = Event::create([
            'title' => 'Test Event',
            'description' => 'Test event description',
            'start_at' => now()->addDays(30),
            'end_at' => now()->addDays(35),
            'venue' => 'Test Venue',
            'city_id' => $city->id,
            'status' => 'active',
            'stage' => 'planning',
        ]);

        $securityJob = WorkerOpening::create([
            'event_id' => $event->id,
            'job_category_id' => $securityCategory->id,
            'title' => 'Security Officer',
            'description' => 'Security job',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Security benefits',
            'status' => 'open',
        ]);

        $medicalJob = WorkerOpening::create([
            'event_id' => $event->id,
            'job_category_id' => $medicalCategory->id,
            'title' => 'Medical Officer',
            'description' => 'Medical job',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Medical benefits',
            'status' => 'open',
        ]);

        // Test filtering by Security category
        $response = $this->get('/jobs?category=' . $securityCategory->id);
        $response->assertStatus(200);
        $response->assertSee('Security Officer');
        $response->assertDontSee('Medical Officer');
    }

    public function test_job_search_functionality()
    {
        // Create test data
        $city = City::create([
            'name' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'type' => 'Kota',
            'is_active' => true,
        ]);

        $category = JobCategory::create([
            'name' => 'Security',
            'description' => 'Security personnel',
            'requires_certification' => true,
            'default_shift_hours' => 8,
            'is_active' => true,
        ]);

        $event = Event::create([
            'title' => 'Test Event',
            'description' => 'Test event description',
            'start_at' => now()->addDays(30),
            'end_at' => now()->addDays(35),
            'venue' => 'Test Venue',
            'city_id' => $city->id,
            'status' => 'active',
            'stage' => 'planning',
        ]);

        $job1 = WorkerOpening::create([
            'event_id' => $event->id,
            'job_category_id' => $category->id,
            'title' => 'Senior Security Officer',
            'description' => 'Senior security job',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Senior benefits',
            'status' => 'open',
        ]);

        $job2 = WorkerOpening::create([
            'event_id' => $event->id,
            'job_category_id' => $category->id,
            'title' => 'Junior Security Officer',
            'description' => 'Junior security job',
            'requirements' => ['Requirement 1'],
            'slots_total' => 5,
            'slots_filled' => 0,
            'application_deadline' => now()->addDays(15),
            'benefits' => 'Junior benefits',
            'status' => 'open',
        ]);

        // Test search for "Senior"
        $response = $this->get('/jobs?search=Senior');
        $response->assertStatus(200);
        $response->assertSee('Senior Security Officer');
        $response->assertDontSee('Junior Security Officer');
    }
}