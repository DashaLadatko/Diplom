<?php

use yii\db\Migration;

/**
 * Handles the creation for table `group_user`.
 */
class m161105_211514_create_group_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('group_user', [
            //'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('group_user');
    }
}
