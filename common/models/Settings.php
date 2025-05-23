<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property int $id
 * @property string|null $purpose
 * @property int|null $cost
 * @property int|null $first
 * @property int|null $second
 * @property int|null $third
 * @property int|null $fourth
 * @property int|null $fifth
 */
class Settings extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purpose', 'cost', 'first', 'second', 'third', 'fourth', 'fifth'], 'default', 'value' => null],
            [['cost', 'first', 'second', 'third', 'fourth', 'fifth', 'cx', 'name_y', 'number_x', 'number_y'], 'integer'],
            [['acw'], 'number'], // 'number' is used for floats and decimals
            [['purpose'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'purpose' => Yii::t('app', 'Purpose'),
            'cost' => Yii::t('app', 'Cost'),
            'first' => Yii::t('app', 'First'),
            'second' => Yii::t('app', 'Second'),
            'third' => Yii::t('app', 'Third'),
            'fourth' => Yii::t('app', 'Fourth'),
            'fifth' => Yii::t('app', 'Fifth'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SettingsQuery(get_called_class());
    }

}
