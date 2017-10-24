<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Ride;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use const YII_ENV_TEST;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $rides = Ride::find()
                ->limit(10)
                ->where(['>=' ,'date', new \yii\db\Expression('CURDATE()')])
                ->orderBy('created_at DESC, id DESC')
                ->all();

        return $this->render('index', ['rides' => $rides, 'q' => null, 'user' => $user]);
    }

    public function actionSearch() {
        $user = Yii::$app->user->identity;
        $q = \Yii::$app->request->queryParams['q'];
        $order = \Yii::$app->request->queryParams['order'];

        $rides = Ride::find()
                ->limit(10)
                ->where(['>=' ,'date', new \yii\db\Expression('CURDATE()')])
                ->andFilterWhere([
                    'OR',
                    ['LIKE', 'origin', $q],
                    ['LIKE', 'destination', $q],
                ]);

        if ($order == 'date') {
            $rides = $rides->orderBy('created_at DESC, id DESC')->all();
        }
        
        if ($order == 'lower-price') {
            $rides = $rides->orderBy('price ASC')->all();
        }
        
        if ($order == 'highest-price') {
            $rides = $rides->orderBy('price DESC')->all();
        }
        

        return $this->render('index', ['rides' => $rides, 'q' => $q, 'user' => $user]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        return $this->redirect(['site/index']);

        if (!Yii::$app->user->isGuest) {
            
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionNewTheme() {
        \Yii::$app->session->set('theme', 'new');
        return $this->redirect(['site/index']);
    }
    
    public function actionDefaultTheme() {
        \Yii::$app->session->set('theme', 'default');
        return $this->redirect(['site/index']);
    }
}
