<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%test}}".
 *
 * @property int $id
 * @property int $subject_id
 * @property string|null $language
 * @property string|null $version
 * @property string|null $status
 * @property string|null $duration
 *
 * @property File[] $files
 * @property ParticipantTest[] $participantTests
 * @property Question[] $questions
 * @property Subject $subject
 */
class Test extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'doc, docx', 'skipOnEmpty' => false],

            [['language', 'version', 'status', 'duration'], 'default', 'value' => null],
            [['subject_id'], 'required'],
            [['subject_id'], 'integer'],
            [['duration'], 'safe'],
            [['language'], 'string', 'max' => 100],
            [['version', 'status'], 'string', 'max' => 50],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::class, 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'language' => Yii::t('app', 'Language'),
            'version' => Yii::t('app', 'Version'),
            'status' => Yii::t('app', 'Status'),
            'duration' => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FileQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['test_id' => 'id']);
    }

    /**
     * Gets query for [[ParticipantTests]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ParticipantTestQuery
     */
    public function getParticipantTests()
    {
        return $this->hasMany(ParticipantTest::class, ['test_id' => 'id']);
    }

    /**
     * Gets query for [[Questions]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\QuestionQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['test_id' => 'id']);
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\SubjectQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TestQuery(get_called_class());
    }

}
