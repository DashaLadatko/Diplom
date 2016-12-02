<?php

use yii\db\Migration;

/**
 * Handles the creation of table `course_user`.
 */
class m161202_210910_create_course_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('course_user', [
//            'id' => $this->primaryKey(),
            'course_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('course_user');
    }
}
