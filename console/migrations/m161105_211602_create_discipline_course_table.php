<?php

use yii\db\Migration;

/**
 * Handles the creation for table `discipline_course`.
 */
class m161105_211602_create_discipline_course_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('discipline_course', [
            //'id' => $this->primaryKey(),
            'discipline_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('discipline_course');
    }
}
