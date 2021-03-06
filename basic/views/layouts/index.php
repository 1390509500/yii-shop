<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="all">

    <title>商品分类 - 商城</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="front/css/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="front/css/main.css">
    <link rel="stylesheet" href="front/css/red.css">
    <link rel="stylesheet" href="front/css/owl.carousel.css">
    <link rel="stylesheet" href="front/css/owl.transitions.css">
    <link rel="stylesheet" href="front/css/animate.min.css">


    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="front/css/font-awesome.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="front/images/favicon.ico">

    <!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
    <!--[if lt IE 9]>
    <script src="front/js/html5shiv.js"></script>
    <script src="front/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="wrapper">
    <!-- ============================================================= TOP NAVIGATION ============================================================= -->
    <nav class="top-bar animate-dropdown">
        <div class="container">
            <div class="col-xs-12 col-sm-6 no-margin">
                <ul>
                    <li><a href="index.html">首页</a></li>
                    <li><a href="category-grid.html">所有分类</a></li>
                    <li><a href="cart.html">我的购物车</a></li>
                    <li><a href="orders.html">我的订单</a></li>
                </ul>
            </div><!-- /.col -->

            <div class="col-xs-12 col-sm-6 no-margin">
                <ul class="right">
                    <?php $cookies = Yii::$app->request->cookies;?>
                    <?php if($cookies->has(Yii::$app->params['front_login']['key'])):?>
                    <?php $loginInfo = $cookies->get(Yii::$app->params['front_login']['key']);?>
                        <?php if ($loginInfo->value['isLogin'] == 1): ?>
                            您好:欢迎您回来 <?php echo $loginInfo->value['loginname'] ?> , <a href="<?php echo yii\helpers\Url::to(['member/logout']); ?>">退出</a>
                        <?php endif; ?>
                    <?php else:?>
                        <li><a href="<?php echo yii\helpers\Url::to(['member/auth']); ?>">注册</a></li>
                        <li><a href="<?php echo yii\helpers\Url::to(['member/auth']); ?>">登录</a></li>
                    <?php endif;?>
                </ul>
            </div><!-- /.col -->
        </div><!-- /.container -->
    </nav><!-- /.top-bar -->
    <!-- ============================================================= TOP NAVIGATION : END ============================================================= -->		<!-- ============================================================= HEADER ============================================================= -->
    <header>
        <div class="container no-padding">

            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                <!-- ============================================================= LOGO ============================================================= -->
                <div class="logo">
                    <a href="index.html">
                        <img alt="logo" src="front/images/logo.png" width="233" height="54"/>
                    </a>
                </div><!-- /.logo -->
                <!-- ============================================================= LOGO : END ============================================================= -->		</div><!-- /.logo-holder -->

            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
                <div class="contact-row">
                    <div class="phone inline">
                        <i class="fa fa-phone"></i> (+086) 15045687756
                    </div>
                    <div class="contact inline">
                        <i class="fa fa-envelope"></i> contact1390509500@<span class="le-color">qq.com</span>
                    </div>
                </div><!-- /.contact-row -->
                <!-- ============================================================= SEARCH AREA ============================================================= -->
                <div class="search-area">
                    <form>
                        <div class="control-group">
                            <input class="search-field" placeholder="搜索商品" />

                            <ul class="categories-filter animate-dropdown">
                                <li class="dropdown">

                                    <a class="dropdown-toggle"  data-toggle="dropdown" href="category-grid.html">所有分类</a>

                                    <ul class="dropdown-menu" role="menu" >
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="category-grid.html">电子产品</a></li>

                                    </ul>
                                </li>
                            </ul>

                            <a style="padding:15px 15px 13px 12px" class="search-button" href="#" ></a>

                        </div>
                    </form>
                </div><!-- /.search-area -->
                <!-- ============================================================= SEARCH AREA : END ============================================================= -->		</div><!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
                <div class="top-cart-row-container">

                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                    <div class="top-cart-holder dropdown animate-dropdown">

                        <div class="basket">

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <div class="basket-item-count">
                                    <span class="count">3</span>
                                    <img src="front/images/icon-cart.png" alt="" />
                                </div>

                                <div class="total-price-basket">
                                    <span class="lbl">您的购物车:</span>
                                    <span class="total-price">
                        <span class="sign">￥</span><span class="value">3219</span>
                    </span>
                                </div>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt="" src="front/images/products/product-small-01.jpg" />
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">前端课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>

                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt="" src="front/images/products/product-small-01.jpg" />
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">Java课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>

                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt="" src="front/images/products/product-small-01.jpg" />
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">PHP课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>


                                <li class="checkout">
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <a href="cart.html" class="le-button inverse">查看购物车</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <a href="checkout.html" class="le-button">去往收银台</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div><!-- /.basket -->
                    </div><!-- /.top-cart-holder -->
                </div><!-- /.top-cart-row-container -->
                <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->		</div><!-- /.top-cart-row -->
        </div><!-- /.container -->
        <!-- ========================================= NAVIGATION ========================================= -->
        <nav id="top-megamenu-nav" class="megamenu-vertical animate-dropdown">
            <div class="container">
                <div class="yamm navbar">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mc-horizontal-menu-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div><!-- /.navbar-header -->
                        <div class="collapse navbar-collapse" id="mc-horizontal-menu-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            foreach((array)$this->params['menu'] as $k=>$menu):
                            ?>
                                <?php if($k<7):?>
                            <li class="dropdown">
                                <a href="<?php echo yii\helpers\Url::to(['product/index', 'cateId' => $menu['cateId']]) ?>" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><?php echo $menu['title'] ?></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="yamm-content">
                                            <div class="row">
                                                <?php foreach((array)$menu['children'] as $child): ?>
                                                <div class="col-xs-12 col-sm-4">
                                                    <h2>
                                                        <?php echo $child['title'] ?>
                                                        <ul>
                                                        <?php foreach((array)$child['children'] as $val): ?>
                                                            <li><a href="<?php echo yii\helpers\Url::to(['product/index', 'cateId' => $val['cateId']]) ?>"><?php echo $val['title'];?></a></li>
                                                        <?php endforeach;?>
                                                        </ul>
                                                    </h2>
                                                </div><!-- /.col -->
                                                <?php endforeach;?>
                                            </div><!-- /.row -->
                                        </div><!-- /.yamm-content -->
                                    </li>
                                </ul>
                            </li>
                            <?php endif;?>
                            <?php endforeach;?>
                        </ul><!-- /.navbar-nav -->
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.navbar-collapse -->
            </div><!-- /.navbar -->
        </nav><!-- /.megamenu-vertical -->
        <!-- ========================================= NAVIGATION : END ========================================= -->
    </header>
