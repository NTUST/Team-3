<?php

include('core/init.inc.php');

//確認pid是否正確 
if ( isset($_GET['pid'])===false || valid_pid($link, $_GET['pid'])===false ) {
	echo "Invalid post ID.";
	die();
}else{
	$post = get_post($link, $_GET['pid']);//從資料庫拿取文章內容
}
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="台科大網頁製作課程Super Senior組">
    <meta name="KeyWords" content="NTUST safood 台科 台灣科大 餐廳 食安">

 	<title><?php echo $post['title']; ?> | NTUST Safood</title>

 	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/safood.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

 </head>
 <body id="page-top" class="index">
 	<!-- Facebook SDK for JavaScript -->
 	<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : 'your-app-id',
          xfbml      : true,
          version    : 'v2.3'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.html">NTUST Safood</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="index.html"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.html">關於</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="list.php">觀看檢舉事件</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="post.php">我要檢舉</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="team.html">開發團隊</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <section id="read" class="bg-light-gray">
	 	<div class="container">
	 		<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 text-center">
				<!-- 顯示單一文章 -->
				<h2><?php echo $post['title']; ?></h2>
				<hr>		
				<h4>檢舉人：<?php echo $post['user']; ?></h4>
				<h4>檢舉時間：<?php echo $post['date']; ?></h4>

				<!-- 餐廳和店家的label -->
				<h4><span class="restaurant label label-info"><?php echo $post['restaurant']; ?></span> <span class="store label label-danger"><?php echo $post['store']; ?></span></h4>
				
				<!-- 顯示文章內容 -->
				<br>
				<p><?php echo $post['body']; ?></p>
				<br>
				
				<!-- 顯示照片 -->
				<?php 
				$img = $post['imagePath'];//拿取照片檔案的路徑
				if($img){//如果有照片檔案才顯示
					echo '<img src= "'.$img.'" class="img-responsive img-centered" alt="Responsive image">';
				}
				?>
				<!-- /.顯示單一文章end -->

				<!-- 返回鍵 -->
				<br><br>
				<a href="list.php"><button type="button" class="btn btn-primary">返回</button></a>

				<!-- 留言板 （把原本的手工留言板改成外掛元件）-->
				<br><br><br>	
				<h4>所有回應</h4>	
				<?php echo '<div class="fb-comments" data-href="http://ericdeng.skycastle.in/projects/NTUSTSafood/read.php?pid='.$_GET['pid'].'" data-numposts="5" data-width="100%" data-order-by="reverse_time"></div>'; ?>
				
			</div>
	 	</div>
	</section>

 	<!-- footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="copyright">Copyright &copy; <a href="team.html">Super Senior</a> 2015</span>
                </div>
            </div>
        </div>
    </footer>

 	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/safood.js"></script>

 </body>
 </html>