<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\WorkerOpening;
use App\Models\JobCategory;
use App\Models\WorkerType;
use App\Models\City;
use App\Models\Sport;

class ActiveJobOpeningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating active job openings for customer view...\n";

        // First, ensure we have basic data
        $this->ensureBasicData();

        // Create 10 active events with future deadlines
        $this->createActiveEventsWithOpenings();

        echo "Active job openings seeder completed!\n";
    }

    private function ensureBasicData()
    {
        echo "Ensuring basic data exists...\n";

        // Create Worker Types if not exists
        $workerTypes = [
            ['name' => 'LO', 'description' => 'Local Organizer'],
            ['name' => 'VO', 'description' => 'Volunteer Organizer']
        ];

        foreach ($workerTypes as $type) {
            WorkerType::firstOrCreate(['name' => $type['name']], [
                'description' => $type['description'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create basic job categories
        $categories = [
            ['name' => 'Event Coordinator', 'worker_type_id' => 1],
            ['name' => 'Volunteer', 'worker_type_id' => 2],
            ['name' => 'Technical Support', 'worker_type_id' => 1],
            ['name' => 'Medical Support', 'worker_type_id' => 2],
            ['name' => 'Documentation Team', 'worker_type_id' => 2]
        ];

        foreach ($categories as $category) {
            JobCategory::firstOrCreate(['name' => $category['name']], [
                'description' => $category['name'] . ' position for sports events',
                'requires_certification' => false,
                'default_shift_hours' => 8,
                'is_active' => true,
                'worker_type_id' => $category['worker_type_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create cities if not exists
        $cities = [
            ['name' => 'Jakarta Selatan', 'province' => 'DKI Jakarta'],
            ['name' => 'Bandung', 'province' => 'Jawa Barat'],
            ['name' => 'Surabaya', 'province' => 'Jawa Timur'],
            ['name' => 'Medan', 'province' => 'Sumatera Utara'],
            ['name' => 'Makassar', 'province' => 'Sulawesi Selatan']
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['name' => $city['name']], $city + [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function createActiveEventsWithOpenings()
    {
        echo "Creating 10 active events with job openings...\n";

        $currentDate = Carbon::now();
        $cities = City::all();
        $sports = Sport::all();
        $categories = JobCategory::all();

        $events = [
            [
                'title' => 'Indonesia Basketball Championship 2025',
                'description' => 'Kejuaraan basket nasional untuk mempercepat perkembangan basket Indonesia',
                'start_at' => $currentDate->copy()->addDays(20)->setTime(8, 0),
                'end_at' => $currentDate->copy()->addDays(22)->setTime(20, 0),
                'venue' => 'Gelora Bung Karno Sports Complex',
                'city_id' => $cities->where('name', 'Jakarta Selatan')->first()->id,
                'status' => 'upcoming',
                'stage' => 'national',
                'penyelenggara' => 'Perbasi DKI Jakarta',
                'instagram' => '@indonesiabasketball2025',
                'email' => 'info@indonesiabasketball.org'
            ],
            [
                'title' => 'Jakarta Marathon 2025',
                'description' => 'Maraton internasional Jakarta untuk semua tingkat pelari',
                'start_at' => $currentDate->copy()->addDays(15)->setTime(5, 0),
                'end_at' => $currentDate->copy()->addDays(15)->setTime(15, 0),
                'venue' => 'Bundaran HI',
                'city_id' => $cities->where('name', 'Jakarta Selatan')->first()->id,
                'status' => 'upcoming',
                'stage' => 'international',
                'penyelenggara' => 'Jakarta Government',
                'instagram' => '@jakartamarathon',
                'email' => 'contact@jakartamarathon.id'
            ],
            [
                'title' => 'East Java Swimming Championship',
                'description' => 'Kejuaraan Renang Provinsi Jawa Timur',
                'start_at' => $currentDate->copy()->addDays(10)->setTime(7, 0),
                'end_at' => $currentDate->copy()->addDays(12)->setTime(18, 0),
                'venue' => 'Mas Tirta Swimming Pool',
                'city_id' => $cities->where('name', 'Surabaya')->first()->id,
                'status' => 'upcoming',
                'stage' => 'province',
                'penyelenggara' => 'Persatuan Renang Seluruh Indonesia Jawa Timur',
                'instagram' => '@swimmingjawatimur',
                'email' => 'renang@prsi-jateng.or.id'
            ],
            [
                'title' => 'West Java Volleyball League',
                'description' => 'Liga bola voli antar klub se-Jawa Barat',
                'start_at' => $currentDate->copy()->addDays(8)->setTime(9, 0),
                'end_at' => $currentDate->copy()->addDays(15)->setTime(21, 0),
                'venue' => 'GOR Sabil Alamsyah',
                'city_id' => $cities->where('name', 'Bandung')->first()->id,
                'status' => 'upcoming',
                'stage' => 'province',
                'penyelenggara' => 'Persatuan Bola Voli Seluruh Indonesia Jawa Barat',
                'instagram' => '@volleyjabar',
                'email' => 'volley@pvoli-jabar.or.id'
            ],
            [
                'title' => 'North Sumatra Badminton Open',
                'description' => 'Turnamen bulu tangkis terbuka Sumatera Utara',
                'start_at' => $currentDate->copy()->addDays(25)->setTime(8, 0),
                'end_at' => $currentDate->copy()->addDays(27)->setTime(19, 0),
                'venue' => 'Mikie Holiday Badminton Hall',
                'city_id' => $cities->where('name', 'Medan')->first()->id,
                'status' => 'upcoming',
                'stage' => 'province',
                'penyelenggara' => 'Persatuan Bulu Tangkis Seluruh Indonesia Sumatera Utara',
                'instagram' => '@badminton.sumut',
                'email' => 'badminton@pbsi-sumut.or.id'
            ],
            [
                'title' => 'South Sulawesi Football Tournament',
                'description' => 'Turnamen sepak bola antar klub se-Sulawesi Selatan',
                'start_at' => $currentDate->copy()->addDays(12)->setTime(15, 0),
                'end_at' => $currentDate->copy()->addDays(20)->setTime(18, 0),
                'venue' => 'Stadion Mattoanging',
                'city_id' => $cities->where('name', 'Makassar')->first()->id,
                'status' => 'upcoming',
                'stage' => 'province',
                'penyelenggara' => 'Persatuan Sepak Bola Seluruh Indonesia Sulawesi Selatan',
                'instagram' => '@footballsulsel',
                'email' => 'football@pssi-sulsel.or.id'
            ],
            [
                'title' => 'Jakarta International Tennis Open',
                'description' => 'Turnamen tenis internasional Jakarta',
                'start_at' => $currentDate->copy()->addDays(30)->setTime(9, 0),
                'end_at' => $currentDate->copy()->addDays(35)->setTime(17, 0),
                'venue' => 'Gelora Bung Karno Tennis Court',
                'city_id' => $cities->where('name', 'Jakarta Selatan')->first()->id,
                'status' => 'upcoming',
                'stage' => 'international',
                'penyelenggara' => 'Federasi Tenis Indonesia',
                'instagram' => '@jakartaopen2025',
                'email' => 'tennis@fti.or.id'
            ],
            [
                'title' => 'Bandung Fencing Championship',
                'description' => 'Kejuaraan剩剑 kota Bandung',
                'start_at' => $currentDate->copy()->addDays(18)->setTime(10, 0),
                'end_at' => $currentDate->copy()->addDays(20)->setTime(17, 0),
                'venue' => 'GOR Cisangram',
                'city_id' => $cities->where('name', 'Bandung')->first()->id,
                'status' => 'upcoming',
                'stage' => 'city',
                'penyelenggara' => 'Federasi剩剑 Indonesia Jawa Barat',
                'instagram' => '@bandungfencing',
                'email' => 'fencing@fi-jabar.or.id'
            ],
            [
                'title' => 'Surabaya Youth Basketball League',
                'description' => 'Liga basket pemuda se-Surabaya',
                'start_at' => $currentDate->copy()->addDays(14)->setTime(8, 0),
                'end_at' => $currentDate->copy()->addDays(18)->setTime(20, 0),
                'venue' => 'Surabaya Sports Hall',
                'city_id' => $cities->where('name', 'Surabaya')->first()->id,
                'status' => 'upcoming',
                'stage' => 'city',
                'penyelenggara' => 'Perbasi Surabaya',
                'instagram' => '@surabayayouthbasketball',
                'email' => 'youth@perbasi-surabaya.or.id'
            ],
            [
                'title' => 'Medan International Badminton Tournament',
                'description' => 'Turnamen bulu tangkis internasional Medan',
                'start_at' => $currentDate->copy()->addDays(22)->setTime(8, 0),
                'end_at' => $currentDate->copy()->addDays(25)->setTime(19, 0),
                'venue' => 'Medan Badminton Center',
                'city_id' => $cities->where('name', 'Medan')->first()->id,
                'status' => 'upcoming',
                'stage' => 'international',
                'penyelenggara' => 'Persatuan Bulu Tangkis Seluruh Indonesia Sumatera Utara',
                'instagram' => '@medanbadmintonopen',
                'email' => 'open@badmintonmedan.or.id'
            ]
        ];

        foreach ($events as $eventData) {
            $event = Event::firstOrCreate(
                ['title' => $eventData['title']],
                $eventData + ['created_at' => now(), 'updated_at' => now()]
            );

            // Create worker openings for this event
            $this->createWorkerOpeningsForEvent($event, $categories);
        }
    }

    private function createWorkerOpeningsForEvent($event, $categories)
    {
        echo "Creating worker openings for: {$event->title}\n";

        $baseDeadline = $event->start_at->copy()->subDays(7);
        
        $openings = [
            [
                'title' => 'Event Coordinator',
                'category' => 'Event Coordinator',
                'slots_total' => rand(2, 5),
                'application_deadline' => $baseDeadline->copy()->addDays(rand(1, 5))->setTime(23, 59),
                'benefits' => 'Honorarium 2-3 juta, sertifikat, networking opportunities',
                'status' => 'open'
            ],
            [
                'title' => 'Event Volunteer',
                'category' => 'Volunteer',
                'slots_total' => rand(10, 25),
                'application_deadline' => $baseDeadline->copy()->addDays(rand(3, 10))->setTime(23, 59),
                'benefits' => 'Seragam, makan, sertifikat relawan, referensi karier',
                'status' => 'open'
            ],
            [
                'title' => 'Technical Support Staff',
                'category' => 'Technical Support',
                'slots_total' => rand(3, 8),
                'application_deadline' => $baseDeadline->copy()->addDays(rand(2, 7))->setTime(23, 59),
                'benefits' => 'Honorarium 1.5-2.5 juta, sertifikat teknis, pengalaman broadcast',
                'status' => 'open'
            ]
        ];

        foreach ($openings as $openingData) {
            $category = $categories->where('name', $openingData['category'])->first();
            
            if (!$category) continue;

            WorkerOpening::firstOrCreate(
                [
                    'event_id' => $event->id,
                    'job_category_id' => $category->id,
                    'title' => $openingData['title'] . ' - ' . $event->title
                ],
                [
                    'description' => 'Posisi ' . $openingData['title'] . ' untuk event ' . $event->title . '. Bergabunglah dengan tim kami untuk menciptakan event olahraga yang sukses dan berkesan.',
                    'requirements' => json_encode([
                        'Enthusiastic dan commitment tinggi',
                        'Mampu bekerja dalam tim',
                        'Fleksibel dan responsif',
                        'Memiliki minat di bidang olahraga',
                        'Bersedia berkomitmen selama event berlangsung'
                    ]),
                    'slots_total' => $openingData['slots_total'],
                    'slots_filled' => rand(0, intval($openingData['slots_total'] * 0.6)),
                    'application_deadline' => $openingData['application_deadline'],
                    'benefits' => $openingData['benefits'],
                    'status' => $openingData['status'],
                    'created_at' => now()->subDays(rand(1, 10)),
                    'updated_at' => now()->subDays(rand(0, 3))
                ]
            );
        }
    }
}