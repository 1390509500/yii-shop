<?php

namespace app\modules\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $adminid
 * @property string $adminuser
 * @property string $adminpass
 * @property string $adminemail
 * @property integer $logintime
 * @property integer $loginip
 * @property string $userSession
 * @property integer $createtime
 */
class Admin extends \yii\db\ActiveRecord
{

    public $rememberMe;
    public $repass;
    public $newpass;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['adminuser','required','message'=>'管理员账号不能为空','on' => ['login','seekpass','mailchangepass','adminAdd','mailchange','changepwd']],
            ['adminuser','unique','message'=>'管理员已被注册','on' => 'adminAdd'],
            ['adminpass','required','message'=>'管理员密码不能为空','on' => ['login','mailchangepass','adminAdd','mailchange','changepwd']],
            ['rememberMe','boolean','on' => 'login'],
            ['adminpass','validatePass','on' => ['login','mailchange','changepwd']],
            ['adminemail','required','message'=>'电子邮件账号不能为空','on' => ['seekpass','adminAdd','mailchange']],
            ['adminemail','email','message'=>'电子邮件格式不正确','on' => ['seekpass','adminAdd','mailchange']],
            ['adminemail','unique','message'=>'电子邮箱已被注册','on' => ['adminAdd','mailchange']],
            ['adminemail','validateEmail','on' => 'seekpass'],
            ['newpass','required','message'=>'新密码不能为空','on' => 'changepwd'],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['mailchangepass','adminAdd','changepwd']],
            ['repass', 'compare', 'compareAttribute' => 'adminpass', 'message' => '两次密码输入不一致', 'on' => ['mailchangepass','adminAdd']],
            ['newpass', 'compare', 'compareAttribute' => 'repass', 'message' => '两次密码输入不一致', 'on' => 'changepwd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adminid' => 'Adminid',
            'adminuser' => '管理员账号',
            'adminpass' => '管理员密码',
            'adminemail' => '管理员邮箱',
            'logintime' => 'Logintime',
            'loginip' => 'Loginip',
            'userSession' => 'User Session',
            'createtime' => 'Createtime',
            'repass' => '确认密码',
            'newpass' => '新密码'
        ];
    }

    public function createToken($time,$adminuser){
        return md5(md5($time).base64_encode(Yii::$app->request->userIP).md5($adminuser));
    }
    public function validatePass(){
        if(!$this->hasErrors()){
            $data = self::find()->where('adminuser = :user and adminpass = :pass', [":user" => $this->adminuser, ":pass" => md5($this->adminpass)])->asArray()->one();
            if(is_null($data)){
                $this->addError("adminpass", "用户名或者密码错误");
            }
        }
    }

    public function validateEmail(){
        if(!$this->hasErrors()){
            $data = self::find()->where('adminuser = :user and adminemail = :email', [":user" => $this->adminuser, ":email" => $this->adminemail])->asArray()->one();
            if(is_null($data)){
                $this->addError("adminemail", "电子邮件不匹配");
            }
        }
    }
    public function login($data){
        $this->scenario = 'login';
        if($this->load($data) && $this->validate()){
            //设置cookie24小时
            $expireTime = $this->rememberMe ? 24*3600 : 0;
            $session = Yii::$app->session;
            session_set_cookie_params($expireTime);
            $session['admin'] = [
                'adminuser'=>$this->adminuser,
                'logintime'=>time(),
                'isLogin'=>1,
                'loginIp'=>ip2long(Yii::$app->request->userIP)
            ];
            $userSession = serialize($session->get('admin'));
            //更新数据库
            $this->updateAll(['logintime'=>time(),'loginIp'=>ip2long(Yii::$app->request->userIP),'userSession'=>$userSession],['adminuser'=>$this->adminuser,'adminpass'=>md5($this->adminpass)]);
            return true;
        }
        return false;
    }

    public function seekpass($data){
        $this->scenario = 'seekpass';
        if($this->load($data) && $this->validate()){
            //创建token
            $time = time();$adminuser = $data['Admin']['adminuser'];
            $token = $this->createToken($time,$adminuser);
            $mailer = Yii::$app->mailer->compose('seekpass', ['adminuser' => $adminuser,'time'=>$time,'token'=>$token]);
            $mailer->setFrom('m15045687756@163.com');
            $mailer->setTo($data['Admin']['adminemail']);
            $mailer->setSubject('商城找回密码');
            if($mailer->send()){
                return true;
            }
        }
        return false;
    }

    public function mailchangepass($data){
        $this->scenario = 'mailchangepass';
        if($this->load($data) && $this->validate()){
            $this->updateAll(['adminpass'=>md5($this->adminpass)],'adminuser = :adminuser',[':adminuser'=>$this->adminuser]);
            return true;
        }
        return false;
    }


    public function adminAdd($data){
        $this->scenario = 'adminAdd';
        if($this->load($data) && $this->validate())
        {
            $this->adminpass = md5($data['Admin']['adminpass']);
            //传递False不进行validate验证
            if($this->save(false)){
                return true;
            }
        }
        return false;
    }

    public function mailchange($data){
        $this->scenario = 'mailchange';
        if($this->load($data) && $this->validate())
        {
            $adminuser = Yii::$app->session->get('admin')['adminuser'];
            $this->updateAll(['adminemail' => $this->adminemail],'adminuser = :adminuser',[':adminuser'=>$adminuser]);
            return true;
        }
        return false;
    }

    public function changepwd($data){
        $this->scenario = 'changepwd';
        if($this->load($data) && $this->validate())
        {
            $adminuser = Yii::$app->session->get('admin')['adminuser'];
            $this->updateAll(['adminpass' => md5($this->newpass)],'adminuser = :adminuser',[':adminuser'=>$adminuser]);
            return true;
        }
        return false;
    }
}