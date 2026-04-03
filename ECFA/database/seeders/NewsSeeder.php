<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'State Championship 2026 Registration Open',
                'content' => 'Registration for the State Fencing Championship 2026 is now open. Limited spots available for all age categories. Register now to secure your place in this prestigious event.',
                'excerpt' => 'Registration open for State Championship 2026',
                'type' => 'Announcement',
                'created_by' => 1,
                'published_date' => '2026-04-02',
                'is_published' => true,
            ],
            [
                'title' => 'New Fencing Training Batch Starts',
                'content' => 'A new batch for beginner level fencing training has started at our Sports Academy. Classes are held every Tuesday and Thursday from 4 PM to 6 PM. Interested candidates can join anytime.',
                'excerpt' => 'New training batch started',
                'type' => 'News',
                'created_by' => 1,
                'published_date' => '2026-03-28',
                'is_published' => true,
            ],
            [
                'title' => 'Priya Singh Selected for National Team',
                'content' => 'Congratulations to Priya Singh who has been selected for the national fencing team. She will represent India in the upcoming Asian Fencing Championship. We wish her all the best!',
                'excerpt' => 'Priya Singh selected for National Team',
                'type' => 'Selection',
                'created_by' => 1,
                'published_date' => '2026-03-25',
                'is_published' => true,
            ],
            [
                'title' => 'Regional U-16 Tournament Results',
                'content' => 'The Regional Under-16 Fencing Tournament concluded successfully. Raj Kumar won gold in Sabre, Neha Sharma won silver in Épée. Full results available on our website.',
                'excerpt' => 'Tournament results announced',
                'type' => 'Update',
                'created_by' => 1,
                'published_date' => '2026-03-20',
                'is_published' => true,
            ],
            [
                'title' => 'ECFA Achievement Milestone',
                'content' => 'East Champaran Fencing Association has crossed 500 registered players! This is a proud moment for our organization. We thank all our members and coaches for their dedication.',
                'excerpt' => 'ECFA crosses 500 members',
                'type' => 'News',
                'created_by' => 1,
                'published_date' => '2026-03-15',
                'is_published' => true,
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
