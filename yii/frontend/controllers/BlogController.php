<?php

namespace frontend\controllers;
use common\models\Blog;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlogController extends Controller
{

    public function actionIndex()
    {
        $blogs = Blog::find()->where(['status_id'=>0])->orderBy('sort')->all();
        return $this->render('all',compact('blogs'));
    }
    public function actionOne($url)
    {
       if($blog = Blog::find()->where(['url'=>$url])->one()) {
        return $this->render('one',compact('blog')); 
       }
       throw new NotFoundHttpException('нет такого блога');
    }

}