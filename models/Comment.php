<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $author_id
 * @property string $text
 * @property string $date
 *
 * @property Post $post
 * @property User $author
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'author_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'author_id' => 'Author ID',
            'text' => 'Text',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function beforeSave($insert)
    {
        $this->date = date('Y-m-d H:i:s');
        $this->post_id = $_GET['id'];
        $this->author_id =  Yii::$app->user->identity->getId();
        return parent::beforeSave($insert);
    }
   
}

