<?php

use yii\db\Migration;

/**
 * Handles the creation for table `topic`.
 */
class m161105_211742_create_topic_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('topic', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'time_of_passage' => $this->integer()->notNull(),
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
        $this->dropTable('topic');
    }
}
