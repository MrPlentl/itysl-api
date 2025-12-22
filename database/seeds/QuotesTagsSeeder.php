<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class QuotesTagsSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['QuotesSeeder', 'TagsSeeder'];
    }

    public function run(): void
    {
        $data = [
            ['quote_id' => 1, 'tag_id' => 1], // tables -> funny
            ['quote_id' => 1, 'tag_id' => 3], // tables -> viral
            ['quote_id' => 1, 'tag_id' => 4], // tables -> season-1
            ['quote_id' => 2, 'tag_id' => 2], // i-think-you-should-leave -> classic
            ['quote_id' => 2, 'tag_id' => 4], // i-think-you-should-leave -> season-1
            ['quote_id' => 3, 'tag_id' => 1], // baby-of-the-year -> funny
            ['quote_id' => 3, 'tag_id' => 4], // baby-of-the-year -> season-1
        ];

        $this->table('quote_tags')->insert($data)->saveData();
    }
}
