<?php

namespace app\models;

use app\models\Profile;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $userId
 * @property string $username
 * @property string $userpass
 * @property string $useremail
 * @property integer $createtime
 */
class User extends \yii\db\ActiveRecord
{

    public $rememberMe;
    public $loginname;
    public $repass;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['useremail','required','message'=>'电子邮件账号不能为空','on' => ['regByEmail','regByQQ']],
            ['useremail','email','message'=>'电子邮件格式不正确','on' => ['regByEmail','regByQQ']],
            ['useremail','unique','message'=>'该电子邮箱已被注册','on' => ['regByEmail','regByQQ']],
            ['loginname','required','message'=>'用户名/电子邮箱不能为空','on' => ['login']],
            ['loginname','validateLoginname','on'=>'regByEmail'],
            ['openId', 'required', 'message' => 'openId不能为空', 'on' => ['regByQQ']],
            ['userpass','required','message'=>'密码不能为空','on' => ['login','regByQQ']],
            ['userpass','validatePass','on'=>'login'],
            ['repass', 'required', 'message' => '确认密码不能为空', 'on' => ['regByQQ']],
            ['repass', 'compare', 'compareAttribute' => 'userpass', 'message' => '两次密码输入不一致', 'on' => ['regByQQ']],
            ['rememberMe','boolean','on' => 'login'],
        ];
    }

    public function validateLoginname(){
        if(!$this->hasErrors()){
            $loginname = "username";
            if (preg_match('/@/', $this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname.' = :loginname', [':loginname' => $this->loginname])->all();
            if (!empty($data)) {
                $this->addError("loginname", "该用户名/电子邮件已被注册");
            }
        }
    }

    public function validatePass(){
        if(!$this->hasErrors()){
            $loginname = "username";
            if (preg_match('/@/', $this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname.' = :loginname and userpass = :pass', [':loginname' => $this->loginname, ':pass' => md5($this->userpass)])->one();
            if (is_null($data)) {
                $this->addError("userpass", "用户名或者密码错误");
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'username' => '用户名',
            'userpass' => '密码',
            'useremail' => '电子邮箱',
            'createtime' => 'Createtime',
            'loginname' => '用户名/电子邮箱',
            'repass' => '确认密码'
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['userId' => 'userId']);
    }

    public function reg($data, $scenario = 'reg')
    {
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->createtime = time();
            $this->userpass = md5($data['User']['userpass']);
            $this->username = $data['User']['username'];
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function regByEmail($data){
        $data['User']['username'] = 'visitor'.uniqid();
        $data['User']['userpass'] = uniqid();
        $this->scenario = "regByEmail";
        if($this->load($data) && $this->validate()){
            //发送邮件
            $mailer = Yii::$app->mailer->compose('regByEmail', ['username' => $data['User']['username'],'userpass'=>$data['User']['userpass']]);
            $mailer->setFrom('m15045687756@163.com');
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject('用户注册信息');
            if($mailer->send() && $this->reg($data, 'regByEmail')){
                return true;
            }
        }
    }

    public function login($data){
        $this->scenario = "login";
        if ($this->load($data) && $this->validate()) {
            $lifetime = $this->rememberMe ? time()+24*3600*30 : 0;
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => Yii::$app->params['front_login']['key'],
                'value' => ['loginname'=>$this->loginname,'isLogin'=>1],
                'expire'=> $lifetime,
            ]));
            return true;
        }
        return false;
    }

    public function regByQQ($data,$cache){
        $this->scenario = "regByQQ";
        if($this->load($data) && $this->validate()){
            $this->createtime = time();
            $this->userpass = md5($data['User']['userpass']);
            $this->username = $data['User']['username'];
            $trans = Yii::$app->db->beginTransaction();
            try{
                $usermodel = $this->save(false);
                if(empty($usermodel)){
                    throw new \Exception();
                }
                $profile = new \app\models\Profile();
                $profile->nickname= $cache['nickname'];
                $profile->year= $cache['year'];
                $profile->sex= $cache['gender'];
                $profile->city= $cache['city'];
                $profile->province= $cache['province'];
                $profile->userId= $this->attributes['userId'];
                $profile->createtime=time();
                $model = $profile->insert();
                $trans->commit();
            }catch(\Exception $e) {
                if (Yii::$app->db->getTransaction()) {
                    $trans->rollback();
                }
            }
            if(!empty($usermodel && !empty($model))){
                return true;
            }
            return false;
        }
    }
}