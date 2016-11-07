<?php

use yii\db\Migration;

/**
 * m161107_211028_course_group_user_table
 */
class m161105_215422_course_group_user_table extends Migration
{
    public function up()
    {
        $this->createTable('course_group_user', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('course_group_user');
    }
}

