<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anons')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
      'options' => ['rows' => 6],
      'preset' => 'basic',
    ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
      ArrayHelper::map($category, 'id', 'title')
    ) ?>

    <?= $form->field($model, 'author_id')->dropDownList(
      ArrayHelper::map($authors, 'id', 'nickname')
    ) ?>

    <?= $form->field($model, 'publish_status')->dropDownList([
      'draft' => 'Draft',
      'publish' => 'Publish',
    ], ['prompt' => '']) ?>

    <?= $form->field($model, 'publish_date')->widget(DatePicker::className(),
      [
        'language' => 'en-AU',
        'dateFormat' => 'php: m/d/y',
        'clientOptions' => [''],
      ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
          ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
