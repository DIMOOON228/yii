<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Html;
use yii\widgets\ListView;

$blog =$dataProvider->getModels();
$this->title = 'Blog';
?>
    <div class="body-content">

        <div class="row">
        <?= 
            ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_one',
        ]);
        ?>
        </div>

    </div>
