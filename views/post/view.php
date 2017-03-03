<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $model->title ?></h1>

<div class="meta">
  <p>
    Author: <?= Html::a($model->author->nickname,
      ['user/view', 'id' => $model->author->id]) ?>
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
<?php if (!(Yii::$app->user->isGuest)) : ?>
  <?= $this->render('/comment/create', [
    'model' => $comment,
    'pid' => $model->id,
  ]) ?>
<?php endif; ?>
<?php foreach ($comments as $comment) {
  echo $this->render('/comment/view', [
    'model' => $comment,
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
