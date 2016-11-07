<?php

use common\components\extended\extMigration;

class m160604_212648_queue extends extMigration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->notNull(),
            'from_name' => $this->string()->notNull(),
            'from_email' => $this->string()->notNull(),
            'to_email' => $this->string()->notNull(),
            'content' => $this->text(),
            'send_time' => $this->integer(),
            'status' => $this->smallInteger(1)->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%queue}}');
    }
}
