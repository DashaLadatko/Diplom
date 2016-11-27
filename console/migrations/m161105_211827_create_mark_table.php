<?php

use yii\db\Migration;

/**
 * Handles the creation for table `mark`.
 */
class m161105_211827_create_mark_table extends \common\components\extended\extMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mark', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'workshop_id' => $this->integer()->notNull(),
            'text' => $this->string(255),
            'evaluation' => $this->integer()->notNull(),
            'type' => $this->smallInteger(1)->notNull(),
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
        $this->dropTable('mark');
    }
}
