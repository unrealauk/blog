<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $anons
 * @property string $content
 * @property integer $category_id
 * @property integer $author_id
 * @property string $publish_status
 * @property string $publish_date
 *
 * @property Category $category
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISH = 'publish';
    const STATUS_DRAFT = 'draft';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['anons', 'content', 'publish_status'], 'string'],
            [['category_id', 'author_id'], 'integer'],
            [['publish_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'title' => 'Title',
            'anons' => 'Anons',
            'content' => 'Content',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
            'publish_status' => 'Publish Status',
            'publish_date' => 'Publish Date',
        ];
    }

    /**
     * Get author by id.
     * @return \yii\db\ActiveQuery User
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Get category by id.
     * @return \yii\db\ActiveQuery Category
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Get published post order by date desc.
     * @return \yii\data\ActiveDataProvider Post
     */
    public function getPublishedPosts()
    {
        return new ActiveDataProvider([
          'query' => Post::find()
            ->where(['publish_status' => self::STATUS_PUBLISH])
            ->orderBy(['publish_date' => SORT_DESC])
        ]);
    }

    /**
     * Get post by id.
     * @param $id post id
     * @return static Post
     * @throws \yii\web\NotFoundHttpException
     */
    public function getPost($id)
    {
        if (
          ($model = Post::findOne($id)) !== null &&
          $model->isPublished()
        ) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested post does not exist.');
        }
    }

    /**
     * Check is published post.
     * @return bool
     */
    protected function isPublished()
    {
        return $this->publish_status === self::STATUS_PUBLISH;
    }

    /**
     * Get formatted publish_date);
     * @return bool|string
     */
    public function getDate()
    {
        return date('d M, Y', $this->publish_date);
    }

    /**
     * Convert publish_date to Unix timestamp.
     */
    public function beforeSave($insert)
    {
        $this->publish_date = strtotime($this->publish_date);
        return parent::beforeSave($insert);
    }
}
