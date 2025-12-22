<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class QuotesSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [
            'StatusesSeeder',
            'UsersSeeder',
            'ImagesSeeder',
            'SketchInfoSeeder',
            'VideosSeeder',
        ];
    }

    public function run(): void
    {
        $data = [
            [
                'slug' => 'tables',
                'quote' => 'Tables!',
                'status_id' => 1,
                'static_image_id' => 1,
                'gif_image_id' => 2,
                'sketch_info_id' => 1,
                'video_id' => 1,
                'date_posted' => '2024-01-01',
                'created_by' => 1,
            ],
            [
                'slug' => 'i-think-you-should-leave',
                'quote' => 'I think you should leave.',
                'status_id' => 1,
                'sketch_info_id' => 2,
                'date_posted' => '2024-01-02',
                'created_by' => 1,
            ],
            [
                'slug' => 'baby-of-the-year',
                'quote' => 'I\'m doing the best at this.',
                'status_id' => 1,
                'static_image_id' => 3,
                'gif_image_id' => 4,
                'sketch_info_id' => 3,
                'video_id' => 2,
                'date_posted' => '2024-01-03',
                'created_by' => 1,
            ],
        ];

        $this->table('quotes')->insert($data)->saveData();
    }
}
