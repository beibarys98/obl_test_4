<?php

namespace common\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required', 'message' => Yii::t('app', 'ЖСН толтырылмаған!'),],
            ['username', 'match', 'pattern' => '/^(admin|\d{12})$/', 'message' => Yii::t('app', 'ЖСН 12 саннан тұруы тиіс!')],
            ['password', 'safe']
        ];
    }

    public function login()
    {
        $user = $this->getUser();

        if ($user) {
            if ($user->username === 'admin') {
                if (empty($this->password)) {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Құпия сөз енгізіңіз!'));
                    return false;
                }

                if (!$user->validatePassword($this->password)) {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'Құпия сөз қате!'));
                    return false;
                }
            }

            return Yii::$app->user->login($user);
        }else{
            Yii::$app->session->setFlash('error', Yii::t('app', 'ЖСН табылмады!'));
            return false;
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
