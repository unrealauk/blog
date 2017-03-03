<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

?>
<div class="comment-view">
    <p>
        Author: <?= Html::a($model->author->nickname,
          ['user/view', 'id' => $model->author->id]) ?>
        Publication date: <?= $model->date ?>
     </p>
    <div>
        <p> <?= $model->text ?> </p>
    </div>
</div>
