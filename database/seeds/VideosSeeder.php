<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class VideosSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Focus Group - Tables',
                'url' => 'https://www.netflix.com/watch/80986854',
                'platform' => 'netflix',
            ],
            [
                'title' => 'Both Ways',
                'url' => 'v701kbw',
                'platform' => 'rumble',
            ],
        ];

        $this->table('videos')->insert($data)->saveData();
    }
}
