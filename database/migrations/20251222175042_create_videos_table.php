<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateVideosTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('videos');
        $table->addColumn('title', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('url', 'string', ['limit' => 512, 'comment' => 'Netflix link or video URL'])
              ->addColumn('platform', 'enum', ['values' => ['netflix', 'youtube', 'rumble', 'other'], 'default' => 'netflix'])
              ->addIndex(['platform'])
              ->create();
    }
}
