<?php
/**
 * Created by PhpStorm.
 * User: psl
 * Date: 2016/10/2
 * Time: 16:17
 */

namespace app\modules\controllers;

use yii\web\Controller;

class AdminController extends Controller
{

    public $layout = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionSignup(){
        return $this->render('signup');
    }
}