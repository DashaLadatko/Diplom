<?php

use common\components\extended\extMigration;
use common\components\extended\extActiveRecord;

class m130524_201442_user extends extMigration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(),
            'second_name' => $this->string(),
            'last_name' => $this->string(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger(1)->notNull(),
            'role' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        // email: admin@mail.ru
        // pass: _cLpBSkqR3

        $this->insert('user', [
            'id' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Dev',
            'auth_key' => 'TEwtPm93xEYW2WNnvsYmrrDvZbnBZZcg',
            'password_hash' => '$2y$13$dOo3c860r1z5TXpUkkKfT.OS7UCtZFKjGE0UMFjgdVgIXhzO7B4LK',
            'password_reset_token' => '1qRhX8xaQTABjiucsgNFygU2i0ootWpI_1455133825',
            'email' => 'admin@mail.ru',
            'role' => 1,
            'status' => extActiveRecord::STATUS_ACTIVE,
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
