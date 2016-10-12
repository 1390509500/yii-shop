<?php

namespace app\controllers;
use app\controllers\CommonController;

use Yii;
use app\models\User;
use app\models\Address;

class AddressController extends CommonController
{
    public function actionAdd()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(Yii::$app->params['front_login']['key'])){
            $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
            if ($loginInfo->value['isLogin'] != 1){
                return $this->redirect(['member/auth']);
            }
        }
        $loginname = $loginInfo->value['loginname'];
        $userId = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userId;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $post['userId'] = $userId;
            $post['address'] = $post['address1'].$post['address2'];
            $data['Address'] = $post;
            $model = new Address;
            $model->load($data);
            $model->save();
        }
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionDel()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(Yii::$app->params['front_login']['key'])){
            $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
            if ($loginInfo->value['isLogin'] != 1){
                return $this->redirect(['member/auth']);
            }
        }
        $loginname = $loginInfo->value['loginname'];
        $userId = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userId;
        $addressId = Yii::$app->request->get('addressId');
        if (!Address::find()->where('userId = :uid and addressId = :aid', [':uid' => $userId, ':aid' => $addressId])->one()) {
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
        Address::deleteAll('addressId = :aid', [':aid' => $addressId]);
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }










}
