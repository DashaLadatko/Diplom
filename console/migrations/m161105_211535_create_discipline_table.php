<?php

use yii\db\Migration;

/**
 * Handles the creation for table `discipline`.
 */
class m161105_211535_create_discipline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('discipline', [
            'id' => $this->primaryKey(),
            'department_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
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
        $this->dropTable('discipline');
    }
}
