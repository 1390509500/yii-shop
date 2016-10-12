<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/2
 * Time: 16:17
 */

namespace app\modules\controllers;

use Yii;
use app\models\admin\AdminModel;
use app\modules\models\Admin;
use yii\web\Controller;

class AdminController extends Controller
{

    public $layout = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionLogin()
    {
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $isLogin = $model->login($data);
            if($isLogin){
                $this->redirect(['index/index']);
                Yii::$app->end();
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLogout(){
        Yii::$app->session->removeAll();
        if(!isset(Yii::$app->session['admin']['isLogin'])){
            $this->redirect(['admin/login']);
            Yii::$app->end();
        }
        $this->goBack();
    }

    /**
     * 找回密码并发送邮件
     */
    public function actionSeekpass(){
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $email = $model->seekpass($data);
            if($email){
                Yii::$app->session->setFlash('info','电子邮件发送成功注意查收');
            }
        }
        return $this->render('seekpass',['model'=>$model]);
    }
}