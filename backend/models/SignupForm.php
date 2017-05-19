<?php
namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $nickname;
    public $email;
    public $password;
    public $password_repeat;
    public $profile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => 'User Name existed!'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => 'Email existed!'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute'=>'password','message'=>'Passwords not matching'],

            ['nickname','required'],
            ['nickname','string','max'=>128],

            ['profile','string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'User Name',
            'nickname' => 'Nick Name',
            'password' => 'Password',
            'password_repeat'=>'Repeat Password',
            'email' => 'Email',
            'profile' => 'Profile',
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new Adminuser();
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->email = $this->email;
        $user->profile = $this->profile;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password = '********';//no meaning for the password, the password store in the password hash right now
        //not the best way to do so
        //  $user->save(); VarDumper::dump($user->errors);exit(0);
        return $user->save() ? $user : null;
    }
}
