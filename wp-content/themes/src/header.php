<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rice Centre</title>

    <!-- Bootstrap -->
    <link href="<?php echo get_template_directory_uri(); ?>/inc/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/css/font-awesome.min.css">
    <link href="<?php echo get_template_directory_uri(); ?>/inc/css/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/css/style.css" type="text/css">
</head>

<body>
    <header>
        <section class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="log-in hidden-xs hidden-sm ">
                        <div class="trade">
                            <span>ALPHA TRADERS</span>
                        </div>
                        <div class="tel">
                            <i class="fa fa-phone" aria-hidden="true"></i><span>99999999</span>
                        </div>
                        <div class="sm">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

        </section>
        <section class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3  col-sm-3">
                    <div class="logo hidden-xs">
                        <img src="<?php echo get_template_directory_uri(); ?>/inc/img/logo.png" class="img-responsive" alt="">
                    </div>
                </div>
                <div class="col-lg-9 col-md-9  col-sm-9">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand visible-xs" href="#"><img src="<?php echo get_template_directory_uri(); ?>/inc/img/logo.png" alt="" class="img-responsive"></a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="active"><a href="index.html">HOME<span class="sr-only">(current)</span></a></li>
<!--                                    <li><a href="index.html">HOME</a></li>-->
                                    <li><a href="about.html">ABOUT US</a></li>
                                    <li><a href="products.html">PRODUCTS</a></li>
                                    <li><a href="contact.html">CONTACT</a></li>
                                </ul>
                            </div>
                            <!-- /.navbar-collapse -->
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                </div>

            </div>
        </section>
    </header>

    <section class="banner">
    <?php
        echo do_shortcode('[layerslider id="2"]');
    ?>
    </section>
