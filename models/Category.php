<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 *
 * @property Post[] $posts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['title'], 'required'],
          [['title'], 'string', 'max' => 255],
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
        ];
    }

    public function getPosts()
    {
        return new ActiveDataProvider([
          'query' => Post::find()
            ->where([
              'category_id' => $this->id,
              'publish_status' => Post::STATUS_PUBLISH,
            ]),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return new ActiveDataProvider([
          'query' => Category::find(),
        ]);
    }

    public function getCategory($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested post does not exist.');
        }
    }
}
