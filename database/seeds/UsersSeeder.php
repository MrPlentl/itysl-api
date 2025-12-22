<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
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
                'username' => 'admin',
                'email' => 'admin@itysl-api.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'username' => 'editor',
                'email' => 'editor@itysl-api.com',
                'password_hash' => password_hash('editor123', PASSWORD_DEFAULT),
                'role' => 'editor',
                'is_active' => true,
            ],
        ];

        $this->table('users')->insert($data)->saveData();
    }
}
