<?php

namespace frontend\controllers;
use yii\data\ActiveDataProvider;
use common\models\Blog;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BlogController extends Controller
{

    public function actionIndex()
    {
        $blogs = Blog::find()->with('author')->orderBy('sort');
        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                 'pageSize' => 10,
               ],
            ]);
        return $this->render('all',compact('blogs','dataProvider'));
    }
    public function actionOne($url)
    {
       if($blog = Blog::find()->where(['url'=>$url])->one()) {
        return $this->render('one',compact('blog')); 
       }
       throw new NotFoundHttpException('нет такого блога');
    }

}