<?php

use common\components\extended\extMigration;

class m160604_212646_attachment extends extMigration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'real_name' => $this->string(255),
            'obj_id' => $this->integer()->notNull(),
            'obj_type' => $this->string(255)->notNull(),
            'type' => $this->enum(['image', 'unknown', 'document', 'video', 'audio', 'archive'], true),
            'path' => $this->string(255)->notNull(),
            'thumbnail_path' => $this->string(255),
            'ext' => $this->string(10)->notNull(),
            'show' => $this->tinyint(),
            'status' => $this->smallInteger(1)->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%attachment}}');
    }
}
