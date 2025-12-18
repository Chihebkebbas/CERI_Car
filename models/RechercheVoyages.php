<?php

namespace app\models;
use Yii;
use yii\base\Model;

use \app\models\Voyage;
use \app\models\Trajet;
use \app\models\Reservation;

class RechercheVoyages extends Model
{

    public static function rechercherVoyages($depart, $arrivee, $places, &$resultat, &$statusClass) {

        $voyages = [];

        $trajet = Trajet::getTrajet($depart, $arrivee);

        $voyagesDispo = Voyage::getVoyagesByTrajetId($trajet->id);
        if ($trajet === null) {
            $resultat = "Trajet non disponible !";
            $statusClass = "danger";
        } else {
            if (empty($voyagesDispo)) {
                $resultat = "Voyages non disponibles !";
                $statusClass = "warning";
            }
        }

        foreach ($voyagesDispo as $voyage) {

            if ($voyage->nbplacedispo >= $places) {
                $voyages[] = $voyage;

            }
        }
        return $voyages;
    }


}