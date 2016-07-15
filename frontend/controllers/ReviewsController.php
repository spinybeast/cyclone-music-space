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

    /**
     * Lists all Reviews models.
     * @return mixed
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $reviews = Reviews::find(['published' => 1])->orderBy('created_at desc')->all();
        foreach ($reviews as $review) {
            $review->photo = $review->getUploadUrl('photo');
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

}
