<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddEpisodeInfoIdToSketchInfoTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('sketch_info');

        $table
            ->addColumn('episode_info_id', 'integer', [
                'null' => true,
                'signed' => false,
                'after' => 'id', // adjust placement if needed
            ])
            ->addForeignKey(
                'episode_info_id',
                'episode_info',
                'id',
                [
                    'delete' => 'SET_NULL',
                    'update' => 'CASCADE',
                    'constraint' => 'fk_sketch_episode_info',
                ]
            )
            ->update();
    }
}
