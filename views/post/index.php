<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $posts yii\data\ActiveDataProvider */
/* @var $categories yii\data\ActiveDataProvider */
/* @var $post app\models\Post */
/* @var $pages yii\data\Pagination */
?>
<div class="col-sm-8 post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="pager-container">
        <?php
        echo LinkPager::widget([
          'pagination' => $pages,
        ]);
        ?>
    </div>
    
    <?php
    foreach ($posts as $post) {
        echo $this->render('shortView', [
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
            echo $this->render('//category/shortViewCategory', [
              'model' => $category,
            ]);
        }
        ?>
    </ul>
</div>
