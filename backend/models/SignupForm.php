<?php
namespace backend\models;

use common\models\Adminuser;
use yii\base\Model;
use yii\helpers\VarDumper;

//use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $nickname;
    public $password;
    public $password_repeat;
    public $profile;
    public $status;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['nickname', 'string', 'min' => 2, 'max' => 255],
            ['nickname', 'trim'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','operator'=>'==='],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'username' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'password_repeat' => '再次确认密码',
            'email' => '邮箱',
            'profile' => 'Profile',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' =>'状态',
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
        $user->password = '*';
        $user->status = 10;
        $user->email = $this->email;
        $user->profile = $this->profile;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
