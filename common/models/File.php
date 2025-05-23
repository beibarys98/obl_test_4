<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id
 * @property int|null $participant_id
 * @property int|null $test_id
 * @property string $type
 * @property string $file_path
 *
 * @property Participant $participant
 * @property Test $test
 */
class File extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => ['pdf'], 'skipOnEmpty' => false],

            [['participant_id', 'test_id'], 'default', 'value' => null],
            [['participant_id', 'test_id'], 'integer'],
            [['type', 'file_path'], 'required'],
            [['type'], 'string', 'max' => 50],
            [['file_path'], 'string', 'max' => 255],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::class, 'targetAttribute' => ['participant_id' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::class, 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'participant_id' => Yii::t('app', 'Participant ID'),
            'test_id' => Yii::t('app', 'Test ID'),
            'type' => Yii::t('app', 'Type'),
            'file_path' => Yii::t('app', 'File Path'),
        ];
    }

    /**
     * Gets query for [[Participant]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ParticipantQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::class, ['id' => 'participant_id']);
    }

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TestQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::class, ['id' => 'test_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FileQuery(get_called_class());
    }

}
