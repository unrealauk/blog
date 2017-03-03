<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comment */

?>
<div class="comment-create">

    <h1>Create Comment</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'pid' => $pid,
    ]) ?>

</div>
