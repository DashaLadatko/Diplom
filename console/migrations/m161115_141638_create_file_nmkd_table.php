<?php

use common\components\extended\extMigration;

/**
 * Handles the creation of table `file_nmkd`.
 */
class m161115_141638_create_file_nmkd_table extends extMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('file_nmkd', [
            'id' => $this->primaryKey(),
            'discipline_user_id' => $this->integer()->notNull(),
            'component_nmkd_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'signature' => $this->enum(['not loaded', 'out for approval', 'rejected', 'approved'], true),
            'protocol_chair' => $this->boolean(),
            'protocol_fuculty' => $this->boolean(),
            'protocol_university' => $this->boolean(),
            'comment' => $this->string(255),
            'total' => $this->boolean(),
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
        $this->dropTable('file_nmkd');
    }
}
