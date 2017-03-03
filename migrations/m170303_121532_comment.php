<?php

use yii\db\Migration;
use yii\db\cubrid\Schema;
class m170303_121532_comments extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{comments}}', [
          'id' => Schema::TYPE_PK,
          'post_id' =>  Schema::TYPE_INTEGER,
          'author_id' => Schema::TYPE_INTEGER,
          'text' => Schema::TYPE_TEXT . ' NOT NULL',
          'date' => Schema::TYPE_DATETIME,
        ], $tableOptions);


        $this->createIndex('FK_comments_user', '{{comments}}', 'author_id');
        $this->addForeignKey(
          'FK_comments_user', '{{comments}}', 'author_id', '{{user}}', 'id', 'SET NULL', 'CASCADE'
        );

        $this->createIndex('FK_comments_post', '{{comments}}', 'post_id');
        $this->addForeignKey(
          'FK_comments_post', '{{comments}}', 'post_id', '{{post}}', 'id', 'SET NULL', 'CASCADE'
        );
    }
    public function down(){
        $this->dropForeignKey('FK_comments_user','comments');
        $this->dropForeignKey('FK_comments_post','comments');
        $this->dropTable('{{comments}}');
    }

}
