<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Team;


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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        $client = new \Github\Client();
 
        $dataTeams  = "";

        $Teams = Team::find()->where(['id'] <= 6)->all();                                                                                                                                      

        $teamArr = array();
        foreach($Teams as $Team) {
            // Get commit
            //$commitCount = count($client->api('repo')->commits()->all('Nekrofage',  $Team->project, array('sha' => 'master')));
            $commitCount = rand(5, 50);
            $teamArr[] = array("name" => $Team->name, "project" => $Team->project,  "commit" => $commitCount, "step" => 0);
        }   

        // Sort multiarray by interger
        usort($teamArr, function($a, $b) {
            return $a['commit'] - $b['commit'];
        });

        $min = $teamArr[0]["commit"];
        $max = $teamArr[5]["commit"];
        
        
        for ($row = 0; $row < 6; $row++) {
            $teamArr[$row]["step"] = 6 - $row;
        }

        // Sor multiarray by string
        usort($teamArr, function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });
 

        return $this->render('index', [
            'dataTeam'=>$teamArr,
            'min' => $min,
            'max' => $max,
        ]);
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
}
