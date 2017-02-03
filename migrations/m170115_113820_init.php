<?php

use yii\db\Migration;
use yii\db\cubrid\Schema;

class m170115_113820_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{user}}', [
          'id' => Schema::TYPE_PK,
          'username' => Schema::TYPE_STRING . ' NOT NULL',
          'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
          'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
          'email' => 'TINYTEXT NOT NULL',
          'nickname' => 'TINYTEXT NOT NULL',
          'about' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{category}}', [
          'id' => Schema::TYPE_PK,
          'title' => 'TINYTEXT NOT NULL',
        ], $tableOptions);

        $this->createTable('{{post}}', [
          'id' => Schema::TYPE_PK,
          'title' => 'TINYTEXT NOT NULL',
          'anons' => Schema::TYPE_TEXT . ' NOT NULL',
          'content' => Schema::TYPE_TEXT . ' NOT NULL',
          'category_id' => Schema::TYPE_INTEGER,
          'author_id' => Schema::TYPE_INTEGER,
          'publish_status' => Schema::TYPE_STRING . '(32) NOT NULL',
          'publish_date' => Schema::TYPE_DATETIME,
        ], $tableOptions);

        $this->createIndex('FK_post_author', '{{post}}', 'author_id');
        $this->addForeignKey(
          'FK_post_author', '{{post}}', 'author_id', '{{user}}', 'id', 'SET NULL', 'CASCADE'
        );

        $this->createIndex('FK_post_category', '{{post}}', 'category_id');
        $this->addForeignKey(
          'FK_post_category', '{{post}}', 'category_id', '{{category}}', 'id', 'SET NULL', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{user}}');
        $this->dropTable('{{post}}');
        $this->dropTable('{{category}}');
    }

}
