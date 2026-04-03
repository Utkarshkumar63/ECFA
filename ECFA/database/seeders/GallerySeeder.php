<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gallery = [
            [
                'title' => 'State Championship 2025 - Final Match',
                'description' => 'Highlights from the state championship final match',
                'media_type' => 'Image',
                'media_url' => 'https://via.placeholder.com/800x600?text=State+Championship+Final',
                'thumbnail_url' => 'https://via.placeholder.com/200x150?text=Thumbnail',
                'event_id' => 4,
                'caption' => 'Final match in progress',
                'display_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Training Session - Beginner Class',
                'description' => 'Beginner level fencing training session',
                'media_type' => 'Image',
                'media_url' => 'https://via.placeholder.com/800x600?text=Training+Session',
                'thumbnail_url' => 'https://via.placeholder.com/200x150?text=Training',
                'event_id' => 3,
                'caption' => 'Beginners learning basic techniques',
                'display_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Team Celebration',
                'description' => 'Team photo after winning the championship',
                'media_type' => 'Image',
                'media_url' => 'https://via.placeholder.com/800x600?text=Team+Celebration',
                'thumbnail_url' => 'https://via.placeholder.com/200x150?text=Team',
                'event_id' => null,
                'caption' => 'Victorious team',
                'display_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Championship Highlights - Video',
                'description' => 'Video highlights from championship matches',
                'media_type' => 'Video',
                'media_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://via.placeholder.com/200x150?text=Video',
                'event_id' => 4,
                'caption' => 'Watch championship highlights',
                'display_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($gallery as $item) {
            Gallery::create($item);
        }
    }
}
