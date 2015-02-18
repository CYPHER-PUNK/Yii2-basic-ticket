<?php

use yii\db\Schema;
use yii\db\Migration;

class m150218_073325_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', ['id' => 'pk', 'email' => 'string', 'auth_key' => 'string']);
        $this->createIndex('email', '{{%user}}', 'email', true);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
