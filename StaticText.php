<?php

namespace backend\models;

use common\helpers\ImageCommon;

/**
 * This is the model class for table "static_text".
 *
     * @property integer $id
     * @property string $name
     * @property string $surl
     * @property string $title
     * @property string $keywords
     * @property string $desc
     * @property integer $active
     * @property integer $pos
     * @property string $ext
 */
class StaticText extends Base
{
    use CommonModelEventExtTrait;
    use CommonModelTrait;

    const NAME = 'Редактируемые тексты';
    const ONE_NAME = 'редактируемый текст';

    const MAIN_PAGE = 1;
    const FURNITURE = 2;
    const CART = 3;
    const DESIGNERS = 4;

    public $texts;
    public $photos = [];

    public static function getConfig()
    {
        return [
            'image' => [
//                'engine'    =>  'ImageUtilLegacyHelper',
//                'engineWatermark'   =>  'WideImageHelper',
////                'engineWatermark'   =>  'YiiImageHelper',

            ],
            'images'    =>  [
                '_big'    =>  [
                    'w' =>  1920,
                    'h' =>  1080,
                    'type' => ImageCommon::RESIZE_AUTO,
                    'bg_color'  => '#fff',
                    'doIfImgMoreBigger' => true,
//                    'coords_strict' => true
                ],
                '_sm'    =>  [
                    'w' =>  200,
                    'h' =>  300,
                    'type' => ImageCommon::RESIZE_CROP,
                    'bg_color'  => '#fff',
//                    'watermarks' =>  [
//                        [
//                            'name'  =>  'watermark.png',
////                            'x' =>  0,
////                            'y' =>  0,
//////                            'opacity'   =>  50,
////                            'opacity'   =>  100,
//                        ],
//                        [
//                            'name'  =>  'watermark1.png',
////                            'x' =>  true,
////                            'y' =>  false,
////                            'opacity'   =>  80,
//
////                            'x' =>  0,
////                            'y' =>  0,
////                            'opacity'   =>  100,
//
//                        ]
//                    ]
                ],

            ]
        ];
    }
    public static function tableName()
    {
        if(\Yii::$app->language==Base::RU) {
            return '{{%static_text}}';
        }elseif(\Yii::$app->language==Base::EN){
            return '{{%static_text_en_us}}';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['!active', '!pos'], 'integer'],
            [['ext'], 'each' , 'rule' => ['string']],
            [['name'], 'unique'],
            [['surl'], 'unique'],
            [['title','desc','keywords'] ,'string']
        ];
    }

    public function getItems()
    {
        return $this->hasMany(StaticTextItem::className(),['statictext_id' => 'id']);
    }
    public function getPhotos()
    {
        return $this->hasMany(StaticTextPhoto::className(),['static_text_id' => 'id']);
    }
    /*


    public function getMaps()
    {
        return $this->hasMany(StaticTextMap::className(),['statictext_id' => 'id']);
    }


    */
    public function getPageToAll()
    {
        return $this->hasOne(PageToAll::className(),['page_id' => 'id']);
    }

    public function getAssocModule()
    {
        return $this->hasOne(AllModels::className(),['module_name' => 'module_name'])->via('pageToAll');
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->processEventsFor(__FUNCTION__,$insert);
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        $this->processEventsFor(__FUNCTION__);
    }

    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            $this->deleteImagesMany();
            if($m = $this->getPageToAll()->one())
                $m->delete();
            //PageItem::deleteAll(['page_id' => $this->id]);
            //PageMap::deleteAll(['page_id' => $this->id]);
            //PagePhoto::deleteAll(['page_id' => $this->id]);
            //FS::DeleteDir($this->getUploadPath(true,PagePhoto::tableName()) . $this->id . '/');

            return true;
        }
        else
            return false;
    }

}
