<?php

use Phinx\Migration\AbstractMigration;

class CreateMediasTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('medias')
            ->addColumn('post_id', 'integer', [
                'null' => true
            ])
            ->addForeignKey('post_id', 'posts', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'NO_ACTION' //,'constraint' => 'short_key'
            ])
            ->addColumn('file_name', 'string')
            ->addColumn('file_size', 'string')
            ->addColumn('file_type', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
