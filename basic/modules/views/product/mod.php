<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<style>
    .span8 div{
        display:inline;
    }
    .help-block-error {
        color:red;
        display:inline;
    }
    .img_pad{
        margin-right: 20px;
        margin-bottom: 20px;
    }
</style>
<link rel="stylesheet" href="admin/css/new-user.css" type="text/css" media="screen" />
<link rel="stylesheet" href="admin/css/uploader.css" rel="stylesheet" />
<script src="admin/js/jquery-1.10.2.min.js"></script>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加商品</h3>
            </div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php
                        if (Yii::$app->session->hasFlash('info')) {
                            echo Yii::$app->session->getFlash('info');
                        }
                        $form = ActiveForm::begin([
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}</div>',
                            ],
                            'options' => [
                                'class' => 'new_user_form inline-input',
                                'enctype' => 'multipart/form-data'
                            ],
                        ]);
                        echo $form->field($model, 'cateId')->dropDownList($opts, ['id' => 'cates']);
                        echo $form->field($model, 'title')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'descr')->textarea(['id' => "wysi", 'class' => "span9 wysihtml5", 'style' => 'margin-left:120px']);
                        echo $form->field($model, 'price')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'ishot')->radioList([0 => '不热卖', 1 => '热卖'], ['class' => 'span8']);
                        echo $form->field($model, 'issale')->radioList(['不促销', '促销'], ['class' => 'span8']);
                        echo $form->field($model, 'saleprice')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'num')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'ison')->radioList(['上架', '下架'], ['class' => 'span8']);
                        echo $form->field($model, 'istui')->radioList(['不推荐', '推荐'], ['class' => 'span8']);
                        //echo $form->field($model, 'cover')->fileInput(['class' => 'span9']);
                        ?>
                        <div class="row demo-columns">
                            <div class="col-md-6">
                                <!-- D&D Zone-->
                                <div id="drag-and-drop-zone" class="uploader">
                                    <div>Drag &amp; Drop Images Here</div>
                                    <div class="or">-or-</div>
                                    <div class="browser">
                                        <label>
                                            <span>Click to open the file Browser</span>
                                            <input type="file" name="file" multiple="multiple" title='Click to add Files' id="drop_image">
                                        </label>
                                    </div>
                                </div>
                                <!-- /D&D Zone -->
                            </div>
                            <!-- / Left column -->

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" id="img_title">
                                            <?php if(!empty($covername)):?>
                                                <?php echo $covername;?>
                                            <?php else:?>
                                                封面图片上传，最后传入的一张为录入结果
                                            <?php endif;?>
                                        </h3>
                                    </div>
                                    <div class="panel-body demo-panel-files" id='demo-file'>
                                                    <span class="thumb_upload">
                                                        <?php if(!empty($model->cover)):?>
                                                            <img class= "img_pad" src="<?php echo $model->cover;?>">
                                                        <?php else:?>
                                                            No Files have been selected/droped yet...
                                                        <?php endif;?>
                                                    </span>
                                    </div>
                                </div>
                            </div>
                            <!-- / Right column -->
                        </div>
                        <div class="row demo-columns">
                            <div class="col-md-6">
                                <!-- D&D Zone-->
                                <div id="drag-and-drop-zone_all" class="uploader">
                                    <div>Drag &amp; Drop Images Here</div>
                                    <div class="or">-or-</div>
                                    <div class="browser">
                                        <label>
                                            <span>Click to open the file Browser</span>
                                            <input type="file" id="drop_images"name="files" multiple="multiple" title='Click to add Files'>
                                        </label>
                                    </div>
                                </div>
                                <!-- /D&D Zone -->
                            </div>
                            <!-- / Left column -->

                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" id="panel-title">商品图片上传，可传入多张</h3>
                                    </div>
                                    <div class="panel-body demo-panel-files" id='demo-files'>
                                            <span class="demo-note">
                                                <?php if(!empty($model->pics)):?>
                                                    <?php foreach ($imgs as $img):?>
                                                        <a style="cursor:pointer" class="delimg" title="<?php echo $img?>"><img class= "img_pad" src="<?php echo $img?>">删除</a>
                                                    <?php endforeach;?>
                                                <?php endif;?>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- / Right column -->
                        </div>
                        <div class="span11 field-box actions">
                            <input type="button" class="btn-glow primary" value="提交">
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>
                        请在左侧表单当中填入要添加的商品信息,包括商品名称,描述,图片等
                    </div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行购物</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->
<script type="text/javascript">
    $(function () {
        $(document).on("click","#drag-and-drop-zone",function () {
            $("#drop_image").unbind().change(function () {
                $.ajax({
                    url:"<?php echo yii\helpers\Url::to(['product/upload']) ?>",
                    data:new FormData($('form')[0]),
                    method:'post',
                    dataType:'json',
                    processData: false,
                    contentType: false
                }).done(function(res){
                    if(res.status=='Ok'){
                        $("#img_title").html(res.name);
                        $(".thumb_upload").html(res.img);
                    }else{
                        $(".thumb_upload").html(res.error);
                    }
                }).fail(function(res){
                    console.dir(res);
                });
            })
        })
        $(".primary").click(function () {
            var data = $("form").serialize();
            var url = $(".thumb_upload img").attr("src");
            if(url==null){
                alert("图片不能为空");
                return;
            }
            var img = $(".img_pad");
            var pics = []
            img.each(function(index,ele){
                pics[index] = ele.src;
            })
            pics = JSON.stringify(pics)
            $.ajax({
                url:$("form").attr('action'),
                data:data+"&cover="+url+"&pics="+pics,
                method:'post',
                dataType:'json',
            }).done(function(res){
                if(res.code=='404'){
                    alert(res.error);
                }else {
                    window.location.href="<?php echo yii\helpers\Url::to(['product/list']);?>";
                }
            }).fail(function(res){
                console.dir(res);
            });
        });
        $(".delimg").each(function (index,ele) {
            $(ele).click(function () {
                $.ajax({
                    url:"<?php echo yii\helpers\Url::to(['product/delpics']) ?>",
                    data:"pic="+$(this).attr('title'),
                    method:'post',
                    dataType:'json',
                }).done(function(res){
                    if(res.code=='404'){
                        alert(res.error);
                    }else {
                        $(ele).remove();
                        alert('删除成功');
                    }
                }).fail(function(res){
                    console.dir(res);
                });
            })
        });
        $('#drag-and-drop-zone_all').click(function () {
            $("#drop_images").unbind().change(function () {
                $.ajax({
                    url:"<?php echo yii\helpers\Url::to(['product/uploadimages']) ?>",
                    data:new FormData($('form')[0]),
                    method:'post',
                    dataType:'json',
                    processData: false,
                    contentType: false
                }).done(function(res){
                    if(res.status=='Ok'){
                        $(".demo-note").append(res.img);
                    }else{
                        $(".demo-note").append(res.error);
                    }
                }).fail(function(res){
                    console.dir(res);
                });
            })
        });
        $(".return").click(function () {
            window.location.href="<?php echo yii\helpers\Url::to(['product/list']);?>";
        })
    });
</script>