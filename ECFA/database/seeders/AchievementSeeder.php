<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Player;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = Player::all();

        if ($players->count() > 0) {
            $achievements = [
                [
                    'player_id' => 1,
                    'title' => 'Gold Medal - Épée Individual',
                    'description' => 'Won gold medal in individual épée competition',
                    'medal' => 'Gold',
                    'level' => 'National',
                    'achievement_date' => '2025-11-10',
                    'event_name' => 'National Fencing Federation Championship 2025',
                    'certificate_image' => null,
                ],
                [
                    'player_id' => 2,
                    'title' => 'Silver Medal - Foil Individual',
                    'description' => 'Won silver medal in individual foil competition',
                    'medal' => 'Silver',
                    'level' => 'State',
                    'achievement_date' => '2025-09-15',
                    'event_name' => 'State Championship 2025',
                    'certificate_image' => null,
                ],
                [
                    'player_id' => 3,
                    'title' => 'Bronze Medal - Sabre Individual',
                    'description' => 'Won bronze medal in individual sabre competition',
                    'medal' => 'Bronze',
                    'level' => 'Regional',
                    'achievement_date' => '2025-08-20',
                    'event_name' => 'Regional Tournament 2025',
                    'certificate_image' => null,
                ],
                [
                    'player_id' => 1,
                    'title' => 'Gold Medal - Épée Team',
                    'description' => 'Won gold medal as part of state épée team',
                    'medal' => 'Gold',
                    'level' => 'State',
                    'achievement_date' => '2025-09-20',
                    'event_name' => 'State Team Championship 2025',
                    'certificate_image' => null,
                ],
                [
                    'player_id' => 4,
                    'title' => 'Participation Certificate - Épée',
                    'description' => 'Participated in beginner level tournament',
                    'medal' => 'Participation',
                    'level' => 'Local',
                    'achievement_date' => '2025-07-10',
                    'event_name' => 'Local Training Tournament',
                    'certificate_image' => null,
                ],
            ];

            foreach ($achievements as $achievement) {
                Achievement::create($achievement);
            }
        }
    }
}
