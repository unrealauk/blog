<?php

use yii\db\Migration;
use Faker\Provider\Lorem;
use app\models\Post;

class m170115_120322_demo extends Migration
{
    public function up()
    {
        $this->insert('{{user}}', [
          'username' => 'admin',
          'auth_key' => 'Jg6O-7Sho1sxY38OgTcx3RTX30VUlXTi',
          'password_hash' => '$2y$13$soSNIV4bp2xJ8RqInc6DEO9srU1NMuGpFlqGY3iFo1wn5jNl/pLny',
          'email' => 'unrealauk@gmail.com',
          'nickname' => 'Admin',
          'about' => Lorem::sentences(3, true),
        ]);

        for ($i = 0; $i < 30; $i++) {
            $this->insert('{{category}}', ['title'=>  Lorem::word()]);
        }

        for ($i = 0; $i < 350; $i++) {
            $this->insert('{{post}}', [
              'title' => Lorem::words(2, true),
              'anons' => Lorem::sentences(3, true),
              'content' => Lorem::paragraphs(3, true),
              'category_id' => rand(1, 30),
              'author_id' => 1,
              'publish_status' => Post::STATUS_PUBLISH,
              'publish_date' => rand(strtotime('-3 month'), time()),
            ]);
        }
    }

    public function down()
    {
        $this->dropForeignKey('FK_post_category','post');
        $this->dropForeignKey('FK_post_author','post');
        $this->truncateTable('{{user}}');
        $this->truncateTable('{{category}}');
        $this->truncateTable('{{post}}');
    }

}
