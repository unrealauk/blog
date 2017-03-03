<?php

namespace app\controllers;

use app\models\Comment;
use Yii;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\User;
use yii\data\Pagination;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          'access' => [
            'class' => AccessControl::className(),
            'only' => ['create', 'update', 'delete'],
            'rules' => [
              [
                'allow' => true,
                'actions' => ['create', 'update', 'delete'],
                'roles' => ['@'],
              ],
            ],
          ],
          'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
              'delete' => ['POST'],
            ],
          ],
        ];
    }

    /**
     * Lists all Post models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Post::find()
          ->where(['publish_status' => Post::STATUS_PUBLISH])
          ->orderBy(['publish_date' => SORT_DESC]);
        $categories = new Category();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(5);
        $posts = $query
          ->joinWith('category')
          ->joinWith('author')
          ->offset($pages->offset)
          ->limit($pages->limit)
          ->all();
        return $this->render('index', [
          'pages' => $pages,
          'posts' => $posts,
          'categories' => $categories->getCategories(),
        ]);
    }

    /**
     * Displays a single Post model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $post = new Post();
        $comment = new Comment();

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }
        $post = $post->getPost($id);
        $comments = $post->getComments();
        $pages = new Pagination(['totalCount' => $comments->count()]);
        $pages->setPageSize(5);

        return $this->render('view', [
          'model' => $post,
          'comment' => $comment,
          'pages' => $pages,
          'comments' => $comments->offset($pages->offset)
            ->limit($pages->limit)
            ->joinWith('author')
            ->all(),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if (!$model->publish_date) {
                $model->publish_date = date('m/d/y');
            }
            return $this->render('create', [
              'model' => $model,
              'category' => Category::find()->all(),
              'authors' => User::find()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
              'model' => $model,
              'category' => Category::find()->all(),
              'authors' => User::find()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index'
     * page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
