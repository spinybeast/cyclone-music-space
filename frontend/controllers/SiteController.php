<?php
namespace frontend\controllers;

use frontend\models\ContactForm;
use yii\web\Response;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->renderContent(null);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!$model->validate()) {
                return ['success' => false, 'errors' => $model->getErrors()];
            }
            if ($model->sendEmail('cyberton@mail.ru')) {
                return ['success' => true, 'message' => 'Спасибо за ваше обращение! Мы скоро ответим.'];
            }
        }
        return ['success' => false, 'errors' => ['К сожалению, мы не смогли отправить письмо. Повторите попытку позже или используйте наши контакты в соц сетях']];
    }
}