<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class CharactersSeeder extends AbstractSeed
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
                'name' => 'Focus Group Guy',
                'actor' => 'Tim Robinson',
                'description' => 'The guy who flips the tables in the focus group',
            ],
            [
                'name' => 'Restaurant Guy',
                'actor' => 'Tim Robinson',
                'description' => 'The guy who causes a scene at dinner',
            ],
            [
                'name' => 'Baby of the Year Judge',
                'actor' => 'Tim Robinson',
                'description' => 'Judge in the Baby of the Year competition',
            ],
            [
                'name' => 'Carber Rep',
                'actor' => 'Tim Robinson',
                'description' => 'Representative from Carber Vácuum',
            ],
            [
                'name' => 'Sam Richardson Character',
                'actor' => 'Sam Richardson',
                'description' => 'Various recurring roles',
            ],
        ];

        $this->table('characters')->insert($data)->saveData();
    }
}
