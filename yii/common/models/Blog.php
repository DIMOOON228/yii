<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\components\behaviors\StatusBehavior;
use GdImage;
use phpDocumentor\Reflection\Types\Null_;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string $url
 * @property string $data_create
 * @property string $data_update
 * @property int $status_id
 * @property int $sort
 * @property int $image
 */
class Blog extends \yii\db\ActiveRecord
{
    const STATUS_LIST = ['off','on'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }
    public $tags_array;
    public $file;
    public function behaviors()
    {
        return [
            'timestampBehavior'=>[
                'class' => TimestampBehavior::classname(),
                'createdAtAttribute' => 'data_create',
                'updatedAtAttribute' => 'data_update',
                'value' => new Expression('NOW()'),
            ],
            'statusBehavior'=>[
                'class' => StatusBehavior::classname(),
                'statusList'=>self::STATUS_LIST,
            ]
        ];
    }
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
            [['image'],'string','max'=>100],
            [['file'],'image'],
            [['tags_array','data_update','data_create'], 'safe'], 
            
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
            'tags_array'=>'Тэги',
            'file'=>'Картинка',
            'image'=>'Картинка',
            'author.username'=>'Имя Автора',  
            'author.email'=>'Почта Автора',
            'data_create'=>'Дата создания',  
            'data_update'=>'Дата обновления',
            'tagsAsSting' => 'Тэги',
        ];
    }
    public function getAuthor(){
       return $this->hasOne(User::className(),['id'=>'user_id']);
    }
    public function getBlogTag(){
        return $this->hasMany(BlogTag::className(),['blog_id'=>'id']);
     }

    public function getTags(){
        return $this->hasMany(Tag::className(),['id'=>'tag_id'])->via('blogTag');
    } 

    public function afterFind()
    {
        parent::afterFind();
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
        if($this->tags_array){
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
    }
        BlogTag::deleteAll(['tag_id'=>$arr,'blog_id'=>$this->id]);
    }
}
//     public function beforeSave($insert)
//     {
//         if ($file = UploadedFile::getInstance($this,'file')){
//             $dir = Yii::getAlias('@images').'/blog/';
//             if(file_exists($dir.$this->image)){
//                 unlink($dir.$this->image);
//             }
//             if(file_exists($dir.'50x50/'.$this->image)){
//                 unlink($dir.'50x50/'.$this->image);
//             }
//             if(file_exists($dir.'800x/'.$this->image)){
//                 unlink($dir.'800x/'.$this->image);
//             }
//             $this->image = strtotime('now').'_'. Yii::$app->getSecurity()->generateRandomString(7).'.'.$file->extension;
//             $file->saveAs($dir.$this->image);
//             $imag = Yii::$app->image->load($dir.$this->image);
//             $imag->background('#fff',0);
//             $imag->resize('50','50',yii\image\drivers\Image::INVERSE);
//             $imag->crop('50','50');
//             $imag->save($dir.'50x50/'.$this->image,90);
//             $imag = Yii::$app->image->load($dir.$this->image);
//             $imag->background('#fff',0);
//             $imag->resize('800',null,yii\image\drivers\Image::INVERSE);
//             $imag->save($dir.'800x/'.$this->image,90);
//         }
//         return parent::beforeSave($insert);
//     }

