<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Reviews */

$this->title = $model->author;
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Точно удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'author',
            'text:ntext',
            [
                'attribute' => 'photo',
                'format' => 'image',
                'value' => $model->getThumbUploadUrl('photo', 'preview')
            ],
            'published:boolean',
            [
                'attribute' => 'socials',
                'format' => 'ntext',
                'value' => serialize($model->socials)
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
