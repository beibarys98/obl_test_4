<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%participant}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $subject_id
 * @property string|null $name
 * @property string|null $school
 * @property string|null $language
 *
 * @property File[] $files
 * @property ParticipantAnswer[] $participantAnswers
 * @property ParticipantTest[] $participantTests
 * @property Subject $subject
 * @property User $user
 */
class Participant extends \yii\db\ActiveRecord
{
    public $username;
    public $email;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%participant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => Yii::t('app', 'ЖСН толтырылмаған!')],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Бұл ЖСН бос емес!')],
            ['username', 'match', 'pattern' => '/^\d{12}$/', 'message' => Yii::t('app', 'ЖСН 12 саннан тұруы тиіс!')],

            ['email', 'trim'],
            ['email', 'email', 'message' => Yii::t('app', 'Пошта example@mail.com форматында болуы тиіс!')],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Бұл пошта бос емес!')],

            [['name', 'school', 'language'], 'default', 'value' => null],
            [['user_id', 'subject_id'], 'required'],
            [['user_id', 'subject_id', 'test_id', 'result'], 'integer'],
            [['payment_time', 'start_time', 'end_time'], 'safe'],
            [['name', 'school'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'name' => Yii::t('app', 'Name'),
            'school' => Yii::t('app', 'School'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FileQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['participant_id' => 'id']);
    }

    /**
     * Gets query for [[ParticipantAnswers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ParticipantAnswerQuery
     */
    public function getParticipantAnswers()
    {
        return $this->hasMany(ParticipantAnswer::class, ['participant_id' => 'id']);
    }

    /**
     * Gets query for [[ParticipantTests]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ParticipantTestQuery
     */
    public function getParticipantTests()
    {
        return $this->hasMany(ParticipantTest::class, ['participant_id' => 'id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ParticipantQuery(get_called_class());
    }

}
