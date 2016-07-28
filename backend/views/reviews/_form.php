<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(['id' => 'reviews-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'socials[vkontakte]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'socials[facebook]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'socials[google]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'socials[twitter]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'socials[instagram]')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-2">
                <?= Html::img($model->getThumbUploadUrl('photo', 'preview'), ['class' => 'img-thumbnail']) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'photo')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
