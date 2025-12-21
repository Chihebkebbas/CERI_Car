<?php

namespace app\controllers;

use app\models\Internaute;
use app\models\RechercheVoyages;
use app\models\Reservation;
use app\models\SignupForm;
use app\models\Trajet;
use app\models\Voyage;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;


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


    public function actionLogin() {

        $request = Yii::$app->request;

        $model = new LoginForm();
        if ($model->load($request->post()) && $model->login()) {

            if ($request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'message' => 'Connexion réussie !',
                    'redirect' => Url::to(['site/index']), // Redirection vers l'accueil
                ];
            }
        }

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
        $model = new SignupForm();

        if ($model->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if ($user = $model->signup()) {
                Yii::$app->user->login($user); // Si tu as configuré User Identity
                return [
                    'success' => true,
                    'message' => 'Compte créé avec succès !',
                    'redirect' => Url::to(['site/index'])
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $model->errors
                ];
            }
        }

        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'content' => $this->renderPartial('_signup', [])
            ];
        }

    }


}


