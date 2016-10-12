<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/2
 * Time: 16:17
 */

namespace app\modules\controllers;

use app\models\Profile;
use app\models\User;
use Yii;
use yii\data\Pagination;
use app\models\admin\AdminModel;
use yii\web\Controller;

class UserController extends Controller
{
    public $layout = "main";
    public function actionList()
    {
        $model = User::find()->with('profile');
        $count = $model->count();
        $pageSize = Yii::$app->params['manage']['pageSize'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("list",['users' => $users, 'pager' => $pager]);
    }
}