<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/3
 * Time: 10:39
 */

namespace app\modules\controllers;
use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use yii\web\Controller;


class ManageController extends Controller
{
    public $layout = false;

    public function actionMailchangepass()
    {
        $model = new Admin();
        $token = Yii::$app->request->get('token');
        $timestamp = Yii::$app->request->get('timestamp');
        $adminuser = Yii::$app->request->get('adminuser');
        $authtoken = $model->createToken($timestamp,$adminuser);
        if($token!=$authtoken){
            $this->redirect(['admin/login']);
        }
        $now = time();
        if($now-$timestamp>300){
            $this->redirect(['admin/login']);
        }
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $res = $model->mailchangepass($data);
            if($res){
                Yii::$app->session->setFlash('info','密码修改成功');
            }
        }
        return $this->render('changepass',['model'=>$model]);
    }

    public function actionList(){
        $this->layout = 'main';
        $model = Admin::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['manage']['pageSize'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("list",['managers'=>$managers,'pager'=>$pager]);
    }

    public function actionAdd(){
        $this->layout = 'main';
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $res = $model->adminAdd($data);
            if($res){
                Yii::$app->session->setFlash('info','管理员添加成功');
            }else{
                Yii::$app->session->setFlash('info','管理员添加失败');
            }
        }
        $model->adminpass = "";
        $model->repass = "";
        return $this->render('add',['model'=>$model]);
    }

    public function actionDel(){
        $adminId = Yii::$app->request->get('adminid');
        if(empty($adminId)){
            $this->redirect(['manage/list']);
        }
        $res = Admin::deleteAll(['adminid'=>$adminId]);
        if($res){
            $this->redirect(['manage/list']);
        }
    }

    public function actionMailchange(){
        $this->layout = 'main';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $res = $model->mailchange($data);
            if($res){
                Yii::$app->session->setFlash('info','邮件信息修改成功');
            }
        }
        $model->adminpass = "";
        return $this->render('changeEmail',['model'=>$model]);
    }

    public function actionChangepwd(){
        $this->layout = 'main';
        $model = Admin::find()->where('adminuser = :user', [':user' => Yii::$app->session['admin']['adminuser']])->one();
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $res = $model->changepwd($data);
            if($res){
                Yii::$app->session->setFlash('info','密码修改成功');
            }
        }
        $model->adminpass = "";
        $model->repass = "";
        return $this->render('changepwd',['model'=>$model]);
    }
}