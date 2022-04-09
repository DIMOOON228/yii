<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string $url
 * @property int $status_id
 * @property int $sort
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }
    public $tags_array;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['text'], 'string'],
            [['url'], 'unique'],
            [['status_id', 'sort'], 'integer'],
            [['sort'],'integer','max'=>99,'min'=>1],
            [['title'], 'string', 'max' => 250],
            [['url'], 'string', 'max' => 255],
            [['tags_array'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'url' => 'ЧПУ',
            'status_id' => 'Статутс',
            'sort' => 'Сортировка',
            'tags_arry'=>'Тэги',
            'author.useranme'=>'Имя Автора',
            'author.eamil'=>'Почта Автора',
            'tagsAsSting' => 'Тэги',
        ];
    }
    public function getAuthor(){
       return  $this->hasOne(User::className(),['id'=>'user_id']);
    }
    public function getBlogTag(){
        return  $this->hasMany(BlogTag::className(),['blog_id'=>'id']);
     }

    public function getTags(){
        return $this->hasMany(Tag::className(),['id'=>'tag_id'])->via('blogTag');
    } 

    public function afterFind()
    {
        $this->tags_array=$this->tags;
    }
    public function getTagsAsSting()
    {
        $arr = ArrayHelper::map($this->tags,'id','name');
        return implode(', ',$arr);
    }
    public function afterSave($insert,$changgeAttributes)
    {
        parent::afterSave($insert,$changgeAttributes);
        $arr = ArrayHelper::map($this->tags,'id','id');
        foreach($this->tags_array as $one){
            if(!in_array($one,$arr)){
                $model = new BlogTag();
                $model->blog_id=$this->id;
                $model->tag_id= $one;
                $model->save();
            }
            if (isset($arr[$one])){
                unset($arr[$one]);
            }
        }
        BlogTag::deleteAll(['tag_id'=>$arr]);
    }
}
