<?php

/** @var yii\web\View $this */
use yii\bootstrap\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach($blogs as $one): ?>

            <div class="col-lg-4">
                <h2><?= $one->title ?></h2>
                 <!-- <?= $one->text ?>  -->
                 <?= Html::a('подробнее',['blog/one','url'=>$model->url],['class'=> "btn btn-success"]) ?><hr>
            </div>

            <?php  endforeach; ?>
        </div>

    </div>
</div>
