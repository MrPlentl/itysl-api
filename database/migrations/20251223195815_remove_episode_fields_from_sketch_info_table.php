<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveEpisodeFieldsFromSketchInfoTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('sketch_info');

        // Remove indexes (only if they exist)
        if ($table->hasIndex(['episode'])) {
            $table->removeIndex(['episode']);
        }

        if ($table->hasIndex(['season'])) {
            $table->removeIndex(['season']);
        }

        if ($table->hasIndex(['episode_number'])) {
            $table->removeIndex(['episode_number']);
        }

        // Drop columns
        if ($table->hasColumn('episode')) {
            $table->removeColumn('episode');
        }

        if ($table->hasColumn('season')) {
            $table->removeColumn('season');
        }

        if ($table->hasColumn('episode_number')) {
            $table->removeColumn('episode_number');
        }

        $table->update();
    }
}
