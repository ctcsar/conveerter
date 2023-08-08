<?php

namespace app\controllers;

use app\models\DataBase;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionConvertMoney()
    {
        $currentDate = date('d/m/Y');
        $currencyName = Yii::$app->request->post('name');
        $currencyCount = (double)Yii::$app->request->post('count');
        if(!DataBase::find()->where(['CharCode'=> $currencyName, 'currentDate'=>$currentDate])->one()){
            DataBase::createOrRefreshTable($currentDate);
        }

        if($currencyName == 'RUB'){
            $rubSumm = $currencyCount;
        } else {
            $currentCurrency = DataBase::find()->where(['CharCode'=>$currencyName])->one();
            $rubSumm = $currentCurrency->Value * $currencyCount;
        }
        $allCurrencies = DataBase::find()->all();
        $result = [];
        $result['RUB']['value'] = round($rubSumm, 4);
        $result['RUB']['name'] = 'Российский рубль';
        $result['RUB']['code'] = 'RUB';
        foreach ($allCurrencies as $currensy){
            $result[$currensy->CharCode]['value'] = round(($rubSumm/$currensy->Value), 4);
            $result[$currensy->CharCode]['name'] = $currensy->Name;
            $result[$currensy->CharCode]['code'] = $currensy->CharCode;
        }
//        echo '<pre>';print_r($result); die;
        return json_encode($result);



    }

}
