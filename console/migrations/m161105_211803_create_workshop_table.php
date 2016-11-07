<?php

use yii\db\Migration;

/**
 * Handles the creation for table `workshop`.
 */
class m161105_211803_create_workshop_table extends \common\components\extended\extMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('workshop', [
            'id' => $this->primaryKey(),
            'topic_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'type' => $this->enum(['practical', 'seminar', 'laboratory', 'lecture'],true),
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
        $this->dropTable('workshop');
    }
}
