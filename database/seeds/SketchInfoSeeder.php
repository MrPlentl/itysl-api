<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class SketchInfoSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return [];
    }

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
                'sketch_name' => 'Focus Group',
                'episode' => 'S01E01',
                'season' => 1,
                'episode_number' => 1,
            ],
            [
                'sketch_name' => 'The Dinner',
                'episode' => 'S01E01',
                'season' => 1,
                'episode_number' => 1,
            ],
            [
                'sketch_name' => 'Baby of the Year',
                'episode' => 'S01E03',
                'season' => 1,
                'episode_number' => 3,
            ],
            [
                'sketch_name' => 'Carver Vacuum',
                'episode' => 'S01E04',
                'season' => 1,
                'episode_number' => 4,
            ],
        ];

        $this->table('sketch_info')->insert($data)->saveData();
    }
}
