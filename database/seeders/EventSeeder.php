<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $events = [
            [
                'title' => 'Asian Games 2024 Preparation Camp',
                'slug' => 'asian-games-2024-preparation',
                'description' => 'Training camp intensif jelang Asian Games 2024 untuk beberapa cabang unggulan.',
                'start_at' => Carbon::create(2024, 3, 15, 8),
                'end_at' => Carbon::create(2024, 4, 30, 18),
                'venue' => 'Jakarta Sports Complex',
                'city' => 'Jakarta',
                'status' => 'active',
                'priority' => 'high',
                'capacity' => 180,
                'contact_info' => json_encode([
                    'pic' => 'R. Hartono',
                    'phone' => '+62-812-1234-5678',
                    'email' => 'hartono@koi.id',
                ]),
            ],
            [
                'title' => 'Swimming National Championship 2024',
                'slug' => 'swimming-national-championship-2024',
                'description' => 'Kejuaraan renang nasional sebagai seleksi timnas SEA Games.',
                'start_at' => Carbon::create(2024, 6, 1, 9),
                'end_at' => Carbon::create(2024, 6, 7, 20),
                'venue' => 'National Aquatic Center',
                'city' => 'Jakarta',
                'status' => 'upcoming',
                'priority' => 'medium',
                'capacity' => 90,
                'contact_info' => json_encode([
                    'pic' => 'D. Siregar',
                    'phone' => '+62-811-9988-7766',
                    'email' => 'siregar@koi.id',
                ]),
            ],
            [
                'title' => 'Youth Olympic Qualifiers 2025',
                'slug' => 'youth-olympic-qualifiers-2025',
                'description' => 'Seleksi nasional atlet muda menuju Youth Olympic 2026.',
                'start_at' => Carbon::create(2025, 1, 10, 8),
                'end_at' => Carbon::create(2025, 1, 20, 18),
                'venue' => 'Gelora Bung Karno Arena',
                'city' => 'Jakarta',
                'status' => 'planning',
                'priority' => 'high',
                'capacity' => 220,
                'contact_info' => json_encode([
                    'pic' => 'M. Oktaviani',
                    'phone' => '+62-813-2200-1122',
                    'email' => 'oktaviani@koi.id',
                ]),
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->updateOrInsert(
                ['slug' => $event['slug']],
                array_merge($event, [
                    'owner_id' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }

        $eventSports = [
            'asian-games-2024-preparation' => [
                'BDM' => ['quota' => 24],
                'SWI' => ['quota' => 18],
                'ATH' => ['quota' => 40],
            ],
            'swimming-national-championship-2024' => [
                'SWI' => ['quota' => 32],
            ],
            'youth-olympic-qualifiers-2025' => [
                'ATH' => ['quota' => 50],
                'GYM' => ['quota' => 20],
                'BSK' => ['quota' => 30],
            ],
        ];

        foreach ($eventSports as $eventSlug => $sports) {
            $eventId = DB::table('events')->where('slug', $eventSlug)->value('id');

            if (!$eventId) {
                continue;
            }

            foreach ($sports as $sportCode => $meta) {
                $sportId = DB::table('sports')->where('code', $sportCode)->value('id');

                if (!$sportId) {
                    continue;
                }

                DB::table('event_sport')->updateOrInsert(
                    [
                        'event_id' => $eventId,
                        'sport_id' => $sportId,
                    ],
                    [
                        'quota' => $meta['quota'] ?? null,
                        'notes' => $meta['notes'] ?? null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }
    }
}
