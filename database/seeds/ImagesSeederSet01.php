<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class ImagesSeederSet01 extends AbstractSeed
{
    public function run(): void
    {
        $filenames = [
            'are-you-choking.gif',
            'are-you-sure-about-that-01.gif',
            'blues-brothers-dance-01.gif',
            'coming-after-me-in-the-comments.gif',
            'confused-01.gif',
            'crazy-dance-01.gif',
            'frustrated-01.gif',
            'give-me-that.gif',
            'glad-youre-here-shirt-brother.gif',
            'happy-01.gif',
            'i-cant-01.gif',
            'i-dont-know-if-ive-ever-gotten-here-before.gif',
            'i-dont-remember-the-words.gif',
            'if-you-start-to-win-i-go-on-my-phone.gif',
            'ill-eat-dougs-moms-wig.gif',
            'ill-think-of-something.gif',
            'im-going-on-a-date.gif',
            'it-actually-goes-both-ways.gif',
            'it-does-hurt-actually.gif',
            'jaime-taco-01.gif',
            'let-me-think-about-it-for-a-minute-01.gif',
            'look-im-barney.gif',
            'make-any-friends.gif',
            'my-mom-drank-puke.gif',
            'nobody-likes-your-house-anyway.gif',
            'okay-01.gif',
            'perfect.gif',
            'say-that-again.gif',
            'skeletons-came-to-life.gif',
            'such-a-big-fan-of-him.gif',
            'tc-tuggers-01.gif',
            'tc-tuggers-02.gif',
            'thats-not-the-problem.gif',
            'they-said-that-to-me-at-a-dinner.gif',
            'um-okay-01.gif',
            'we-got-a-deal-or-not.gif',
            'what-01.gif',
            'wth2.gif',
            'youre-not-following-me-on-instagram.gif',
            'youre-not-gonna-talk-about-your-kids-an-ounce.gif',
        ];

        $data = [];

        foreach ($filenames as $filename) {
            $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
            $altText = ucfirst(str_replace('-', ' ', $nameWithoutExt));

            $data[] = [
                'filename' => $filename,
                'alt_text' => $altText,
                'type' => 'gif',
            ];
        }

        $this->table('images')->insert($data)->save();
    }
}
