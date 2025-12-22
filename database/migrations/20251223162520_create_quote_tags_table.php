<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuoteTagsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('quote_tags', ['id' => false, 'primary_key' => ['quote_id', 'tag_id']]);
        $table->addColumn('quote_id', 'integer', ['signed' => false])
              ->addColumn('tag_id', 'integer', ['signed' => false])
              ->addIndex(['quote_id'])
              ->addIndex(['tag_id'])
              ->addForeignKey('quote_id', 'quotes', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
              ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
              ->create();
    }
}
