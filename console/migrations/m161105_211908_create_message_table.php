<?php

use yii\db\Migration;

/**
 * Handles the creation for table `message`.
 */
class m161105_211908_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'to_user_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'read_or_not' => $this->boolean()->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message');
    }
}
