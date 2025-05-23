<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subject}}".
 *
 * @property int $id
 * @property string $title_kz
 * @property string $title_ru
 * @property string|null $first
 * @property string|null $second
 * @property string|null $third
 * @property string|null $fourth
 * @property string|null $fifth
 *
 * @property Participant[] $participants
 * @property Test[] $tests
 */
class Subject extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subject}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first', 'second', 'third', 'fourth', 'fifth'], 'default', 'value' => null],
            [['title_kz', 'title_ru'], 'required'],
            [['title_kz', 'title_ru', 'first', 'second', 'third', 'fourth', 'fifth'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title_kz' => Yii::t('app', 'Title Kz'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'first' => Yii::t('app', 'First'),
            'second' => Yii::t('app', 'Second'),
            'third' => Yii::t('app', 'Third'),
            'fourth' => Yii::t('app', 'Fourth'),
            'fifth' => Yii::t('app', 'Fifth'),
        ];
    }

    /**
     * Gets query for [[Participants]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ParticipantQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::class, ['subject_id' => 'id']);
    }

    /**
     * Gets query for [[Tests]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::class, ['subject_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\SubjectQuery(get_called_class());
    }

}
