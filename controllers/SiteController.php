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
     * @return string
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $depart = $request->get('depart');
        $arrivee = $request->get('arrivee');
        $places = $request->get('places');

        if ($depart) $depart = ucfirst(strtolower($depart));
        if ($arrivee) $arrivee = ucfirst(strtolower($arrivee));


        $voyages = [];
        if ($depart && $arrivee && $places) {
            $model = new RechercheVoyages();
            $voyages = $model->rechercherVoyages($depart, $arrivee, $places);
        }


        if ($request->isAjax) {
            return $this->renderPartial('_resultat', [
                'voyages' => $voyages,
                'depart' => $depart,
                'arrivee' => $arrivee,
                'places' => $places,
            ]);
        }


        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        return $this->render('login');
    }

    public function actionSignup() {
        return $this->render('signup');
    }


}


