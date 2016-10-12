<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\OrderDetail;
use app\models\Product;
use app\models\Category;

class Order extends ActiveRecord
{
    const CREATEORDER = 0;
    const CHECKORDER = 100;
    const PAYFAILED = 201;
    const PAYSUCCESS = 202;
    const SENDED = 220;
    const RECEIVED = 260;
 
    public static $status = [
        self::CREATEORDER => '订单初始化',
        self::CHECKORDER  => '待支付',
        self::PAYFAILED   => '支付失败',
        self::PAYSUCCESS  => '等待发货',
        self::SENDED      => '已发货',
        self::RECEIVED    => '订单完成',
    ];

    public $products;
    public $zhstatus;
    public $username;
    public $address;

    public function rules()
    {
        return [
            [['userId', 'status'], 'required', 'on' => ['add']],
            [['addressId', 'expressId', 'amount', 'status'], 'required', 'on' => ['update']],
            ['expressno', 'required', 'message' => '请输入快递单号', 'on' => 'send'],
            ['createtime', 'safe', 'on' => ['add']],
        ];
    }

    public static function tableName()
    {
        return "{{%order}}";
    }

    public function attributeLabels()
    {
        return [
            'expressno' => '快递单号',
        ];
    }

    public function getDetail($orders)
    {
        foreach($orders as $order){
            $order = self::getData($order);
        }
        return $orders;
    }

    public static function getData($order)
    {
        $details = OrderDetail::find()->where('orderId = :oId', [':oId' => $order->orderId])->all();
        $products = [];
        foreach($details as $detail) {
            $product = Product::find()->where('productId = :pId', [':pId' => $detail->productId])->one();
            if (empty($product)) {
                continue;
            }
            $product->num = $detail->productnum;
            $products[] = $product;
        }
        $order->products = $products;
        $user = User::find()->where('userId = :uId', [':uId' => $order->userId])->one();
        if (!empty($user)) {
            $order->username = $user->username;
        }
        $order->address = Address::find()->where('addressId = :aId', [':aId' => $order->addressId])->one();
        if (empty($order->address)) {
            $order->address = "";
        } else {
            $order->address = $order->address->address;
        }
        $order->zhstatus = self::$status[$order->status];
        return $order;
    }

    public static function getProducts($userId)
    {
        $orders = self::find()->where('status > 0 and userId = :uId', [':uId' => $userId])->orderBy('createtime desc')->all();
        foreach($orders as $order) {
            $details = OrderDetail::find()->where('orderId = :oId', [':oId' => $order->orderId])->all();
            $products = [];
            foreach($details as $detail) {
                $product = Product::find()->where('productId = :pId', [':pId' => $detail->productId])->one();
                if (empty($product)) {
                    continue;
                }
                $product->num = $detail->productnum;
                $product->price = $detail->price;
                $product->cate = Category::find()->where('cateId = :cId', [':cId' => $product->cateId])->one()->title;
                $products[] = $product;
            }
            $order->zhstatus = self::$status[$order->status];
            $order->products = $products;
        }
        return $orders;
    }


}
