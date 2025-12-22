<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateImagesTable extends AbstractMigration
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
        $table = $this->table('images');
        $table->addColumn('filename', 'string', ['limit' => 255])
              ->addColumn('alt_text', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('type', 'enum', ['values' => ['static', 'gif']])
              ->addIndex(['type'])
              ->addIndex(['filename'])
              ->create();
    }
}
