<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEpisodeInfoTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('episode_info');

        $table
            ->addColumn('platform', 'string', [
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('show', 'string', [
                'limit' => 50,
                'null' => false,
                'default' => 'I Think You Should Leave'
            ])
            ->addColumn('season', 'integer', [
                'null' => false,
            ])
            ->addColumn('episode', 'integer', [
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
            ])
            ->create();
    }
}
