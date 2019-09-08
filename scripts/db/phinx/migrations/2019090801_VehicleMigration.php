<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

//phpcs:ignore PSR1.Classes.ClassDeclaration.MissingNamespace
class VehicleMigration extends AbstractMigration
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

        $table = $this->table("{$schema}.vehicles", ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn("id", "uuid", ["null" => false])
            ->addColumn("license_plate", "string", ["limit" => 10, "null" => false])
            ->addColumn("colour", "string", ["limit" => 255, "null" => true])
            ->addColumn("fuel_type", "string", ["limit" => 255, "null" => true])
            ->addColumn("transmission", "string", ["limit" => 255, "null" => true])
            ->addColumn("manufacturer", "string", ["limit" => 255, "null" => false])
            ->addColumn("model", "string", ["limit" => 255, "null" => false])
            ->addColumn("num_seats", "smallinteger", ["null" => true])
            ->addColumn("num_doors", "smallinteger", ["null" => true])
            ->addTimestamps()
            ->addIndex(["id"], ["unique" => true, "name" => "vehicles_id_idx"])
            ->addIndex(["license_plate"], ["unique" => true, "name" => "vehicles_license_plate_idx"]);
        $table->create();
    }
}
