<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateQuotesTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('quotes');
        $table->addColumn('slug', 'string', ['limit' => 150])
              ->addColumn('quote', 'text')
              ->addColumn('status_id', 'integer', ['default' => 1, 'signed' => false])
              ->addColumn('static_image_id', 'integer', ['null' => true, 'signed' => false])
              ->addColumn('gif_image_id', 'integer', ['null' => true, 'signed' => false])
              ->addColumn('sketch_info_id', 'integer', ['null' => true, 'signed' => false])
              ->addColumn('video_id', 'integer', ['null' => true, 'signed' => false])
              ->addColumn('date_posted', 'date', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('created_by', 'integer', ['null' => true, 'signed' => false])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_by', 'integer', ['null' => true, 'signed' => false])
              ->addIndex(['slug'], ['unique' => true])
              ->addIndex(['status_id'])
              ->addIndex(['date_posted'])
              ->addIndex(['sketch_info_id'])
              ->addIndex(['created_at'])
              ->addForeignKey('status_id', 'statuses', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
              ->addForeignKey('static_image_id', 'images', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->addForeignKey('gif_image_id', 'images', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->addForeignKey('sketch_info_id', 'sketch_info', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->addForeignKey('video_id', 'videos', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->addForeignKey('created_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->addForeignKey('updated_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'RESTRICT'])
              ->create();
    }
}
