<?php
namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute'=>'password','message'=>'Passwords are not Matching!'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'password_repeat'=>'Repeat Password',
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $admuser = Adminuser::findOne($id);
        $admuser->setPassword($this->password);
        $admuser->removePasswordResetToken();

        return $admuser->save() ? true : false;
    }
}
