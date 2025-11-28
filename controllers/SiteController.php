<?php

namespace app\controllers;

use app\models\Internaute;
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */



    public function actionTest()
    {
        $pseudo = "Fourmi";

        $internaute = Internaute::getUserByIdentifiant($pseudo);

        echo "<h/>Pseudo : </h1>" . $pseudo . "<br>";

        echo "<h3>Information : </h3> <br>";
        echo "Nom : ". $internaute->nom . "<br>";
        echo "Prénom : ". $internaute->prenom . "<br>";
        echo "Mail : ". $internaute->mail . "<br>";
        echo "<img src='$internaute->photo ' alt='photo' style='width: 100px'> ". "<br>";

        $estCoducteur = Internaute::estConducteur($pseudo);

        if ($estCoducteur != NULL) {

            $voyages = Voyage::getVoyagesByConducteurID($internaute->id);

            echo "<h3>Voyages : </h3> <br>";
            $n = 1;
            foreach ($voyages as $voyage) {
                echo "Voyage n: " . $n . "<br>";

                echo "Type Véhicule: ". $voyage->typeVehicule->typev . "<br>";
                echo "Marque Véhicule: ". $voyage->marqueVehicule->marquev . "<br>";
                echo "Tarif: ". $voyage->tarif . "<br>";
                echo "Nombre de places : ". $voyage->nbplacedispo. "<br>";
                echo "Nombre de bagage: ". $voyage->nbbagage . "<br>";
                echo "Heure de départ: ". $voyage->heuredepart . "<br>";
                echo "Contraintes: ". $voyage->contraintes . "<br>";


                $n ++;
            }

        }

    }

}


