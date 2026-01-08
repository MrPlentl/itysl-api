<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class EpisodeInfoSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'platform' => 'Netflix',
                'show' => 'The Characters',
                'name' => 'Tim Robinson',
                'season' => 1,
                'episode' => 7,
                'description' => 'Tim Robinson breaks out characters like a frenzied Rat Pack wannabe, a disturbed limo employee, a gun shopper with bathroom issues and more.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Has This Ever Happened to You?',
                'season' => 1,
                'episode' => 1,
                'description' => 'An awkward exit at a job interview. A very specific legal problem. Things get ugly at the “Baby of the Year” contest. A gift receipt causes stress.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Thanks for Thinking They Are Cool',
                'season' => 1,
                'episode' => 2,
                'description' => 'A nifty new tug-friendly T-shirt. The smart way to ditch your toupee. A prank doesn’t go so well. An airline passenger gets aggressively creepy.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'It’s the Cigars You Smoke That Are Going to Give You Cancer',
                'season' => 1,
                'episode' => 3,
                'description' => 'A magic show opens up a marital rift. Interesting ideas at a car design brainstorm. A fill-in organist at a funeral. A very esoteric charades player.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Oh Crap, a Bunch More Bad Stuff Just Happened',
                'season' => 1,
                'episode' => 4,
                'description' => 'A service dog gets super friendly. Ebenezer Scrooge and the Ghost of Christmas Way-Future. A man takes a bumper sticker way too literally.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'I’m Wearing One of Their Belts Right Now',
                'season' => 1,
                'episode' => 5,
                'description' => 'A hot dog–shaped car crash. A co-worker latches on to an expression. Music studio riffing goes awry. An excuse for tardiness spirals out of control.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'We Used to Watch This at My Old Work',
                'season' => 1,
                'episode' => 6,
                'description' => 'A solution to equine-related emasculation. A problematic game show mascot. Baby shower planning gets heated. A weird place to hold an intervention.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'They Said That to Me at a Dinner.',
                'season' => 2,
                'episode' => 1,
                'description' => 'An unplanned meeting leads to lunchtime chaos. An unusual reality show. A prank show at the mall causes an existential crisis. The “Little Buff Boys” competition. A ghost tour guest goes too far.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'They Have a Cake Shop There, Susan, Where the Cakes Just Look Stunning.',
                'season' => 2,
                'episode' => 2,
                'description' => 'An office dispute over shirt patterns. A little lie about the ice cream store escalates quickly. A man suspects a baby is aware of his checkered past.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'You Sure About That? You Sure About That, That’s Why?',
                'season' => 2,
                'episode' => 3,
                'description' => 'A professor really regrets his dinner order. The Carber hot dog vacuum. “Detective Crashmore”. A hat has its day in court.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Everyone just needds to be more in the moment.',
                'season' => 2,
                'episode' => 4,
                'description' => 'An offhanded joke leaves a husband guilt-ridden. A trip backfires while trying to ease tensions. A pants-centric website with a specific purpose.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Didn\'t you say there were going to be five people at this table?',
                'season' => 2,
                'episode' => 5,
                'description' => 'A novice driver in a parking lot. Defying the rules of credit card roulette. Celebrity impersonators get unruly. Date night at a cosmos-themed bar.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'I need a wet paper towel.',
                'season' => 2,
                'episode' => 6,
                'description' => 'A mistaken identity at work. The new “Tammy Craps” doll. Some interesting instructional videos during a driver’s ed class. An attempted ear-piercing.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'That Was the Earth Telling Me I’m Supposed to Do Something Great.',
                'season' => 3,
                'episode' => 1,
                'description' => 'A TV pundit copes with conflict. Team building breaks down. Is Ronnie here for the right reasons? A dad tries to look tough. James asks for a ride home.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'I Can Do Whatever I Want.',
                'season' => 3,
                'episode' => 2,
                'description' => 'A VR shopping spree takes a turn. Consider a high-security dog door! Ponytail problems. A bad egg at the office. Old wounds surface at a sitcom taping.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Cut to: We’re Chatting About This at Your Bachelor Party.',
                'season' => 3,
                'episode' => 3,
                'description' => 'A silent performer builds a hostile fanbase. First date jitters. A doctor monitors a patient’s heart. Paying it forward. Catharsis at an office party.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'So Now Every Time I’m About to Do Something I Really Want to Do, I Ask Myself, “Wait a Minute, What Is This?”',
                'season' => 3,
                'episode' => 4,
                'description' => 'Stuart’s co-workers learn about his friend group. A proposal spot does double duty. Try Gelutol! Goodbye, Ronnie. Matching shirts at a school concert.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'Don’t Just Say “Relax,” Actually Relax.',
                'season' => 3,
                'episode' => 5,
                'description' => 'Amanda, do not say Randall is interesting. Father of the bride vs. a wedding photo booth. A new small-talk strategy at a party yields unexpected results.',
            ],
            [
                'platform' => 'Netflix',
                'name' => 'When I First Thought of This You Didn’t Even Have Hands Up There — You Were Just Walking Straight Up the Wall.',
                'season' => 3,
                'episode' => 6,
                'description' => 'Banana breath at sensitivity training. Technical issues hit Metal Motto Search. Don Bon Darley loses his touch. What’s up with Draven’s Tasty Time Vids?',
            ],
        ];

        $this->table('episode_info')->insert($data)->save();
    }
}
