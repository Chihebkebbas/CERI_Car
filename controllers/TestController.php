<?php

namespace app\controllers;

use app\models\RechercheVoyages;
use app\models\Reservation;
use app\models\Voyage;
use app\models\Internaute;

use yii\web\Controller;
use yii\web\Response;


class TestController extends Controller
{
    public function actionTest()
    {
        $pseudo = "Loup";

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
                echo "<h4> Voyage n: " . $n . "</h4><br>";


                echo "Départ : ". $voyage->infoTrajet->depart . "<br>";
                echo "Arrivée : ". $voyage->infoTrajet->arrivee . "<br>";
                echo "Distance : ". $voyage->infoTrajet->distance . "<br>";


                echo "Type Véhicule: ". $voyage->typeVehicule->typev . "<br>";
                echo "Marque Véhicule: ". $voyage->marqueVehicule->marquev . "<br>";
                echo "Tarif: ". $voyage->tarif . "<br>";
                echo "Nombre de places : ". $voyage->nbplacedispo. "<br>";
                echo "Nombre de bagage: ". $voyage->nbbagage . "<br>";
                echo "Heure de départ: ". $voyage->heuredepart . "<br>";
                echo "Contraintes: ". $voyage->contraintes . "<br>";

                echo "<h5>Réservatios de ce voyages</h5> <br>";

                $resarvations = Reservation::getReservationsByVoyageId($voyage->id);

                if ($resarvations) {
                    $m = 1;
                    foreach ($resarvations as $resarvation) {
                        echo "<h6> Réservation n: " . $m . "</h6><br>";

                        $voyageurs = $resarvation->voyageurs;
                        echo "Réservé par : <br>";

                        foreach ($voyageurs as $voyageur) {
                            echo "Nom: ". $voyageur->nom . "<br>";
                            echo "Prenom: ". $voyageur->prenom . "<br>";
                            echo "Mail: ". $voyageur->mail . "<br>";
                            echo "<img src='$voyageur->photo ' alt='photo' style='width: 100px'>";
                        }

                        $m++;

                    }
                } else {
                    echo "Ce voyage est réservé par personne <br>";

                }

                echo "<br>";
                $n ++;
            }

            $resarvations = Reservation::getReservationsByInternauteId($internaute->id);

            echo "<h3>Réservations : </h3> <br>";
            $n = 1;

            if ($resarvations) {
                $m = 1;
                foreach ($resarvations as $resarvation) {
                    echo "<h6> Réservation n: " . $m . "</h6><br>";

                    $infoVoyage = $resarvation->infoVoyage;
                    $infoTrajet = $resarvation->infoVoyage->infoTrajet;

                    foreach ($voyageurs as $voyageur) {
                        echo "Départ: ". $infoTrajet->depart. "<br>";
                        echo "Arrivée: ". $infoTrajet->arrivee. "<br>";
                        echo "Distance: ". $infoTrajet->distance . "<br>";
                        echo "Nom Conducteur: ". $infoVoyage->infoConducteur->nom . "<br>";
                        echo "Prénom Conducteur: ". $infoVoyage->infoConducteur->prenom . "<br>";
                        echo "Mail: ". $infoVoyage->infoConducteur->mail . "<br>";

                    }

                    $m++;

                }
            } else {
                echo "Ce Voyageurs n'as pas de réservations <br>";
            }

        }



    }

    public function actionRechercher() {
        $depart = "Paris";
        $arrivee = "Marseille";
        $places = 1;

        $model = new RechercheVoyages();

        $voyages = $model->rechercherVoyages($depart, $arrivee, $places);

        foreach ($voyages as $voyage) {
            echo $voyage->id . "<br>";
        }

    }
}