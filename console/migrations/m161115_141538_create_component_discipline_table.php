<?php

use yii\db\Migration;

/**
 * Handles the creation of table `component_discipline`.
 */
class m161115_141538_create_component_discipline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('component_discipline', [
            'id' => $this->primaryKey(),
            'discipline_id' => $this->integer()->notNull(),
            'component_nmkd_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('component_discipline');
    }
}
