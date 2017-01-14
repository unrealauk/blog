<?php
use yii\helpers\Html;

/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $model->title ?></h1>

<div class="meta">
    <p>
        Author: <?= $model->author->nickname ?>
        Publication date: <?= $model->getDate() ?>
        Category: <?= Html::a($model->category->title,
          ['category/index', 'id' => $model->category->id]) ?>
    </p>
</div>

<div>
    <?= $model->content ?>
</div>
<br>
<div class="actions">
    <?= Html::a('Edit', ['post/update', 'id' => $model->id],
      ['class' => 'btn btn-success']) ?>
</div>
