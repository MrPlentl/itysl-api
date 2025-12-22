<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class ImagesSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['UsersSeeder'];
    }

    public function run(): void
    {
        $data = [
            [
                'filename' => 'tables.jpg',
                'alt_text' => 'Tables scene from Focus Group',
                'type' => 'static',
            ],
            [
                'filename' => 'tables.gif',
                'alt_text' => 'Tables animated gif',
                'type' => 'gif',
            ],
            [
                'filename' => 'baby.jpg',
                'alt_text' => 'Baby of the Year screenshot',
                'type' => 'static',
            ],
            [
                'filename' => 'baby.gif',
                'alt_text' => 'Baby of the Year gif',
                'type' => 'gif',
            ],
        ];

        $this->table('images')->insert($data)->saveData();
    }
}
