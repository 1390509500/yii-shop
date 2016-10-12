<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
<main id="authentication" class="inner-bottom-md">
    <div class="container" style="text-align: center">
        <div class="row">

            <div style="margin: auto;width: 50%">
                <section class="section sign-in inner-right-xs">
                    <h2 class="bordered">完善信息</h2>
                    <img src="<?php echo Yii::$app->cache->get(md5('MemberController_qqLogin'))['figureurl_1']?>">
                    <?php echo Yii::$app->cache->get(md5('MemberController_qqLogin'))['nickname']?><p>欢迎您回来,请完善您的账户信息</p>
                    <?php $form = ActiveForm::begin(['id' => 'changepass-form',
                        'options'=>['class'=>'register-form cf-style-1','role'=>'form'],
                        'fieldConfig'=>[
                            'template'=>'<div class="field-row">{error}{label}{input}</div>',
                        ],
                        'action' => ['member/qqreg'],
                    ]); ?>
                    <?php echo $form->field($model, 'username')->textInput(['class'=>'le-input']); ?>
                    <?php echo $form->field($model, 'useremail')->textInput(['class'=>'le-input']); ?>
                    <?php echo $form->field($model, 'userpass')->passwordInput(['class'=>'le-input']); ?>
                    <?php echo $form->field($model, 'repass')->passwordInput(['class'=>'le-input']); ?>
                    <div class="buttons-holder">
                        <?php echo Html::submitButton('完善信息', ["class" => "le-button huge"]);?>
                    </div><!-- /.buttons-holder -->
                    <?php ActiveForm::end(); ?>

                </section><!-- /.sign-in -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->
<footer id="footer" class="color-bg">

    <div class="container">
        <div class="row no-margin widgets-row">
            <div class="col-xs-12  col-sm-4 no-margin-left">
                <!-- ============================================================= FEATURED PRODUCTS ============================================================= -->
                <div class="widget">
                    <h2>推荐商品</h2>
                    <div class="body">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">Netbook Acer Travel B113-E-10072</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-01.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">PowerShot Elph 115 16MP Digital Camera</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-02.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">PowerShot Elph 115 16MP Digital Camera</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-03.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- /.body -->
                </div> <!-- /.widget -->
                <!-- ============================================================= FEATURED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-4 ">
                <!-- ============================================================= ON SALE PRODUCTS ============================================================= -->
                <div class="widget">
                    <h2>促销商品</h2>
                    <div class="body">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">HP Scanner 2910P</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-04.jpg" />
                                        </a>
                                    </div>
                                </div>

                            </li>
                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">Galaxy Tab 3 GT-P5210 16GB, Wi-Fi, 10.1in - White</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-05.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">PowerShot Elph 115 16MP Digital Camera</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-06.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div><!-- /.body -->
                </div> <!-- /.widget -->
                <!-- ============================================================= ON SALE PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-4 ">
                <!-- ============================================================= TOP RATED PRODUCTS ============================================================= -->
                <div class="widget">
                    <h2>最热商品</h2>
                    <div class="body">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">Galaxy Tab GT-P5210, 10" 16GB Wi-Fi</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-07.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">PowerShot Elph 115 16MP Digital Camera</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-08.jpg" />
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9 no-margin">
                                        <a href="single-product.html">Surface RT 64GB, Wi-Fi, 10.6in - Dark Titanium</a>
                                        <div class="price">
                                            <div class="price-prev">￥2000</div>
                                            <div class="price-current">￥1873</div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3 no-margin">
                                        <a href="#" class="thumb-holder">
                                            <img alt="" src="front/images/blank.gif" data-echo="front/images/products/product-small-09.jpg" />
                                        </a>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div><!-- /.body -->
                </div><!-- /.widget -->
                <!-- ============================================================= TOP RATED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

        </div><!-- /.widgets-row-->
    </div><!-- /.container -->
    <script>
        var qqbtn = document.getElementById("login_qq");
        qqbtn.onclick = function(){
            window.location.href="<?php echo yii\helpers\Url::to(['member/qqlogin']) ?>";
        }
    </script>