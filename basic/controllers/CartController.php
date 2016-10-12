<?php
namespace app\controllers;
use app\controllers\CommonController;
use app\models\User;
use app\models\Cart;
use app\models\Product;
use Yii;

class CartController extends CommonController
{
    public function actionIndex()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(Yii::$app->params['front_login']['key'])){
            $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
            if ($loginInfo->value['isLogin'] != 1){
                return $this->redirect(['member/auth']);
            }
        }
        $userId = User::find()->where('username = :name', [':name' => $loginInfo->value['loginname']])->one()->userId;
        $cart = Cart::find()->where('userId = :uid', [':uid' => $userId])->asArray()->all();
        $data = [];
        foreach ($cart as $k=>$pro) {
            $product = Product::find()->where('productId = :pid', [':pid' => $pro['productId']])->one();
            $data[$k]['cover'] = $product->cover;
            $data[$k]['title'] = $product->title;
            $data[$k]['productnum'] = $pro['productnum'];
            $data[$k]['price'] = $pro['price'];
            $data[$k]['productId'] = $pro['productId'];
            $data[$k]['cartId'] = $pro['cartId'];
        }
        $this->layout = 'index';
        return $this->render("index", ['data' => $data]);
    }

    public function actionAdd()
    {
        $cookies = Yii::$app->request->cookies;
        if($cookies->has(Yii::$app->params['front_login']['key'])){
            $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);
            if ($loginInfo->value['isLogin'] != 1){
                return $this->redirect(['member/auth']);
            }
        }else{
            return $this->redirect(['member/auth']);
        }
        $userId = User::find()->where('username = :name', [':name' => $loginInfo->value['loginname']])->one()->userId;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $num = Yii::$app->request->post()['productnum'];
            $data['Cart'] = $post;
            $data['Cart']['userId'] = $userId;
        }
        if (Yii::$app->request->isGet) {
            $productId = Yii::$app->request->get("productId");
            $model = Product::find()->where('productId = :pid', [':pid' => $productId])->one();
            $price = $model->issale ? $model->saleprice : $model->price;
            $num = 1;
            $data['Cart'] = ['productId' => $productId, 'productnum' => $num, 'price' => $price, 'userId' => $userId];
        }
        if (!$model = Cart::find()->where('productId = :pid and userId = :uid', [':pid' => $data['Cart']['productId'], ':uid' => $data['Cart']['userId']])->one()) {
            $model = new Cart;
        } else {
            $data['Cart']['productnum'] = $model->productnum + $num;
        }
        $data['Cart']['createtime'] = time();
        $model->load($data);
        $model->save();
        return $this->redirect(['cart/index']);
    }

    public function actionMod()
    {
        $cartId = Yii::$app->request->get("cartId");
        $productnum = Yii::$app->request->get("productnum");
        Cart::updateAll(['productnum' => $productnum], 'cartId = :cid', [':cid' => $cartId]);
    }

    public function actionDel()
    {
        $cartId = Yii::$app->request->get("cartId");
        Cart::deleteAll('cartId = :cid', [':cid' => $cartId]);
        return $this->redirect(['cart/index']);
    }

}





