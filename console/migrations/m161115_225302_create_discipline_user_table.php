<?php

use yii\db\Migration;

/**
 * Handles the creation for table `discipline_user`.
 */
class m161115_225302_create_discipline_user_table extends Migration
{
    public function up()
    {
        $this->createTable('discipline_user', [
//            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('discipline_user');
    }
}
