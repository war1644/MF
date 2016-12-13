<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>荒野之歌:TEAM</title>

    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">

	<!-- Owl Carousel Assets -->
    <link href="<?php echo V_URL;?>static/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo V_URL;?>static/owl-carousel/owl.theme.css" rel="stylesheet">

	<!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo V_URL;?>static/css/style.css">
    <link href="<?php echo V_URL;?>static/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

	<!-- Custom Fonts -->
    <link rel="stylesheet" href="<?php echo V_URL;?>static/font-awesome-4.4.0/css/font-awesome.min.css" type="text/css">

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo V_URL;?>static/js/html5shiv.js"></script>
    <script src="<?php echo V_URL;?>static/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<header>
	<!--Top-->
	<nav id="top">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<strong>欢迎来到《重装机兵:荒野之歌》动漫制作组</strong>
				</div>
				<div class="col-md-6">
					<ul class="list-inline top-link link">
						<li><a href="/"><i class="fa fa-home"></i>首页</a></li>
						<li><a href="login.html"><i class="fa fa-sign-in"></i>登录</a></li>
						<li><a href="reg.html"><i class="fa fa-registered"></i>注册</a></li>
						<li><a href="User.html"><i class="fa fa-user"></i>欢迎  </a></li>
						<li><a href="#"><i class="fa fa-ban"></i>退出登录</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>

	<!--Navigation-->
	<nav id="menu" class="navbar container">
		<div class="navbar-header">
			<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
			<a class="navbar-brand" href="#">
				<div class="logo"><span>制作组logo</span></div>
			</a>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown"><a href="GroupMember.html"><i class="fa fa-group"></i>制作组</a>
				</li>
				<li class="dropdown"><a href="Group.html"><i class="fa fa-ambulance"></i>程序组</a>
				</li>
				<li class="dropdown"><a href="Group.html" class="dropdown-toggle" ><i class="fa fa-photo"></i>画图</a>
					<div class="dropdown-menu">
						<div class="dropdown-inner">
							<ul class="list-unstyled">
								<li><a href="archive.html">Text 201</a></li>
								<li><a href="archive.html">Text 202</a></li>
								<li><a href="archive.html">Text 203</a></li>
								<li><a href="archive.html">Text 204</a></li>
								<li><a href="archive.html">Text 205</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li class="dropdown"><a href="Group.html" class="dropdown-toggle" ><i class="fa fa-file-text"></i>剧情组</a>
					<div class="dropdown-menu" style="margin-left: -203.625px;">
						<div class="dropdown-inner">
							<ul class="list-unstyled">
								<li><a href="archive.html">Text 301</a></li>
								<li><a href="archive.html">Text 302</a></li>
								<li><a href="archive.html">Text 303</a></li>
								<li><a href="archive.html">Text 304</a></li>
								<li><a href="archive.html">Text 305</a></li>
							</ul>
							<ul class="list-unstyled">
								<li><a href="archive.html">Text 306</a></li>
								<li><a href="archive.html">Text 307</a></li>
								<li><a href="archive.html">Text 308</a></li>
								<li><a href="archive.html">Text 309</a></li>
								<li><a href="archive.html">Text 310</a></li>
							</ul>
							<ul class="list-unstyled">
								<li><a href="archive.html">Text 311</a></li>
								<li><a href="archive.html">Text 312</a></li>
								<li><a href="archive.html#">Text 313</a></li>
								<li><a href="archive.html#">Text 314</a></li>
								<li><a href="archive.html">Text 315</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li><a href="Group.html"><i class="fa fa-cubes"></i>3D</a></li>
				<li><a href="AudioGroup.html"><i class="fa fa-volume-up"></i>配音</a></li>
				<li><a href="Group.html"><i class="fa fa-bullhorn"></i>宣传</a></li>
				<li><a href="archive.html"><i class="fa fa-comments-o"></i>帖子</a></li>
				<li><a href="contact.html"><i class="fa fa-comment-o"></i>发帖</a></li>
				<li><a href="posts.html"><i class="fa fa-comment-o"></i>帖子详情</a></li>
			</ul>
			<ul class="list-inline navbar-right top-social">
				<li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
			</ul>
		</div>
	</nav>
