<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/5
 * Time: 13:31
 */
namespace app\controllers;

use app\controllers\CommonController;
use app\models\Product;

class IndexController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = "index";
        $data['tui'] = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(4)->all();
        $data['new'] = Product::find()->where('ison = "0"')->orderby('createtime desc')->limit(4)->all();
        $data['hot'] = Product::find()->where('ison = "0" and ishot = "1"')->orderby('createtime desc')->limit(4)->all();
        $data['all'] = Product::find()->where('ison = "0"')->orderby('createtime desc')->limit(7)->all();
        return $this->render("index", ['data' => $data]);
    }
}