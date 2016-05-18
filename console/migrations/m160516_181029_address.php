<?php

use yii\db\Migration;

class m160516_181029_address extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('address', [
            'id'            => $this->primaryKey(11),
            'name'          => $this->string(255)->notNull(),
            'location'      => $this->string(255)->notNull(),
            'rgb_id'        => $this->integer(11)->notNull(),
            'created_at'    => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('rgb', [
            'id'            => $this->primaryKey(11),
            'red'           => $this->integer(3)->notNull(),
            'green'         => $this->integer(3)->notNull(),
            'blue'          => $this->integer(3)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('rgb_id_adress_fk','address','rgb_id','rgb','id','CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('address');

        $this->dropTable('rgb');
    }
}
