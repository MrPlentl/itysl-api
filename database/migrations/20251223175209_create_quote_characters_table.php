<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuoteCharactersTable extends AbstractMigration
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
        $table = $this->table('quote_characters', ['id' => false, 'primary_key' => ['quote_id', 'character_id']]);
        $table->addColumn('quote_id', 'integer', ['signed' => false])
              ->addColumn('character_id', 'integer', ['signed' => false])
              ->addIndex(['quote_id'])
              ->addIndex(['character_id'])
              ->addForeignKey('quote_id', 'quotes', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
              ->addForeignKey('character_id', 'characters', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
              ->create();
    }
}
