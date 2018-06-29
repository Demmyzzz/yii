<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "static_text_item".
 *
 * @property integer $id
 * @property integer $statictext_id
 * @property string $text
 * @property string $name
 * @property integer $is_wysiwyg
 */
class StaticTextItem extends \yii\db\ActiveRecord
{

    const ECO = 1;
    const WITHOUT_DESIGN = 2;
    const RANGE = 3;
    const DELIVERY = 4;
    const TEXT = 5;
    const FURNITURE_TEXT = 6;
    const LINK = 7;

    const DESIGNERS_TEXT = 8;

    const PRODUCT_CAPTION_TEXT = 10;
    const STATIC_PREFIX = 'static';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        if(\Yii::$app->language==Base::RU) {
            return '{{%static_text_item}}';
        }elseif(\Yii::$app->language==Base::EN){
            return '{{%static_text_item_en_us}}';
        }
    }

    public function getStatictext()
    {
        return $this->hasOne(StaticText::className(),['id' => 'statictext_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statictext_id'], 'required'],
            [['statictext_id', 'is_wysiwyg'], 'integer'],
            [['text'], 'string' , 'max' => 100000],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statictext_id' => 'Statictext ID',
            'text' => 'Текст',
            'name' => 'Название',
            'is_wysiwyg' => 'Is Wysiwyg',
        ];
    }
}
