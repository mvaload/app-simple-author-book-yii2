<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Payment;
use app\models\Book;




class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
            'verbs' => [
                'class' => VerbFilter::className(),
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
        $booksList = Book::find()->all();

        return $this->render('index', ['booksList' => $booksList]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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

    public function actionCreatexml() {
        memory_get_usage();
//        $payments = Payment::find()->innerJoinWith('credits')->limit(10)->asArray()->all();
        $reports = [];
        $logs = [];
        $payments = Payment::find()
            ->select('payments.*')
            ->leftJoin('credits', '`credits`.`id` = `payments`.`cred_id`')
            ->where(['credits.id' => null])
            ->with('credits')
            ->limit(50)
            ->asArray()
            ->all();

        foreach ($payments as $payment) {
            $dataSet = unserialize($payment['data_set']);
            if ($dataSet['overdue'] != 0) {
                $idx = $payment['id'];
                $reports[$idx]['cred_id'] = $payment['cred_id'];
                $reports[$idx]['overdue'] = $dataSet['overdue'];
            } else {
                $idx = $payment['id'];
                $logs[$idx]['cred_id'] = $payment['cred_id'];
                $logs[$idx]['overdue'] = $dataSet['overdue'];
            }
        }
        Yii::info($logs, 'failed-verification');

        $dom = new \DOMDocument('1.0', 'utf-8');
        $xmlRoot = $dom->appendChild($dom->createElement('payments'));
        foreach ($reports as $id => $payment) {
            $xmlPayment = $xmlRoot->appendChild($dom->createElement('payment'));
            $xmlPayment->setAttribute('id', $id);
            foreach($payment as $key => $value) {
                $xmlName = $xmlPayment->appendChild($dom->createElement($key));
                $xmlName->appendChild($dom->createTextNode($value));
            }
        }
        $dom->formatOutput = true;
        $dom->save(yii::$app->basePath . '\xml\payments.xml');

//        $dom->load(yii::$app->basePath . '\xml\payments.xml');
//        if ($dom->validate()) {
//            echo "Документ является действительным!\n";
//        } else {
//            echo "Документ не является действительным!\n";
//        }
        $memory = (!function_exists('memory_get_usage')) ? '' : round(memory_get_usage()/1024/1024, 2) . 'MB';
        echo $memory;
    }

}
