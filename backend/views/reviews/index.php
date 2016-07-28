<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            [
                'attribute' => 'photo',
                'format' => 'image',
                'value' => function ($data) {
                    return $data->getThumbUploadUrl('photo', 'preview');
                },
            ],
            'author',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'published',

                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
                    'header' => 'Опубликован',

                ],
                'format' => 'boolean'
            ],
            'text:html',
            'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
