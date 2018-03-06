<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $file;
    public $logo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],


            [['file'],'file'],


            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        //return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password'=>'密码',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'file'=>'上传头像',
            'logo' =>'头像',
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
        
        $user = new User();
        $user->logo = $this->logo;

        $user->username = $this->username;

//       print_r($user->username);
//        var_dump($user->logo);
//        print_r($user->logo);//die;

        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
