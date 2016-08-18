<?php

namespace frontend\controllers;

use Yii;
use common\models\Reviews;
use yii\web\Controller;
use yii\web\Response;

/**
 * ReviewsController implements the CRUD actions for Reviews model.
 */
class ReviewsController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Reviews models.
     * @return mixed
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $reviews = Reviews::find()->where(['published' => true])->orderBy('created_at desc, priority desc')->all();
        foreach ($reviews as $review) {
            $review->photo = $review->getUploadUrl('photo') ?: '/img/noavatar.png';
        }
        return $reviews;
    }

    /**
     * Creates a new Reviews model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reviews();
        $request = Yii::$app->request;
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                return ['success' => true, 'message' => 'Спасибо за ваш отзыв! Он появится на сайте после проверки модератором'];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

}
