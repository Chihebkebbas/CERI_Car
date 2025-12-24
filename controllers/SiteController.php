<?php

namespace app\controllers;

use app\models\Internaute;
use app\models\MarqueVehicule;
use app\models\RechercheVoyages;
use app\models\Reservation;
use app\models\SignupForm;
use app\models\Trajet;
use app\models\TypeVehicule;
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
                    'content' => $this->renderPartial('_login', [])
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
        $request = Yii::$app->request;

        if (!Internaute::isConducteur(Yii::$app->user->id)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => false,
                'message' => 'Merci de\'enregistrer un permis',
                'statusClass' => 'danger',
                'redirect' => Url::to(['site/index'])
            ];
        }

        $voyages = Voyage::getVoyagesByConducteurID(Yii::$app->user->id);

        if ($request->isAjax && !$request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'success' => true,
                'content' => $this->renderPartial('_voyage', [
                    'voyages' => $voyages
                ])
            ];
        }

        $voyageId = $request->post('voyageId');

        if ($voyageId) {
            $voyage = Voyage::getVoyageById($voyageId);
            if($voyage->delete()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'message' => 'Voyage annulée !',
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

    public function actionProfile() {
        $request = Yii::$app->request;
        $user = Internaute::getUserById(Yii::$app->user->id);


        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // Tableau pour stocker les noms des champs modifiés
            $modifications = [];

            // 1. Vérification du NOM
            if ($user->nom !== $request->post('nom')) {
                $user->nom = $request->post('nom');
                $modifications[] = "nom";
            }

            // 2. Vérification du PRENOM
            if ($user->prenom !== $request->post('prenom')) {
                $user->prenom = $request->post('prenom');
                $modifications[] = "prénom";
            }

            // 3. Vérification du PSEUDO (avec sécurité unicité)
            $newPseudo = $request->post('pseudo');
            if ($user->pseudo !== $newPseudo) {
                // On vérifie si le pseudo est libre avant de l'attribuer
                $existingUser = Internaute::findOne(['pseudo' => $newPseudo]);
                if (!$existingUser) {
                    $user->pseudo = $newPseudo;
                    $modifications[] = "pseudo";
                } else {
                    return [
                        'success' => false,
                        'message' => "Ce pseudo est déjà pris !",
                        'statusClass' => 'danger'
                    ];
                }
            }

            // 4. Vérification de l'EMAIL
            if ($user->mail !== $request->post('email')) {
                $user->mail = $request->post('email');
                $modifications[] = "email";
            }

            // 5. Vérification de la PHOTO
            if ($user->photo !== $request->post('photo')) {
                $user->photo = $request->post('photo');
                $modifications[] = "photo";
            }

            // 6. Vérification du PERMIS
            $newPermis = $request->post('permis');

            // Cas A : L'utilisateur a saisi quelque chose
            if (!empty($newPermis)) {
                // On vérifie le format : uniquement des chiffres (0-9) et exactement 12 caractères
                if (!preg_match('/^[0-9]{12}$/', $newPermis)) {
                    return [
                        'success' => false,
                        'message' => 'Le numéro de permis doit comporter exactement 12 chiffres.',
                        'statusClass' => 'danger'
                    ];
                }

                // Si le format est bon, on regarde si la valeur a changé
                if ($user->permis != $newPermis) {
                    $user->permis = $newPermis;
                    $modifications[] = "permis";
                }
            }
            // Cas B : L'utilisateur a laissé le champ vide (Suppression du permis)
            else {
                // Si l'utilisateur avait un permis avant, on le met à NULL
                if ($user->permis !== null) {
                    $user->permis = null;
                    $modifications[] = "permis";
                }
            }

            // 7. Vérification du MOT DE PASSE (Sécurisé)
            $newPass = $request->post('password');
            // On ne change que si le champ n'est PAS vide
            if (!empty($newPass)) {
                $hash = sha1($newPass);
                // On vérifie si c'est vraiment un nouveau mot de passe
                if ($user->pass !== $hash) {
                    $user->pass = $hash;
                    $modifications[] = "mot de passe";
                }
            }

            // --- CONSTRUCTION DU MESSAGE ---
            if ($user->save()) {

                $message = "Profil mis à jour avec succès !"; // Message par défaut

                // Si on a détecté des changements spécifiques
                if (!empty($modifications)) {
                    // Cette fonction joint les éléments avec des virgules : "nom, prénom, email"
                    $listeChamps = implode(', ', $modifications);

                    // On remplace la dernière virgule par " et " pour faire joli (optionnel)
                    // Ex: "nom, prénom et email"
                    $lastComma = strrpos($listeChamps, ',');
                    if ($lastComma !== false) {
                        $listeChamps = substr_replace($listeChamps, ' et', $lastComma, 1);
                    }
                    if (count($modifications) === 1) {
                        $message = "Votre " . $listeChamps . " a été mis à jour avec succès !";
                    } else {
                        $message = "Votre " . $listeChamps . " ont été mis à jour avec succès !";
                    }

                } else {
                    $message = "Aucune modification détectée.";
                    $statusClass = "warning";
                }

                return [
                    'success' => true,
                    'message' => $message,
                    'statusClass' => 'success',
                    // On renvoie le contenu mis à jour pour rafraîchir le formulaire
                    'content' => $this->renderPartial('_profile', ['user' => $user])
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur technique lors de la sauvegarde.',
                    'statusClass' => 'danger',
                    'errors' => $user->errors
                ];
            }
        }

        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'content' => $this->renderPartial('_profile', [
                    'user' => $user
                ])
            ];
        }

    }

    public function actionCreate()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // 1. Sécurité : Est-ce qu'il est connecté et conducteur ?
            if (Yii::$app->user->isGuest || Yii::$app->user->identity->permis === null) {
                return [
                    'success' => false,
                    'message' => 'Vous devez être connecté et avoir un permis pour proposer un voyage.'
                ];
            }

            // 2. Récupération et Nettoyage des données
            $nomDepart = ucfirst(strtolower(trim($request->post('depart'))));
            $nomArrivee = ucfirst(strtolower(trim($request->post('arrivee'))));

            $heureString = $request->post('heure');
            $heureInt = (int) explode(':', $heureString)[0];
            


            // 3. Recherche le trajet
            $trajet = Trajet::getTrajet($nomDepart, $nomArrivee);

            if (!$trajet) {
                return [
                    'success' => false,
                    'message' => 'Le trajet n\'existe pas.'
                ];
            }


            // 4. Création du Voyage
            $voyage = new Voyage();
            $voyage->conducteur = Yii::$app->user->id;
            $voyage->trajet = $trajet->id;
            $voyage->heuredepart = $heureInt;
            $voyage->tarif = $request->post('tarif');
            $voyage->nbplacedispo = $request->post('places');
            $voyage->nbbagage = $request->post('bagages');
            $voyage->contraintes = $request->post('contraintes');
            $voyage->idtypev = $request->post('idtypev');
            $voyage->idmarquev = $request->post('idmarquev');


            if ($voyage->save()) {
                return [
                    'success' => true,
                    'message' => 'Voyage publié avec succès !',
                    'redirect' => Url::to(['site/index'])
                ];
            } else {
                // Récupération de la première erreur
                $error = reset($voyage->errors)[0] ?? 'Erreur de validation';
                return [
                    'success' => false,
                    'message' => 'Erreur : ' . $error
                ];
            }
        }


        if ($request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $marques = MarqueVehicule::getAllMarques();
            $types = TypeVehicule::getAllTypes();

            return [
                'content' => $this->renderPartial('_create', [
                    'marques' => $marques,
                    'types' => $types
                ])
            ];
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }


}


