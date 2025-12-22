<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class QuoteCharactersSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['QuotesSeeder', 'CharactersSeeder'];
    }

    public function run(): void
    {
        $data = [
            ['quote_id' => 1, 'character_id' => 1],  // tables -> Focus Group Guy
            ['quote_id' => 2, 'character_id' => 2],  // i-think-you-should-leave -> Restaurant Guy
            ['quote_id' => 3, 'character_id' => 3],  // baby-of-the-year -> Baby Judge
        ];

        $this->table('quote_characters')->insert($data)->saveData();
    }
}
