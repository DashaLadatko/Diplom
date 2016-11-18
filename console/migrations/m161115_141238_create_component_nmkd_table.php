<?php

use yii\db\Migration;

/**
 * Handles the creation of table `component_nmkd`.
 */
class m161115_141238_create_component_nmkd_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('component_nmkd', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
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
        $this->dropTable('component_nmkd');
    }
}
