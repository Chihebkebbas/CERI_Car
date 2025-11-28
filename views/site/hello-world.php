<?php /* @var $this yii\web\View */

use app\models\Produit;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>

<div>
    <?=Html::encode($msg)?>
    <h1>Voici la liste des produits</h1>
    <?=
        Html::dropDownList('liste produit', 'Séléctionner',ArrayHelper::map($prd, 'id', 'produit'));
    ?>

</div>