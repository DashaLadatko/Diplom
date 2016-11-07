<?php

use yii\db\Migration;

/**
 * Handles the creation for table `lang`.
 */
class m161015_173737_create_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lang', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)->notNull(),
            'local' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'default' => $this->smallInteger(1),
        ]);

        $this->insert('lang', ['url' => 'en', 'local' => 'en-US', 'name' => 'English', 'default' => 0]);
        $this->insert('lang', ['url' => 'ru', 'local' => 'ru-RU', 'name' => 'Русский', 'default' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lang');
    }
}
