<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTagsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tags');
        $table->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('slug', 'string', ['limit' => 100])
              ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
              ->addIndex(['name'], ['unique' => true])
              ->addIndex(['slug'], ['unique' => true])
              ->create();
    }
}
