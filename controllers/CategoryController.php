<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\filters\AccessControl;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {
        $category = Category::findOne(['id' => $id]);
        $posts = $category->getPosts($id);
        $pages = new Pagination(['totalCount' => $posts->query->count()]);
        $pages->setPageSize(5);
        $posts = $posts->query
          ->joinWith('author')
          ->joinWith('category')
          ->offset($pages->offset)
          ->limit($pages->limit)
          ->all();

        return $this->render('index', [
          'pages' => $pages,
          'category' => $category,
          'posts' => $posts,
          'categories' => $category->getCategories(),
        ]);
    }

    /**
     * Displays a single Category model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
          'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
              'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
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
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
