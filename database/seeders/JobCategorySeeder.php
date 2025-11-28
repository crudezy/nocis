<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            [
                'name' => 'Konsumsi',
                'description' => 'Tim konsumsi & catering untuk atlet dan panitia.',
                'requires_certification' => false,
                'default_shift_hours' => 8,
            ],
            [
                'name' => 'Keamanan',
                'description' => 'Pengaturan keamanan venue dan tamu VIP.',
                'requires_certification' => true,
                'default_shift_hours' => 12,
            ],
            [
                'name' => 'Akomodasi',
                'description' => 'Mengelola hotel dan kebutuhan akomodasi delegasi.',
                'requires_certification' => false,
                'default_shift_hours' => 8,
            ],
            [
                'name' => 'Transportasi',
                'description' => 'Koordinasi transportasi atlet, ofisial, dan logistik.',
                'requires_certification' => true,
                'default_shift_hours' => 10,
            ],
            [
                'name' => 'Media & Komunikasi',
                'description' => 'Publikasi, dokumentasi, dan hubungan media.',
                'requires_certification' => false,
                'default_shift_hours' => 8,
            ],
            [
                'name' => 'Medis',
                'description' => 'Penanganan medis dan tim pertolongan pertama.',
                'requires_certification' => true,
                'default_shift_hours' => 12,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('job_categories')->updateOrInsert(
                ['name' => $category['name']],
                array_merge($category, [
                    'is_active' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ])
            );
        }
    }
}
