<?php
use common\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'formaoting'=>['p', 'blokquote', 'h2','h1'],
        'plugins' => [
            'clips',
            'fullscreen'
        ]
    ]
]);?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(['off','on']) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form ->field($model ,'tags_array')->widget(\kartik\select2\Select2::classname(), [
     'data' => ArrayHelper::map(Tag::find()->all(),'id','name'),
     'language' => 'ru' ,
     'options' => [ 'placeholder' => 'Выбрать tag','multiple' => true ],
     'pluginOptions' => [
        'allowClear' => true,
        'tags' => true,
        'maximumInputLength' => 10
        ],    
]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- <pre><?php print_r(ArrayHelper::map($model->getTags()->asArray()->all(),'id','name')) ?></pre> -->