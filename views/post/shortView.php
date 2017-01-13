<?php
use yii\helpers\Html;

/* @var $model app\models\Post */
?>

<h1><?= Html::a($model->title, ['post/view', 'id' => $model->id]) ?></h1>

<div class="meta">
    <p>
        Author: <?= $model->author->nickname ?>
        Publication date: <?= $model->publish_date ?>
        Category: <?= Html::a($model->category->title,
          ['category/index', 'id' => $model->category->id]) ?>
    </p>
</div>

<div class="content">
    <?= strip_tags($model->anons) ?>
</div>

<br>

<?= Html::a('Read more...', ['post/view', 'id' => $model->id],
  ['class' => 'btn btn-success']) ?>
