<?php 

include('core/init.inc.php');

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
 	
 	<title>食安檢舉事件 | NTUST Safood </title>

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

 	<!-- 文章列表 -->
 	<section id="list" class="bg-light-gray">
 		<div class="container">
	 		<div class="row">
		 		<div class="col-xs-12 text-center">
			 		<h1>食安檢舉事件</h1>
			 		<hr>
			 	</div>
			</div>

			<div class="row">
			 	<div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 text-center">
			 		<form action="" method="post">
			 			<div class="input-group text-center">
				 			<input class="form-control" type="text" name="search" placeholder="輸入關鍵字">
				 			<span class="input-group-btn">
								<input class="btn btn-default" type="submit" name="submit" value="搜尋">
							</span>
						</div>
			 		</form>
			 	</div>
			</div>
			
			<div class="row">
			 	<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 text-center">
			
			 		<?php
					if($_POST['submit']=="搜尋"){//按下搜尋功能後
						if (isset($_POST['search'])) {//如果有輸入要搜尋的關鍵字
							$keyword = $_POST['search'];//取出使用者輸入的關鍵字
							$searchedPosts = get_search($link, $keyword);//從資料庫取出包含關鍵字的文章
							foreach($searchedPosts as $post){//跑每個文章
					?>
								<li class="list-item">
									<h2><a href="read.php?pid=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
									<h4><?php echo $post['user']; ?> 在 <?php echo $post['date']; ?> 檢舉</h4>
									<!-- 餐廳和店家的label -->
									<h4><span class="restaurant label label-info"><?php echo $post['restaurant']; ?></span> 
									<span class="store label label-danger"><?php echo $post['store']; ?></span></h4>
									<!--預覽文章內容（取消） -->
									<!-- <p><?php //echo $post['preview']; ?></p> -->
									<!-- <hr> -->
								</li>
					<?php 
							}
						}else{//若按下搜尋按紐，卻無輸入關鍵字，照常顯示全部文章
							$posts = get_posts($link);//從資料庫取出全部的文章資料
							// print_r($posts);
							foreach($posts as $post){//跑每個文章
					?>		
								<li class="list-item">
									<h2><a href="read.php?pid=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
									<h4><?php echo $post['user']; ?> 在 <?php echo $post['date']; ?> 檢舉</h4>
									<!-- 餐廳和店家的label -->
									<h4><span class="restaurant label label-info"><?php echo $post['restaurant']; ?></span> 
									<span class="store label label-danger"><?php echo $post['store']; ?></span></h4>
									<!--預覽文章內容（取消） -->
									<!-- <p><?php //echo $post['preview']; ?></p>  -->
									<!-- <hr> -->
								</li>
					<?php 
							}
						}
					}
			 		else {//沒有搜尋關鍵字，照常顯示全部文章
			 			$posts = get_posts($link);//從資料庫取出全部的文章資料
						// print_r($posts);
						foreach($posts as $post){//跑每個文章
					?>
							<li class="list-item">
								<h2><a href="read.php?pid=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
								<h4><?php echo $post['user']; ?> 在 <?php echo $post['date']; ?> 檢舉</h4>
								<!-- 餐廳和店家的label -->
								<h4><span class="restaurant label label-info"><?php echo $post['restaurant']; ?></span> 
								<span class="store label label-danger"><?php echo $post['store']; ?></span></h4>
								<!--預覽文章內容 （取消）-->
								<!-- <p><?php //echo $post['preview']; ?></p>  -->
								<!-- <hr> -->
							</li>
					<?php 
						}
			 		}
			 		?>
		 		</div>
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