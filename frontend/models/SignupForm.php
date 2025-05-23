<?php

namespace frontend\models;

use common\models\File;
use common\models\Participant;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password = 'password';

    public $subject_id;
    public $name;
    public $school;
    public $language;

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
            ['email', 'required', 'message' => Yii::t('app', 'Пошта толтырылмаған!')],
            ['email', 'email', 'message' => Yii::t('app', 'Пошта example@mail.com форматында болуы тиіс!')],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'Бұл пошта бос емес!')],

            ['subject_id', 'required', 'message' => Yii::t('app', 'Пән толтырылмаған!')],
            ['name', 'required', 'message' => Yii::t('app', 'Толық аты-жөні толтырылмаған!')],
            ['school', 'required', 'message' => Yii::t('app', 'Мекеме толтырылмаған!')],
            ['language', 'required', 'message' => Yii::t('app', 'Тест тапсыру тілі толтырылмаған!')],

            ['name', 'match',
                'pattern' => '/^[А-ЯЁӘІҢҒҮҰҚӨҺа-яёәіңғүұқөһ]+(?:\s[А-ЯЁӘІҢҒҮҰҚӨҺа-яёәіңғүұқөһ]+)+$/u',
                'message' => Yii::t('app', 'Аты-жөніңіз ең кемінде екі сөзден және кириллицадан тұруы тиіс!')
            ],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();

        $participant = new Participant();
        $participant->user_id = $user->id;
        $participant->subject_id = $this->subject_id;
        $participant->name = $this->name;
        $participant->school = $this->school;
        $participant->language = $this->language;
        $participant->save();

        $receipt = new File();
        $receipt->participant_id = $participant->id;
        $receipt->type = 'receipt';
        $receipt->save();

        return true;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
