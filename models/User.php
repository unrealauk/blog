<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $nickname
 * @property string $about
 *
 * @property Post[] $posts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'email', 'nickname'], 'required'],
            [['about'], 'string'],
            [['login'], 'string', 'max' => 40],
            [['password', 'email'], 'string', 'max' => 100],
            [['nickname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'email' => 'Email',
            'nickname' => 'Nickname',
            'about' => 'About',
        ];
    }

    /**
     * Get posts by author id.
     * @return \yii\db\ActiveQuery Post
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }
}
