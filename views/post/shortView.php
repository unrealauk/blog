<?php
use yii\helpers\Html;

/* @var $model app\models\Post */
?>
<div class="post">
    <h2><?= Html::a($model->title, ['post/view', 'id' => $model->id]) ?></h2>

    <div class="category">
        <p>
            <?= Html::a($model->category->title,
              ['category/index', 'id' => $model->category->id]) ?>
        </p>
    </div>

    <div class="content">
        <?= strip_tags($model->anons) ?> <?= Html::a('Read more...', ['post/view', 'id' => $model->id]) ?>
    </div>
    <div class="author">
        <p class="text-right">
            <?= Html::a($model->author->nickname, ['user/view', 'id' => $model->author->id])?>, <?= $model->getDate() ?>
        </p>
    </div>

</div>
