<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/9
 * Time: 13:43
 */
namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\models\Product;
use yii\data\Pagination;

class ProductController extends CommonController
{

    public $layout = "index";
    public function actionIndex()
    {
        $cid = Yii::$app->request->get("cateId");
        $where = "cateId = :cid and ison = '0'";
        $params = [':cid' => $cid];
        $model = Product::find()->where($where, $params);

        $count = $model->count();
        $pageSize = Yii::$app->params['manage']['pageSize'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();
        $tui = $model->where($where . ' and istui = \'1\'', $params)->orderby('createtime desc')->limit(5)->asArray()->all();
        $hot = $model->where($where . ' and ishot = \'1\'', $params)->orderby('createtime desc')->limit(5)->asArray()->all();
        $sale = $model->where($where . ' and issale = \'1\'', $params)->orderby('createtime desc')->limit(5)->asArray()->all();

        return $this->render("index", ['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $all, 'pager' => $pager, 'count' => $count]);
    }

    public function actionDetail()
    {
        $productId = Yii::$app->request->get("productId");
        $product = Product::find()->where('productId = :id', [':id' => $productId])->asArray()->one();
        $data['all'] = Product::find()->where('ison = "0"')->orderby('createtime desc')->limit(7)->all();
        return $this->render("detail", ['product' => $product, 'data' => $data]);
    }
}