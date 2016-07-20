<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use mongosoft\file\UploadImageBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property string $author
 * @property string $text
 * @property string $social_link
 * @property string $photo
 * @property boolean $published
 * @property integer $created_at
 * @property integer $updated_at
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    public function behaviors()
  {
      return [
          [
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',
              'updatedAtAttribute' => 'updated_at',
              'value' => date('Y-m-d H:i:s')
          ],
          [
              'class' => UploadImageBehavior::className(),
              'attribute' => 'photo',
              'scenarios' => ['default', 'create', 'update'],
              'placeholder' => '@frontend/web/img/noavatar.png',
              'path' => '@frontend/web/img/reviews/{id}',
              'url' => '/img/reviews/{id}',
              'thumbs' => [
                  'preview' => ['width' => 200, 'height' => 200],
              ],
          ],
      ];
  }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author', 'text'], 'required'],
            [['text'], 'string'],
            [['published'], 'boolean'],
            [['author', 'social_link'], 'string', 'max' => 255],
            ['photo', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'checkExtensionByMimeType' => false, 'on' => ['default', 'create', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Автор',
            'text' => 'Текст',
            'photo' => 'Фото',
            'social_link' => 'Соц сети',
            'published' => 'Опубликован',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }
    
}