<?php echo $content;?>
    <footer id="footer" class="color-bg">

        <div class="container">
            <div class="row no-margin widgets-row">
                <div class="col-xs-12  col-sm-4 no-margin-left">
                    <!-- ============================================================= FEATURED PRODUCTS ============================================================= -->
                    <div class="widget">
                        <h2>推荐商品</h2>
                        <div class="body">
                            <ul>
                                <?php foreach($this->params['tui'] as $pro): ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-9 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]); ?>"><?php echo $pro->title ?></a>
                                                <div class="price">
                                                    <div class="price-prev">￥<?php echo $pro->price ?></div>
                                                    <div class="price-current">￥<?php echo $pro->saleprice ?></div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-3 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>" class="thumb-holder">
                                                    <img alt="<?php echo $pro->title ?>" src="<?php echo $pro->cover ?>" data-echo="<?php echo $pro->cover ?>" />
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.body -->
                    </div> <!-- /.widget -->
                    <!-- ============================================================= FEATURED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

                <div class="col-xs-12 col-sm-4 ">
                    <!-- ============================================================= ON SALE PRODUCTS ============================================================= -->
                    <div class="widget">
                        <h2>热卖商品</h2>
                        <div class="body">
                            <ul>
                                <?php foreach($this->params['hot'] as $pro): ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-9 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]); ?>"><?php echo $pro->title ?></a>
                                                <div class="price">
                                                    <div class="price-prev">￥<?php echo $pro->price ?></div>
                                                    <div class="price-current">￥<?php echo $pro->saleprice ?></div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-3 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>" class="thumb-holder">
                                                    <img alt="<?php echo $pro->title ?>" src="<?php echo $pro->cover ?>" data-echo="<?php echo $pro->cover ?>" />
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.body -->
                    </div> <!-- /.widget -->
                    <!-- ============================================================= ON SALE PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

                <div class="col-xs-12 col-sm-4 ">
                    <!-- ============================================================= TOP RATED PRODUCTS ============================================================= -->
                    <div class="widget">
                        <h2>最新商品</h2>
                        <div class="body">
                            <ul>
                                <?php foreach($this->params['new'] as $pro): ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-9 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]); ?>"><?php echo $pro->title ?></a>
                                                <div class="price">
                                                    <div class="price-prev">￥<?php echo $pro->price ?></div>
                                                    <div class="price-current">￥<?php echo $pro->saleprice ?></div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-3 no-margin">
                                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>" class="thumb-holder">
                                                    <img alt="<?php echo $pro->title ?>" src="<?php echo $pro->cover ?>" data-echo="<?php echo $pro->cover ?>" />
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.body -->
                    </div><!-- /.widget -->
                    <!-- ============================================================= TOP RATED PRODUCTS : END ============================================================= -->            </div><!-- /.col -->

            </div><!-- /.widgets-row-->
        </div><!-- /.container -->

        <div class="sub-form-row">
            <!--<div class="container">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                    <form role="form">
                        <input placeholder="Subscribe to our newsletter">
                        <button class="le-button">Subscribe</button>
                    </form>
                </div>
            </div>--><!-- /.container -->
        </div><!-- /.sub-form-row -->

        <div class="link-list-row">
            <div class="container no-padding">
                <div class="col-xs-12 col-md-4 ">
                    <!-- ============================================================= CONTACT INFO ============================================================= -->
                    <div class="contact-info">
                        <div class="footer-logo">
                            <img alt="logo" src="front/images/logo.png" width="233" height="54"/>
                        </div><!-- /.footer-logo -->

                        <p class="regular-bold"> 请通过电话，电子邮件随时联系我们</p>

                        <p>
                            西城区二环到三环德胜门外大街10号TCL大厦3层(马甸桥南), 北京市西城区, 中国
                            <br>慕课网 (QQ群:416465236)
                        </p>

                        <!--<div class="social-icons">
                            <h3>Get in touch</h3>
                            <ul>
                                <li><a href="http://facebook.com/transvelo" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <li><a href="#" class="fa fa-pinterest"></a></li>
                                <li><a href="#" class="fa fa-linkedin"></a></li>
                                <li><a href="#" class="fa fa-stumbleupon"></a></li>
                                <li><a href="#" class="fa fa-dribbble"></a></li>
                                <li><a href="#" class="fa fa-vk"></a></li>
                            </ul>
                        </div>--><!-- /.social-icons -->

                    </div>
                    <!-- ============================================================= CONTACT INFO : END ============================================================= -->            </div>

                <div class="col-xs-12 col-md-8 no-margin">
                    <!-- ============================================================= LINKS FOOTER ============================================================= -->
                    <div class="link-widget">
                        <div class="widget">
                            <h3>最新商品</h3>
                            <ul>
                                <?php foreach($this->params['new'] as $pro): ?>
                                    <li><a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>"><?php echo $pro->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.link-widget -->

                    <div class="link-widget">
                        <div class="widget">
                            <h3>热门商品</h3>
                            <ul>
                                <?php foreach($this->params['hot'] as $pro): ?>
                                    <li><a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>"><?php echo $pro->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.link-widget -->

                    <div class="link-widget">
                        <div class="widget">
                            <h3>促销商品</h3>
                            <ul>
                                <?php foreach($this->params['sale'] as $pro): ?>
                                    <li><a href="<?php echo yii\helpers\Url::to(['product/detail', 'productId' => $pro->productId]) ?>"><?php echo $pro->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- /.widget -->
                    </div><!-- /.link-widget -->
                    <!-- ============================================================= LINKS FOOTER : END ============================================================= -->            </div>
            </div><!-- /.container -->
        </div><!-- /.link-list-row -->

        <div class="copyright-bar">
            <div class="container">
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="copyright">
                        &copy; <a href="<?php echo yii\helpers\Url::to(['index/index']) ?>">psl</a> - all rights reserved
                    </div><!-- /.copyright -->
                </div>
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="payment-methods ">
                        <ul>
                            <li><img alt="" src="/assets/images/payments/payment-visa.png"></li>
                            <li><img alt="" src="/assets/images/payments/payment-master.png"></li>
                            <li><img alt="" src="/assets/images/payments/payment-paypal.png"></li>
                            <li><img alt="" src="/assets/images/payments/payment-skrill.png"></li>
                        </ul>
                    </div><!-- /.payment-methods -->
                </div>
            </div><!-- /.container -->
        </div><!-- /.copyright-bar -->

    </footer><!-- /#footer -->
        <!-- ============================================================= FOOTER : END ============================================================= -->	</div><!-- /.wrapper -->

<!-- JavaScripts placed at the end of the document so the pages load faster -->
<script src="front/js/jquery-1.10.2.min.js"></script>
<script src="front/js/jquery-migrate-1.2.1.js"></script>
<script src="front/js/bootstrap.min.js"></script>
<script src="front/js/gmap3.min.js"></script>
<script src="front/js/bootstrap-hover-dropdown.min.js"></script>
<script src="front/js/owl.carousel.min.js"></script>
<script src="front/js/css_browser_selector.min.js"></script>
<script src="front/js/echo.min.js"></script>
<script src="front/js/jquery.easing-1.3.min.js"></script>
<script src="front/js/bootstrap-slider.min.js"></script>
<script src="front/js/jquery.raty.min.js"></script>
<script src="front/js/jquery.prettyPhoto.min.js"></script>
<script src="front/js/jquery.customSelect.min.js"></script>
<script src="front/js/wow.min.js"></script>
<script src="front/js/scripts.js"></script>

<script>
    $("#createlink").click(function(){
        $(".billing-address").slideDown();
    });

</script>

</body>
</html>

