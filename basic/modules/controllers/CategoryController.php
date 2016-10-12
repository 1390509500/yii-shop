<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/6
 * Time: 11:48
 */
namespace app\modules\controllers;
use app\models\Category;
use yii\web\Controller;
use app\modules\controllers\CommonController;
use Yii;

class CategoryController extends Controller
{

    public $layout = "main";

    public function actionList()
    {
        $model = new Category;
        $cates = $model->getTreeList();
        return $this->render("cates", ['cates' => $cates]);
    }

    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOptions();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash("info", "添加成功");
            }
        }
        return $this->render("add", ['list' => $list, 'model' => $model]);
    }

    public function actionMod()
    {
        $cateId = Yii::$app->request->get("cateId");
        $model = Category::find()->where('cateId = :id', [':id' => $cateId])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }
        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }

    public function actionDel()
    {
        try {
            $cateId = Yii::$app->request->get('cateId');
            if (empty($cateId)) {
                throw new \Exception('参数错误');
            }
            $data = Category::find()->where('parentId = :pid', [":pid" => $cateId])->one();
            if ($data) {
                throw new \Exception('该分类下有子类，不允许删除');
            }
            if (!Category::deleteAll('cateId = :id', ["id" => $cateId])) {
                throw new \Exception('删除失败');
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('info', $e->getMessage());
        }
        return $this->redirect(['category/list']);
    }
}