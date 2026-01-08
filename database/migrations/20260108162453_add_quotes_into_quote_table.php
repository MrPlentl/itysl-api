<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddQuotesIntoQuoteTable extends AbstractMigration
{
    public function up(): void
    {
        $rows = [
            ['gif_image_id' => 5,  'slug' => 'are-you-choking', 'quote' => 'Are You Choking?'],
            ['gif_image_id' => 6,  'slug' => 'you-sure-about-that-01', 'quote' => 'You Sure About That?'],
            ['gif_image_id' => 7,  'slug' => 'blues-brothers-dance-01', 'quote' => 'Blues Brothers Dance'],
            ['gif_image_id' => 8,  'slug' => 'theyre-coming-after-me-in-the-comments', 'quote' => "They're Coming After Me In The Comments!"],
            ['gif_image_id' => 9,  'slug' => 'confused-01', 'quote' => 'Confused'],
            ['gif_image_id' => 10, 'slug' => 'crazy-dance-01', 'quote' => 'Crazy Dance'],
            ['gif_image_id' => 11, 'slug' => 'frustrated-01', 'quote' => 'Frustrated'],
            ['gif_image_id' => 12, 'slug' => 'give-me-that', 'quote' => 'Give Me That'],
            ['gif_image_id' => 13, 'slug' => 'glad-youre-here-shirt-brother', 'quote' => "Glad You're Here Shirt Brother"],
            ['gif_image_id' => 14, 'slug' => 'happy-01', 'quote' => 'Happy'],
            ['gif_image_id' => 15, 'slug' => 'i-cant-01', 'quote' => "I Can't!"],
            ['gif_image_id' => 16, 'slug' => 'i-dont-know-if-ive-ever-gotten-here-before', 'quote' => "I Don't Know If I've Ever Gotten Here Before"],
            ['gif_image_id' => 17, 'slug' => 'i-dont-remember-the-words', 'quote' => "I Don't Remember The Words"],
            ['gif_image_id' => 18, 'slug' => 'if-you-start-to-win-i-go-on-my-phone', 'quote' => 'And If You Start To Win I Go On My Phone'],
            ['gif_image_id' => 19, 'slug' => 'ill-eat-dougs-moms-wig', 'quote' => "I'll Eat Doug's Mom's Wig"],
            ['gif_image_id' => 20, 'slug' => 'ill-think-of-something', 'quote' => "I'll Think Of Something"],
            ['gif_image_id' => 21, 'slug' => 'im-going-on-a-date', 'quote' => "I'm Going On A Date"],
            ['gif_image_id' => 22, 'slug' => 'it-actually-goes-both-ways', 'quote' => 'It Actually Goes Both Ways'],
            ['gif_image_id' => 23, 'slug' => 'it-does-hurt-actually', 'quote' => 'It Does Hurt Actually'],
            ['gif_image_id' => 24, 'slug' => 'jaime-taco-01', 'quote' => "But I'm Never Gonna Say My Lines Faster Than Jamie Taco"],
            ['gif_image_id' => 25, 'slug' => 'let-me-think-about-it-for-a-minute-01', 'quote' => 'Let Me Think About It For A Minute'],
            ['gif_image_id' => 26, 'slug' => 'look-im-barney', 'quote' => "Hey Look at Me, I'm Barney!"],
            ['gif_image_id' => 27, 'slug' => 'make-any-friends', 'quote' => 'Make Any Friends? Not really.'],
            ['gif_image_id' => 28, 'slug' => 'my-mom-drank-puke', 'quote' => 'My Mom Drank Puke for trips to Florida'],
            ['gif_image_id' => 29, 'slug' => 'nobody-likes-your-house-anyway', 'quote' => 'Nobody Likes Your House Anyway'],
            ['gif_image_id' => 30, 'slug' => 'okay-01', 'quote' => 'Okay!'],
            ['gif_image_id' => 31, 'slug' => 'perfect', 'quote' => 'Perfect'],
            ['gif_image_id' => 32, 'slug' => 'say-that-again', 'quote' => "What's that? Say That Again."],
            ['gif_image_id' => 33, 'slug' => 'skeletons-came-to-life', 'quote' => 'And it was also the night that the Skeletons Came To Life!'],
            ['gif_image_id' => 34, 'slug' => 'such-a-big-fan-of-him', 'quote' => 'He wanted to own his life or something. Such A Big Fan Of Him.'],
            ['gif_image_id' => 35, 'slug' => 'tc-tuggers-01', 'quote' => 'TC Tuggers Dance'],
            ['gif_image_id' => 36, 'slug' => 'tc-tuggers-02', 'quote' => 'TC Tuggers'],
            ['gif_image_id' => 37, 'slug' => 'thats-not-the-problem', 'quote' => "That's Not The Problem"],
            ['gif_image_id' => 38, 'slug' => 'they-said-that-to-me-at-a-dinner', 'quote' => 'They Said That To Me At A Dinner'],
            ['gif_image_id' => 39, 'slug' => 'um-okay-01', 'quote' => 'Um... Okay'],
            ['gif_image_id' => 40, 'slug' => 'we-got-a-deal-or-not', 'quote' => 'We Got A Deal Or Not?'],
            ['gif_image_id' => 41, 'slug' => 'what-01', 'quote' => 'What?'],
            ['gif_image_id' => 42, 'slug' => 'wth2', 'quote' => 'What the hell is going on out there?'],
            ['gif_image_id' => 43, 'slug' => 'youre-not-following-me-on-instagram', 'quote' => "You're Not Following Me On Instagram!"],
            ['gif_image_id' => 44, 'slug' => 'youre-not-gonna-talk-about-your-kids-an-ounce', 'quote' => "You're Not Gonna Talk About Your Kids An Ounce!"],
        ];

        foreach ($rows as &$row) {
            $row['status_id'] = 1;
        }

        $this->table('quotes')->insert($rows)->saveData();
    }
}
