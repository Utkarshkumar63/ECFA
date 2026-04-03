<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = [
            [
                'name' => 'Priya Singh',
                'date_of_birth' => '2008-05-15',
                'gender' => 'Female',
                'email' => 'priya@example.com',
                'phone' => '9123456789',
                'address' => '123 Main St, East Champaran',
                'category' => 'U-18',
                'event_type' => 'Épée',
                'bio' => 'National level fencer with gold medals',
                'emergency_contact' => 'Rajesh Singh',
                'emergency_phone' => '9123456780',
                'is_active' => true,
            ],
            [
                'name' => 'Anuj Kumar',
                'date_of_birth' => '2006-08-22',
                'gender' => 'Male',
                'email' => 'anuj@example.com',
                'phone' => '9123456790',
                'address' => '456 Oak Ave, East Champaran',
                'category' => 'U-18',
                'event_type' => 'Foil',
                'bio' => 'State level fencer, rising talent',
                'emergency_contact' => 'Vikram Kumar',
                'emergency_phone' => '9123456781',
                'is_active' => true,
            ],
            [
                'name' => 'Raj Kumar',
                'date_of_birth' => '2007-03-10',
                'gender' => 'Male',
                'email' => 'raj@example.com',
                'phone' => '9123456791',
                'address' => '789 Pine Rd, East Champaran',
                'category' => 'U-16',
                'event_type' => 'Sabre',
                'bio' => 'Young talented fencer',
                'emergency_contact' => 'Ashok Kumar',
                'emergency_phone' => '9123456782',
                'is_active' => true,
            ],
            [
                'name' => 'Neha Sharma',
                'date_of_birth' => '2009-11-05',
                'gender' => 'Female',
                'email' => 'neha@example.com',
                'phone' => '9123456792',
                'address' => '321 Elm St, East Champaran',
                'category' => 'U-14',
                'event_type' => 'Épée',
                'bio' => 'Beginner fencer with potential',
                'emergency_contact' => 'Ramesh Sharma',
                'emergency_phone' => '9123456783',
                'is_active' => true,
            ],
            [
                'name' => 'Vikram Patel',
                'date_of_birth' => '2005-07-20',
                'gender' => 'Male',
                'email' => 'vikram@example.com',
                'phone' => '9123456793',
                'address' => '654 Birch Ln, East Champaran',
                'category' => 'Senior',
                'event_type' => 'Foil',
                'bio' => 'Veteran fencer and coach',
                'emergency_contact' => 'Suresh Patel',
                'emergency_phone' => '9123456784',
                'is_active' => true,
            ],
        ];

        foreach ($players as $player) {
            Player::create($player);
        }
    }
}