</header>
	<div class="featured container">
		<div class="row">
			<div class="col-sm-12">
				<!-- Carousel -->
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
						<li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
					</ol>
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="../static/images/1.jpg" alt="First slide">
						</div>
						<div class="item">
							<img src="../static/images/2.jpg" alt="First slide">
						</div>
						<div class="item">
							<img src="../static/images/3.jpg" alt="First slide">
						</div>
					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div><!-- /carousel -->
			</div>

		</div>
	</div>
	<!-- /////////////////////////////////////////Content -->
	<div id="page-content" class="index-page container">
		<div class="row">
			<div id="main-content"><!-- background not working -->
				<div class="col-md-9">
					<div class="box">
						<div class="box-header header-vimeo">
							<h2>最近新帖</h2>
						</div>
						<div class="box-content">
							<!-- <div class="row"> -->
								<div class="col-md-4">
									<div class="post wrap-vid">
										<div class="zoom-container">
											<div class="zoom-caption">
												<a href="single.html">
													<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
												</a>
											</div>
											<img src="../static/images/1.jpg">
										</div>
										<div class="wrapper">
											<h5 class="vid-name"><a href="#">帖子标题一</a></h5>
											<div class="info">
												<h6>By <a href="#">苏打水</a></h6>
												<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="post wrap-vid">
										<div class="zoom-container">
											<div class="zoom-caption">
												<a href="single.html">
													<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
												</a>
											</div>
											<img src="../static/images/1.jpg">
										</div>
										<div class="wrapper">
											<h5 class="vid-name"><a href="#">帖子标题一</a></h5>
											<div class="info">
												<h6>By <a href="#">苏打水</a></h6>
												<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="post wrap-vid">
										<div class="zoom-container">
											<div class="zoom-caption">
												<a href="single.html">
													<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
												</a>
											</div>
											<img src="../static/images/1.jpg">
										</div>
										<div class="wrapper">
											<h5 class="vid-name"><a href="#">帖子标题一</a></h5>
											<div class="info">
												<h6>By <a href="#">苏打水</a></h6>
												<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											</div>
										</div>
									</div>
								</div>
							<!-- </div> -->
						</div>
					</div>

					<div class="box">
						<div class="box-header header-natural">
							<h2>热门讨论</h2>
						</div>
						<div class="box-content">
							<div class="row">
								<div class="col-md-6">
									<img src="../static/images/6.jpg">
									<h3><a href="#">随便岁百年</a></h3>
									<span><i class="fa fa-heart"></i> 1,200 / <i class="fa fa-calendar"></i> 25/3/2015 / <i class="fa fa-comment-o"> / </i> 10 <i class="fa fa-eye"></i> 945</span>
									<span class="rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half"></i>
									</span>
									<p>阿首都加拉斯就对啦宿建德江阿斯利康点击率卡司机立刻打开手机丢了卡萨帝景</p>
								</div>
								<div class="col-md-6">
									<img src="../static/images/7.jpg">
									<h3><a href="#">打算离开家的卡拉集散地</a></h3>
									<span><i class="fa fa-heart"></i> 1,200 / <i class="fa fa-calendar"></i> 25/3/2015 / <i class="fa fa-comment-o"> / </i> 3 <i class="fa fa-eye"></i> 1007</span>
									<span class="rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star-half"></i>
									</span>
									<p>打算离开家的老卡机岁的老将阿喀琉斯打卡机刷卡单据阿隆索多久</p>
								</div>
							</div>
						</div>
					</div>

					<div class="box">
						<div class="box-header header-vimeo">
							<h2>视频</h2>
						</div>
						<div class="box-content">
							<div class="row">
								<div class="post wrap-vid col-md-4">
									<div class="zoom-container">
										<div class="zoom-caption">
											<span class="vimeo">Vimeo</span>
											<a href="single.html">
												<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
											</a>
											<p>Video's Name</p>
										</div>
										<img src="../static/images/1.jpg">
									</div>
									<div class="wrapper">
										<h5 class="vid-name"><a href="#">第一集</a></h5>
										<div class="info">
											<h6><i class="fa fa-user"></i><a href="#">Kelvin</a></h6>
											<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											<span class="rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="post wrap-vid col-md-4">
									<div class="zoom-container">
										<div class="zoom-caption">
											<span class="vimeo">Vimeo</span>
											<a href="single.html">
												<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
											</a>
											<p>Video's Name</p>
										</div>
										<img src="../static/images/1.jpg">
									</div>
									<div class="wrapper">
										<h5 class="vid-name"><a href="#">第2集</a></h5>
										<div class="info">
											<h6><i class="fa fa-user"></i><a href="#">Kelvin</a></h6>
											<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											<span class="rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="post wrap-vid col-md-4">
									<div class="zoom-container">
										<div class="zoom-caption">
											<span class="vimeo">Vimeo</span>
											<a href="single.html">
												<i class="fa fa-play-circle-o fa-3x" style="color: #fff"></i>
											</a>
											<p>Video's Name</p>
										</div>
										<img src="../static/images/3.jpg">
									</div>
									<div class="wrapper">
										<h5 class="vid-name"><a href="#">第四集</a></h5>
										<div class="info">
											<h6><i class="fa fa-user"></i><a href="#">Kelvin</a></h6>
											<span><i class="fa fa-heart"></i>1,200 / <i class="fa fa-calendar"></i>25/3/2015</span>
											<span class="rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div id="sidebar">
				<div class="col-md-3">
					<!---- Start Widget ---->
					<div class="widget wid-tags">
						<div class="heading"><h4>Search</h4></div>
						<div class="content">
							<form role="form" class="form-horizontal" method="post" action="">
								<input type="text" placeholder="搜点啥？" value="" name="v_search" id="v_search" class="form-control">
							</form>
						</div>
					</div>
					<div class="widget wid-comment">
						<div class="heading"><h4>荒野猎人</h4></div>
						<div class="content">
							<div class="post">
								<a href="single.html">
									<img src="../static/images/ava-1.jpg" class="img-circle">
								</a>
								<div class="wrapper">
									<a href="#"><h5>啊啊啊啊啊啊</h5></a>
									<ul class="list-inline">
										<li><i class="fa fa-calendar"></i>25/3/2015</li>
										<li><i class="fa fa-thumbs-up"></i>1,200</li>
									</ul>
								</div>
							</div>
							<div class="post">
								<a href="single.html">
									<img src="../static/images/ava-2.png" class="img-circle">
								</a>
								<div class="wrapper">
									<a href="#"><h5>bbbbbbb</h5></a>
									<ul class="list-inline">
										<li><i class="fa fa-calendar"></i>25/3/2015</li>
										<li><i class="fa fa-thumbs-up"></i>1,200</li>
									</ul>
								</div>
							</div>
							<div class="post">
								<a href="single.html">
									<img src="../static/images/ava-3.jpeg" class="img-circle">
								</a>
								<div class="wrapper">
									<a href="#"><h5>cccccc</h5></a>
									<ul class="list-inline">
										<li><i class="fa fa-calendar"></i>25/3/2015</li>
										<li><i class="fa fa-thumbs-up"></i>1,200</li>
									</ul>
								</div>
							</div>
							<div class="post">
								<a href="single.html">
									<img src="../static/images/ava-4.jpg" class="img-circle">
								</a>
								<div class="wrapper">
									<a href="#"><h5>ddddd</h5></a>
									<ul class="list-inline">
										<li><i class="fa fa-calendar"></i>25/3/2015</li>
										<li><i class="fa fa-thumbs-up"></i>1,200</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<div class="wrap-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-footer footer-3">
						<div class="footer-heading"><h4>友链</h4></div>
						<div class="content">
							<ul>
								<li><a href="#">啊啊啊啊啊啊啊啊啊啊</a></li>
								<li><a href="#">vvvvvvvvv</a></li>
								<li><a href="#">ccccccccccc</a></li>
								<li><a href="#">cccccccccccccccccd</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copy-right">
			<p>Copyright © 2016.核弹制作组 All rights reserved.<a target="_blank" href="http://###/">荒野之歌网站</a></p>
		</div>
	</footer>
	<!-- Footer -->

	<!-- JS -->
	<script src="<?php echo V_URL;?>static/owl-carousel/owl.carousel.js"></script>
    <script>
    $(document).ready(function() {
      $("#owl-demo-1").owlCarousel({
        autoPlay: 3000,
        items : 1,
        itemsDesktop : [1199,1],
        itemsDesktopSmall : [400,1]
      });
	  $("#owl-demo-2").owlCarousel({
        autoPlay: 3000,
        items : 3,

      });
    });
    </script>


	<script type="text/javascript" src="<?php echo V_URL;?>static/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript" src="<?php echo V_URL;?>static/js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
	<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
</body>
</html>
