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

        if ($trajet === null) {
            $resultat = "Trajet non disponible !";
            $statusClass = "danger";
        } else {
            $voyagesDispo = Voyage::getVoyagesByTrajetId($trajet->id);
            if (empty($voyagesDispo)) {
                $resultat = "Voyages directes non disponibles !";
                $statusClass = "warning";
            }
            foreach ($voyagesDispo as $voyage) {

                if ($voyage->nbplacedispo >= $places) {
                    $voyages[] = $voyage;

                }
                $resultat = "Voyages Directes disponibles !";
                $statusClass = "success";
            }
        }

        return $voyages;
    }

    public static function getVillesIntermediares($depart, $arrivee) {
        $villes = [];

        $trajets = Trajet::getAllTrajets($depart);

        foreach ($trajets as $trajet) {
            if (Trajet::getTrajet($trajet->arrivee, $arrivee) !== null && $trajet->arrivee !== $arrivee) {
                $villes[] = $trajet->arrivee;
            }
        }

        return $villes;
    }

    public static function rechercherCorrespondance($depart, $arrivee, $places, &$resultat, &$statusClass) {
        $villes = self::getVillesIntermediares($depart, $arrivee);
        $correspondance = [];

        // Variables temporaires pour ne pas polluer les messages de l'action principale
        $tempRes = "";
        $tempStat = "";

        foreach ($villes as $ville) {
            $v1List = self::rechercherVoyages($depart, $ville, $places, $tempRes, $tempStat);
            $v2List = self::rechercherVoyages($ville, $arrivee, $places, $tempRes, $tempStat);

            if (!empty($v1List) && !empty($v2List)) {
                foreach ($v1List as $voyage1) {
                    foreach ($v2List as $voyage2) {
                        $arriveeMinV1 = ($voyage1->heuredepart * 60) + (int)$voyage1->infoTrajet->distance;
                        $departMinV2 = $voyage2->heuredepart * 60;
                        $margeMini = 30;

                        if ($departMinV2 >= ($arriveeMinV1 + $margeMini)) {
                            $correspondance[] = [
                                'voyage1' => $voyage1,
                                'voyage2' => $voyage2,
                                'ville' => $ville,
                                'marge' => self::formatMinutes($departMinV2 - $arriveeMinV1),
                                'distance' => Voyage::getDureeTrajetFormat($voyage1->infoTrajet->distance + $voyage2->infoTrajet->distance),
                                'placesRestantes' => min($voyage1->placesRestantes, $voyage2->placesRestantes),
                                'bagages' => min($voyage1->nbbagage, $voyage2->nbbagage),
                                'price' => $voyage1->getPriceFormat($places) + $voyage2->getPriceFormat($places)
                            ];
                        }
                    }
                }
            }
        }

        if (!empty($correspondance)) {
            $resultat = "Des correspondances ont été trouvées !";
            $statusClass = "success";
        } else {
            $resultat = "Pas de correspondance !";
            $statusClass = "warning";
        }

        return $correspondance;
    }

    private static function formatMinutes($minutes) {
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        return $h > 0 ? "{$h}h{$m}min" : "{$m}min";
    }

}