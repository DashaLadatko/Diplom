<?php

use yii\db\Migration;

/**
 * Handles the creation for table `topic_course`.
 */
class m161105_211724_create_topic_course_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('topic_course', [
            //'id' => $this->primaryKey(),
            'topic_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('topic_course');
    }
}
