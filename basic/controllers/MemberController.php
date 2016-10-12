<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/3
 * Time: 19:38
 */
namespace app\controllers;

use Yii;
use app\models\User;
use app\controllers\CommonController;

class MemberController extends CommonController
{
    public $layout = "index";

    public function actionAuth(){
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                $url = Yii::$app->request->referrer;
                $this->redirect($url);
            }
        }
        return $this->render("authentication",['model'=>$model]);
    }

    public function actionReg(){
        $model = new User();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $res = $model->regByEmail($data);
            if($res){
                Yii::$app->session->setFlash('info','您的账户信息已发送到邮件中，请注意查收');
            }
        }
        return $this->render("authentication",['model'=>$model]);
    }

    public function actionLogout(){
        $cookies = Yii::$app->response->cookies;
        $cookies->remove(Yii::$app->params['front_login']['key']);
        return $this->goBack(Yii::$app->request->referrer);
    }

    public function actionQqlogin()
    {
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $qc = new \QC();
        $qc->qq_login();
    }

    public function actionQqcallback(){
        //获取Qq用户信息
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $auth = new \OAuth();
        $accessToken = $auth->qq_callback();
        $openid = $auth->get_openid();
        $qc = new \QC($accessToken, $openid);
        $userinfo = $qc->get_user_info();
        $userinfo['openId'] = $openid;
        //用户信息放入到缓存中
        $cache = Yii::$app->cache;
        $key = Yii::$app->params['qq_login']['memcacheKey'];
        $time = 3600*24;
        $cache->set($key,$userinfo,$time);
        $model = User::find()->where('openid = :openid', [':openid' => $openid])->one();
        if(!empty($model)){
            //写入到登录信息的cookie中
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie([
                'name' => Yii::$app->params['front_login']['key'],
                'value' => ['loginname'=>$model->username,'isLogin'=>1],
            ]));
            return $this->redirect(['index/index']);
        }
        return $this->redirect(['member/qqreg']);
    }

    public function actionQqreg(){
        $model = new User;
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $cache = Yii::$app->cache->get(Yii::$app->params['qq_login']['memcacheKey']);
            if(empty($cache)){
                return $this->redirect(["member/auth"]);
            }
            $data['User']['openId'] = $cache['openId'];
            $res = $model->regByQQ($data,$cache);
            if($res){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => Yii::$app->params['front_login']['key'],
                    'value' => ['loginname'=>$data['User']['username'],'isLogin'=>1],
                ]));
                return $this->redirect(['index/index']);
            }
        }
        return $this->render("Qreg",['model'=>$model]);
    }
}