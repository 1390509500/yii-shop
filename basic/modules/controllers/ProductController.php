<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/6
 * Time: 13:04
 */
namespace app\modules\controllers;
use app\models\Category;
use app\models\Product;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\data\Pagination;
use app\modules\controllers\CommonController;
use Upload\upload;

class ProductController extends Controller
{
    public $enableCsrfValidation = false;//防400错误

    public function actionTest(){
        $this->layout=false;
        return $this->render("test");
    }

    public function actionUploadtest(){
        if(isset($_FILES['file'])) {

            $handle = new upload($_FILES['file']);
            if($handle->uploaded) {

                $handle->file_new_name_body   = 'test_'.time();                         // nome arquivo
                $handle->file_safe_name       = true;                                   // formata nome
                $handle->file_overwrite       = true;                                   // sobreescreve
                $handle->allowed              = array('image/*');                       // arquivos permitidos
                $handle->image_convert        = 'jpg';                                  // converte para jpg
                $handle->jpeg_quality         = 72;                                     // qualidade
                $handle->image_resize         = true;                                   // redimensionar
                $handle->image_x              = 100;                                    // largura
                $handle->image_y              = 100;                                    // altura
                $handle->image_ratio_crop     = true;                                   // centralizar e recortar
                $date = date("Y-m-d",time());
                $file = '/upload/'.$date;
                if(!is_dir($file)){
                    mkdir($file, 0777);
                }
                $handle->process($file);

                echo '<pre>';
                if ($handle->processed) {
                    $handle->clean();
                    print_r('Imagem enviada com sucesso<br>');
                    print_r('<img src="http://images.shop.cn/'.$date.'/'.$handle->file_dst_name.'">');
                    echo '<hr>';
                } else {
                    print_r($handle->error);
                    echo '<hr>';
                }
                print_r($handle);
                echo '</pre>';
            } else {
                echo '<pre>';
                print_r('Imagem nao enviada<br>');
                print_r($handle->error);
                echo '<hr>';
                print_r($_FILES['file']);
                echo '<hr>';
                print_r($handle);
                echo '</pre>';
            }
        }
    }
    public function actionList()
    {
        $model = Product::find();
        $count = $model->count();
        $pageSize = Yii::$app->params['manage']['pageSize'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();
        $this->layout = "main";
        return $this->render("products", ['pager' => $pager, 'products' => $products]);
    }

    public function actionAdd()
    {
        $this->layout = "main";
        $model = new Product;
        $model->issale=0;$model->ishot=0;$model->ison=0;$model->istui=0;
        $cate = new Category;
        $list = $cate->getOptions();
        unset($list[0]);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $imgs = json_decode($post['pics'],true);
            unset($imgs[0]);
            if(empty($imgs)){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'error' => '图片不能为空',
                    'code' => '404'
                ];
            }
            $pics = [];
            foreach ($imgs as $k=>$img){
                $pics[$k]['pic_min'] = $img;
                $pics[$k]['pic_mid'] = str_replace('pic_min','pic_mid',$img);
                $pics[$k]['pic_big'] = str_replace('pic_min','pic_big',$img);
            }
            $pics = json_encode($pics);
            $post['Product']['pics'] = $pics;
            $post['Product']['cover'] = $post['cover'];
            $post['Product']['createtime'] = time();
            unset($post['cover']);
            unset($post['pics']);
            $res = $model->add($post);
            if($res){
                foreach ($res as $k=>$item){
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return [
                        'error' => $item,
                        'code' => '404'
                    ];
                }
            }else{
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'msg' => 'success',
                ];
            }
        }
        return $this->render("add", ['opts' => $list, 'model' => $model]);
    }

    public function actionUpload(){
        $fileInfo = $_FILES['file'];
        $imagex = Yii::$app->params['cover']['width'];$imagey = Yii::$app->params['cover']['height'];$prefix='cover';
        if(Yii::$app->request->isAjax){
            $res = $this->upload($imagex,$imagey,$prefix,$fileInfo);
            if($res){
                echo json_encode(array('status' => 'Ok','img'=>$res['url'],'name'=>$res['name']));
            }else{
                echo json_encode(array('status' => 'Fail','error'=>'图片上传失败'));
            }
        }
    }

    public function actionUploadimages(){
        $fileInfo = $_FILES['files'];
        $imagex1 = Yii::$app->params['pic_big']['width'];$imagey1 = Yii::$app->params['pic_big']['height'];$prefix1='pic_big';
        $imagex2 = Yii::$app->params['pic_mid']['width'];$imagey2 = Yii::$app->params['pic_mid']['height'];$prefix2='pic_mid';
        $imagex3 = Yii::$app->params['pic_min']['width'];$imagey3 = Yii::$app->params['pic_min']['height'];$prefix3='pic_min';
        if(Yii::$app->request->isAjax){
            $img1 = $this->upload($imagex1,$imagey1,$prefix1,$fileInfo,false);
            $img2 = $this->upload($imagex2,$imagey2,$prefix2,$fileInfo,false);
            $img3 = $this->upload($imagex3,$imagey3,$prefix3,$fileInfo);
            if($img1 && $img2 && $img3){
                echo json_encode(array('status' => 'Ok','img'=>$img3['url'],'name'=>$img3['name'],'title'=>json_encode([
                    'pic_big'=>$img1['title'],
                    'pic_mid'=>$img2['title'],
                    'pic_min'=>$img3['title'],
                ])));
            }else{
                echo json_encode(array('status' => 'Fail','error'=>'图片上传失败'));
            }
        }
    }
    public function actionMod()
    {
        $this->layout = "main";
        $cate = new Category;
        $list = $cate->getOptions();
        unset($list[0]);

        $productId = Yii::$app->request->get("productId");
        $model = Product::find()->where('productId = :id', [':id' => $productId])->one();
        $covername = substr($model->cover,33);
        $pics = json_decode($model->pics);
        $img = array();
        foreach ($pics as $pic){
            $img[] = $pic->pic_min;
        }
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $imgs = json_decode($post['pics'],true);
            unset($imgs[0]);
            if(empty($imgs)){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'error' => '图片不能为空',
                    'code' => '404'
                ];
            }
            $pics = [];
            foreach ($imgs as $k=>$img){
                $pics[$k]['pic_min'] = $img;
                $pics[$k]['pic_mid'] = str_replace('pic_min','pic_mid',$img);
                $pics[$k]['pic_big'] = str_replace('pic_min','pic_big',$img);
            }
            $pics = json_encode($pics);
            $post['Product']['pics'] = $pics;
            $post['Product']['cover'] = $post['cover'];
            $post['Product']['createtime'] = time();
            unset($post['cover']);
            unset($post['pics']);
            if ($model->load($post) && $model->save()) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'msg'=>'success'
                ];
            }

        }
        return $this->render('mod', ['model' => $model, 'imgs'=>$img, 'opts' => $list,'covername'=>$covername]);
    }


    public function actionDel()
    {
        $productId = Yii::$app->request->get("productId");
        Product::deleteAll('productId = :pid', [':pid' => $productId]);
        return $this->redirect(['product/list']);
    }

    public function actionDelpics(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $file = "/upload/".substr($post['pic'],22);
            unlink($file);
            if(!is_file($file)){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'msg'=>'success'
                ];
            }
        }
    }

    public function actionOn()
    {
        $productId = Yii::$app->request->get("productId");
        Product::updateAll(['ison' => '0'], 'productId = :pid', [':pid' => $productId]);
        return $this->redirect(['product/list']);
    }

    public function actionOff()
    {
        $productId = Yii::$app->request->get("productId");
        Product::updateAll(['ison' => '1'], 'productId = :pid', [':pid' => $productId]);
        return $this->redirect(['product/list']);
    }

    /**
     * @param $image_x
     * @param $image_y
     * @return bool|string
     * 图片上传
     */
    private function upload($image_x,$image_y,$prefix,$fileInfo,$clean=true){
        $handle = new upload($fileInfo);
        if($handle->uploaded) {

            $handle->file_new_name_body   = $prefix.time();                         // nome arquivo
            $handle->file_safe_name       = true;                                   // formata nome
            $handle->file_overwrite       = true;                                   // sobreescreve
            $handle->allowed              = array('image/*');                       // arquivos permitidos
            $handle->image_convert        = 'jpg';                                  // converte para jpg
            $handle->jpeg_quality         = 72;                                     // qualidade
            $handle->image_resize         = true;                                   // redimensionar
            $handle->image_x              = $image_x;                                    // largura
            $handle->image_y              = $image_y;                                    // altura
            $handle->image_ratio_crop     = true;                                   // centralizar e recortar
            $date = date("Y-m-d",time());
            $file = '/upload/'.$date;
            if(!is_dir($file)){
                mkdir($file, 0777);
            }
            $handle->process($file);

            if ($handle->processed) {
                if($clean){
                    $handle->clean();
                }
                $imageurl = '<img class= "img_pad" src="http://images.shop.cn/'.$date.'/'.$handle->file_dst_name.'">';
                $title = "http://images.shop.cn/".$date.'/'.$handle->file_dst_name;
                $name = $handle->file_dst_name;
                return array('name'=>$name,'url'=>$imageurl,'title'=>$title);
            } else {
               return false;
            }
        } else {
            return false;
        }
        return false;
    }







}