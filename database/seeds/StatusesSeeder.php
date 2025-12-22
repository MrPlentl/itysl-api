<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class StatusesSeeder extends AbstractSeed
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
            ['id' => 1, 'name' => 'published', 'description' => 'Quote is live and visible'],
            ['id' => 2, 'name' => 'draft', 'description' => 'Quote is being edited'],
            ['id' => 3, 'name' => 'archived', 'description' => 'Quote is hidden but not deleted'],
            ['id' => 4, 'name' => 'pending', 'description' => 'Quote awaiting approval'],
        ];

        $this->table('statuses')->insert($data)->saveData();
    }
}
