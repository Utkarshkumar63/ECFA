<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'State Fencing Championship 2026',
                'description' => 'Annual state level fencing championship featuring epee, foil and sabre competitions',
                'event_date' => '2026-05-15',
                'venue' => 'Sports Complex, Motihari',
                'venue_address' => 'Sports Complex, Motihari, East Champaran, Bihar',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'status' => 'Upcoming',
                'max_participants' => 100,
                'rules' => 'International Fencing Federation rules apply',
                'is_registration_open' => true,
                'registration_end_date' => '2026-05-10',
            ],
            [
                'title' => 'Regional U-16 Fencing Tournament',
                'description' => 'Regional tournament for under-16 fencers from East Champaran and nearby regions',
                'event_date' => '2026-04-20',
                'venue' => 'Training Center, East Champaran',
                'venue_address' => 'Fencing Training Center, East Champaran',
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
                'status' => 'Upcoming',
                'max_participants' => 50,
                'rules' => 'Youth category rules',
                'is_registration_open' => true,
                'registration_end_date' => '2026-04-15',
            ],
            [
                'title' => 'Beginner Training Camp',
                'description' => 'Week-long training camp for beginners interested in learning fencing',
                'event_date' => '2026-04-01',
                'venue' => 'Sports Academy, East Champaran',
                'venue_address' => 'Sports Academy, East Champaran',
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'status' => 'Ongoing',
                'max_participants' => 30,
                'rules' => 'Basic safety and equipment rules',
                'is_registration_open' => true,
                'registration_end_date' => '2026-03-30',
            ],
            [
                'title' => 'National Fencing Federation Championship 2025',
                'description' => 'Past national championship',
                'event_date' => '2025-11-10',
                'venue' => 'National Sports Complex, Delhi',
                'venue_address' => 'Delhi',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'status' => 'Completed',
                'max_participants' => 200,
                'rules' => 'International Fencing Federation rules',
                'is_registration_open' => false,
                'registration_end_date' => '2025-11-05',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
