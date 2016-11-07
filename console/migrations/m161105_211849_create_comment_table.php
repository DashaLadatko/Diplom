<?php

use yii\db\Migration;

/**
 * Handles the creation for table `comment`.
 */
class m161105_211849_create_comment_table extends \common\components\extended\extMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'obj_id' => $this->integer()->notNull(),
            'obj_type' => $this->enum(['practical', 'seminar', 'laboratory', 'lecture'],true),
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
        $this->dropTable('comment');
    }
}
