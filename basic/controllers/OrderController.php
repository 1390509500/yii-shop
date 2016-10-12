<?php
namespace app\controllers;
use app\controllers\CommonController;
use Yii;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Cart;
use app\models\Product;
use app\models\User;
use app\models\Address;
use app\models\Pay;
use dzer\express\Express;

class OrderController extends CommonController
{
    public $layout = "index";
    public function actionIndex()
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
        $orders = Order::getProducts($userId);
        return $this->render("index", ['orders' => $orders]);
    }

    public function actionCheck()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(Yii::$app->params['front_login']['key'])){
            $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
            if ($loginInfo->value['isLogin'] != 1){
                return $this->redirect(['member/auth']);
            }
        }
        $loginname = $loginInfo->value['loginname'];
        $orderId = Yii::$app->request->get('orderId');
        $status = Order::find()->where('orderId = :oId', [':oId' => $orderId])->one()->status;
        if ($status != Order::CREATEORDER && $status != Order::CHECKORDER) {
            return $this->redirect(['order/index']);
        }
        $userId = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userId;
        $addresses = Address::find()->where('userId = :uId', [':uId' => $userId])->asArray()->all();
        $details = OrderDetail::find()->where('orderId = :oId', [':oId' => $orderId])->asArray()->all();
        $data = [];
        foreach($details as $detail) {
            $model = Product::find()->where('productId = :pId' , [':pId' => $detail['productId']])->one();
            $detail['title'] = $model->title;
            $detail['cover'] = $model->cover;
            $data[] = $detail;
        }
        $express = Yii::$app->params['express'];
        $expressPrice = Yii::$app->params['expressPrice'];
        return $this->render("check", ['express' => $express, 'expressPrice' => $expressPrice, 'addresses' => $addresses, 'products' => $data]);
    }

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
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                $ordermodel = new Order;
                $ordermodel->scenario = 'add';
                $usermodel = User::find()->where('username = :name ', [':name' => $loginname])->one();
                if (!$usermodel) {
                    throw new \Exception();
                }
                $userId = $usermodel->userId;
                $ordermodel->userId = $userId;
                $ordermodel->status = Order::CREATEORDER;
                $ordermodel->createtime = time();
                if (!$ordermodel->save()) {
                    throw new \Exception();
                }
                $orderId = $ordermodel->getPrimaryKey();
                foreach ($post['OrderDetail'] as $product) {
                    $model = new OrderDetail;
                    $product['orderId'] = $orderId;
                    $product['createtime'] = time();
                    $data['OrderDetail'] = $product;
                    if (!$model->add($data)) {
                        throw new \Exception();
                    }
                    Cart::deleteAll('productId = :pId' , [':pId' => $product['productId']]);
                    Product::updateAllCounters(['num' => -$product['productnum']], 'productId = :pId', [':pId' => $product['productId']]);
                }
            }
            $transaction->commit();
        }catch(\Exception $e) {
            $transaction->rollback();
            return $this->redirect(['cart/index']);
        }
        return $this->redirect(['order/check', 'orderId' => $orderId]);
    }

    public function actionConfirm()
    {
        //addressId, expressId, status, amount(orderId,userId)
        try {
            $cookies = Yii::$app->request->cookies;
            if($cookies->has(Yii::$app->params['front_login']['key'])){
                $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
                if ($loginInfo->value['isLogin'] != 1){
                    return $this->redirect(['member/auth']);
                }
            }
            if (!Yii::$app->request->isPost) {
                throw new \Exception();
            }
            $post = Yii::$app->request->post();
            $loginname = $loginInfo->value['loginname'];
            $usermodel = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one();
            if (empty($usermodel)) {
                throw new \Exception();
            }
            $userId = $usermodel->userId;
            $model = Order::find()->where('orderId = :oId and userId = :uId', [':oId' => $post['orderId'], ':uId' => $userId])->one();
            if (empty($model)) {
                throw new \Exception();
            }
            $model->scenario = "update";
            $post['status'] = Order::CHECKORDER;
            $details = OrderDetail::find()->where('orderId = :oId', [':oId' => $post['orderId']])->all();
            $amount = 0;
            foreach($details as $detail) {
                $amount += $detail->productnum*$detail->price;
            }
            if ($amount <= 0) {
                throw new \Exception();
            }
            $express = Yii::$app->params['expressPrice'][$post['expressId']];
            if ($express < 0) {
                throw new \Exception();
            }
            $amount += $express;
            $post['amount'] = $amount;
            $data['Order'] = $post;
            if (empty($post['addressId'])) {
                return $this->redirect(['order/pay', 'orderId' => $post['orderId'], 'paymethod' => $post['paymethod']]);
            }
            if ($model->load($data) && $model->save()) {
                return $this->redirect(['order/pay', 'orderId' => $post['orderId'], 'paymethod' => $post['paymethod']]);
            }
        }catch(\Exception $e) {
            return $this->redirect(['index/index']);
        }
    }

    public function actionPay()
    {
        try{
            if (Yii::$app->session['isLogin'] != 1) {
                throw new \Exception();
            }
            $orderId = Yii::$app->request->get('orderId');
            $paymethod = Yii::$app->request->get('paymethod');
            if (empty($orderId) || empty($paymethod)) {
                throw new \Exception();
            }
            if ($paymethod == 'alipay') {
                return Pay::alipay($orderId);
            }
        }catch(\Exception $e) {}
        return $this->redirect(['order/index']);
    }

    public function actionGetexpress()
    {
        $expressno = Yii::$app->request->get('expressno');
        $res = Express::search($expressno);
        echo $res;
        exit;
    }

    public function actionReceived()
    {
        $orderId = Yii::$app->request->get('orderId');
        $order = Order::find()->where('orderId = :oId', [':oId' => $orderId])->one();
        if (!empty($order) && $order->status == Order::SENDED) {
            $order->status = Order::RECEIVED;
            $order->save();
        }
        return $this->redirect(['order/index']);
    }

}








