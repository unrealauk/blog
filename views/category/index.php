<?php
/**
 * Created by PhpStorm.
 * User: georgy
 * Date: 18.10.14
 * Time: 2:14
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/** @var $category \app\models\Category */
/** @var $categories \yii\data\ActiveDataProvider */
/** @var $posts \yii\data\ActiveDataProvider */
/* @var $pages yii\data\Pagination */

$this->title = 'Category ' . $category->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-sm-8 post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($posts as $post) {
        echo $this->render('//post/shortView', [
          'model' => $post,
        ]);
    }
    ?>
    <div class="pager-container">
        <?php
        echo LinkPager::widget([
          'pagination' => $pages,
        ]);
        ?>
    </div>

</div>

<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <h1>Categories</h1>
    <ul>
        <?php
        foreach ($categories->models as $category) {
            echo $this->render('shortViewCategory', [
              'model' => $category,
            ]);
        }
        ?>
    </ul>
</div>
