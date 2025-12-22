<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCharactersTable extends AbstractMigration
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
        $table = $this->table('characters');
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('actor', 'string', ['limit' => 255, 'null' => true, 'comment' => 'Actor who plays the character'])
              ->addColumn('description', 'text', ['null' => true])
              ->addIndex(['name'])
              ->addIndex(['actor'])
              ->create();
    }
}
