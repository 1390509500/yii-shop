<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
    <title>商城 - 后台管理</title>

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
    <link rel="stylesheet" href="admin/css/compiled/signin.css" type="text/css" media="screen" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>

    <div class="span4 box">
        <div class="content-wrap">
            <h6>商城 - 后台管理</h6>
            <?php $form = ActiveForm::begin(['id' => 'login-form',
                'fieldConfig'=>[
                    'template'=>'{error}{input}',
                ]
            ]); ?>
            <?php echo $form->field($model, 'adminuser')->textInput(['class'=>'span12','placeholder'=>'管理员账号']); ?>
            <?php echo $form->field($model, 'adminpass')->passwordInput(['class'=>'span12','placeholder'=>'管理员密码']); ?>
            <a href="<?php echo yii\helpers\Url::to(['admin/seekpass'])?>" class="forgot">忘记密码?</a>
            <?php echo $form->field($model,'rememberMe')->checkbox([
                'id'=>'remember-me',
                'template'=>'<div class="remember">{input}<label for="remember-me">记住我</label></div>'
            ]);?>
            <?php echo Html::submitButton('登录', ["class" => "btn-glow primary login"]);?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- scripts -->
<script src="admin/js/jquery-latest.js"></script>
<script src="admin/js/bootstrap.min.js"></script>
<script src="admin/js/theme.js"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
    $(function () {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function (e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('admin/img/bgs/" + bg + "')");
        });

    });
</script>

</body>
</html>