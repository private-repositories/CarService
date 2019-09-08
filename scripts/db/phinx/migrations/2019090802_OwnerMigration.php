<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class OwnerMigration extends AbstractMigration
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
     *    renameTables
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
        $schema = $_ENV['DB_SCHEMA'];

        $table = $this->table("{$schema}.owners", ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn("id", "uuid", ["null" => false])
            //FIXME: The owner_ is redundant, but we are using for expedience
            ->addColumn("owner_name", "string", ["limit" => 255, "null" => false])
            ->addColumn("owner_profession", "string", ["limit" => 255, "null" => true])
            ->addColumn("owner_company", "string", ["limit" => 255, "null" => true])
            ->addTimestamps()
            ->addIndex(["id"], ["unique" => true, "name" => "owners_id_idx"])
            ->addIndex(["owner_name"], ["unique" => true, "name" => "owners_name_idx"]);
        $table->create();
    }
}
