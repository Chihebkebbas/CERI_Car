<?php

namespace app\controllers;

use app\models\Internaute;
use app\models\RechercheVoyages;
use app\models\Reservation;
use app\models\Trajet;
use app\models\Voyage;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


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
     * @return array
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;


        $depart = $request->get('depart');
        $arrivee = $request->get('arrivee');
        $places = $request->get('places');
        $resultat = "Voyages Dispoblibles !";
        $statusClass = "success";

        if ($depart) $depart = ucfirst(strtolower($depart));
        if ($arrivee) $arrivee = ucfirst(strtolower($arrivee));


        $voyages = [];
        if ($depart && $arrivee && $places) {
            $voyages = RechercheVoyages::rechercherVoyages($depart, $arrivee, $places, $resultat, $statusClass);
        }


        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'content' => $this->renderPartial('_resultat', [
                    'voyages' => $voyages,
                    'depart' => $depart,
                    'arrivee' => $arrivee,
                    'places' => $places,
                ]),
                'resultat' => $resultat,
                'statusClass' => $statusClass,
            ];
        }


        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return array
     */
    public function actionLogin() {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'content' => $this->renderPartial('_login', [])
            ];
        }

        
        return $this->render('login');
    }

    public function actionSignup() {

        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'content' => $this->renderPartial('_signup', [])
            ];
        }

        return $this->render('signup');
    }


}


