<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
    <title>商城 - 修改密码</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="admin/css/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="admin/css/lib/font-awesome.css" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="admin/css/compiled/signup.css" type="text/css" media="screen" />

    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<div class="header">
    <a href="<?php echo yii\helpers\Url::to(['admin/login'])?>">
        <img src="admin/img/logo.png" class="logo" />
    </a>
</div>
<div class="row-fluid login-wrapper">
    <div class="box">
        <div class="content-wrap">
            <h6>修改密码</h6>
            <?php $form = ActiveForm::begin(['id' => 'changepass-form',
                'fieldConfig'=>[
                    'template'=>'{error}{input}',
                ]
            ]); ?>
            <?php if(Yii::$app->session->hasFlash('info'))
                echo Yii::$app->session->getFlash('info');
            ?>
            <?php echo $form->field($model, 'adminuser')->textInput(['class'=>'span12','placeholder'=>'管理员账号']); ?>
            <?php echo $form->field($model, 'adminpass')->textInput(['class'=>'span12','placeholder'=>'管理员密码']); ?>
            <?php echo $form->field($model, 'repass')->textInput(['class'=>'span12','placeholder'=>'重复输入管理员密码']); ?>
            <?php echo Html::submitButton('确定', ["class" => "btn-glow primary login"]);?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- scripts -->
<script src="admin/js/jquery-latest.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/theme.js"></script>

</body>
</html>