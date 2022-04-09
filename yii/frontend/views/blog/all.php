<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Html;


$this->title = 'Blog';
?>
    <div class="body-content">

        <div class="row">
            <?php foreach($blogs as $one): ?>

            <div class="col-lg-12">
                <h2><?= $one->title ?></h2>
                <?= $one->text ?>
                <?= Html::a('подробнее',['blog/one','url'=>$one->url])?>
            </div>
            <?php  endforeach; ?>
        </div>

    </div>
