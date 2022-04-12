<?php

use common\models\Blog;
use common\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\file\FileInput;
// mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">
         
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'],]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url',['options'=>['class'=>'col-xs-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id',['options'=>['class'=>'col-xs-6']])->dropDownList([Blog::STATUS_LIST]) ?>

    <?= $form->field($model, 'sort',['options'=>['class'=>'col-xs-6']])->textInput() ?>
    

    <?= $form ->field($model ,'tags_array',['options'=>['class'=>'col-xs-6']])->widget(\kartik\select2\Select2::classname(), [
     'data' => ArrayHelper::map(Tag::find()->all(),'id','name'),
     'language' => 'ru' ,
     'options' => [ 'placeholder' => 'Выбрать tag','multiple' => true ],
     'pluginOptions' => [
        'allowClear' => true,
        'tags' => true,
        'maximumInputLength' => 10
        ],    
]); ?>
 <?= $form->field($model, 'text')->widget(Widget::className(),[
        'settings'=>[
            'lang'=>'ru',
            'minHeight'=>200,
            'formating'=>['p','blockquote','h2','h1'],
            'imageUpload'=>Url::to(['/site/save-redactor-img','sub'=>'/blog']),
            'plugins'=>[
                'clips',
                'fullscreen'
            ]
        ]
    ])?>
        <?= $form ->field($model ,'tags_array',['options'=>['class'=>'col-xs-6']])->widget(\kartik\select2\Select2::classname(), [
     'data' => ArrayHelper::map(Tag::find()->all(),'id','name'),
     'language' => 'ru' ,
     'options' => [ 'placeholder' => 'Выбрать tag','multiple' => true ],
     'pluginOptions' => [
        'allowClear' => true,
        'tags' => true,
        'maximumInputLength' => 10
        ],    
]); ?>
    <?=  $form->field($model, 'file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fas fa-camera"></i> ',
        'browseLabel' =>  'Select Photo'
    ],]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- <pre><?php print_r(ArrayHelper::map($model->getTags()->asArray()->all(),'id','name')) ?></pre> -->