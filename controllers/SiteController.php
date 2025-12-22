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
use yii\helpers\Console;
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


    public function actionReservation() {
        $request = Yii::$app->request;

        $message = "Réservations Disponibles !";
        $statusClass = "info";

        $reservations = Reservation::getReservationsByInternauteId(Yii::$app->user->id);
        if (empty($reservations)) {
            $message = "Vouz avez pas réservé encore !";
            $statusClass = "warning";
        }

        if ($request->isAjax && !$request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'content' => $this->renderPartial('_reservation', [
                    'reservations' => $reservations,
                ]),
                'message' => $message,
                'statusClass' => $statusClass,
            ];
        }

        $voyageId = $request->post('voyageId');

        if ($voyageId) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->user->isGuest) {
                return [
                    'success' => false,
                    'message' => 'Vous devez être connecté pour réserver.',
                    'redirect' => Url::to(['site/login'])
                ];
            }

            $voyage = Voyage::findOne($voyageId);

            if ($voyage->conducteur == Yii::$app->user->id) {
                return [
                    'success' => false,
                    'message' => 'Vous ne pouvez pas réserver votre propre trajet.',
                    'redirect' => Url::to(['site/index'])
                ];
            }

            $places = $request->post('places');

            $reservation = new Reservation();
            $reservation->voyage = $voyageId;
            $reservation->voyageur = Yii::$app->user->id;
            $reservation->nbplaceresa = $places;

            if ($reservation->save()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'message' => 'Réservation effectuée !',
                    'redirect' => Url::to(['site/index'])
                ];
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => false,
                    'message' => "Erreur lors de la réservation !"
                ];
            }

        }

        $reservationId = $request->post('reservationId');

        if ($reservationId) {
            $reservation = Reservation::getReservationById($reservationId);
            if($reservation->delete()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'message' => 'Réservation annulée !',
                    'statusClass' => 'warning',
                    'redirect' => Url::to(['site/index'])
                ];
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => false,
                    'message' => "Erreur lors de l'annulation !"
                ];
            }
        }

    }

    public function actionVoyage() {

    }

}


