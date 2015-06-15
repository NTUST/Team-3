<?php 

include('core/init.inc.php');

/*image upload*/
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if($_POST["fileToUpload"]!="") {//上傳照片了
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $message = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    $message = "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $message += " Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}
// Displaying Image
$imageName = $_FILES["fileToUpload"]["name"]; //檔案名稱
$imgPath = "uploads/".$imageName;//檔案路徑

/*image upload end*/
if(isset($_POST['submit'])){
	if ($_POST['name']!="" && $_POST['title']!="" && $_POST['body']!="" && $_POST['email']!="" && $_POST['restaurant']!="" && $_POST['store']!="") {//如果表單都填好了
		
		// 驗證email 
		$email = test_input($_POST["email"]); //test_input函式在init.inc中
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
		  $emailErr = "無效的 email 格式！"; 
		}

		add_post($link, $_POST['name'], $_POST['title'], $_POST['body'], $email, $_POST['restaurant'], $_POST['store'], $imgPath);//把文章資料和照片檔案路徑加入資料庫
	
?>
		<!-- 重新導向到文章列表頁面 -->
		<script Language="JavaScript">
			location.href= ('list.php');
		</script>
<?php
		die();//結束，下面就不用再讀了
	}
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
    
    <title>檢舉區 | NTUST Safood</title>

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

 	<!-- TinyMCE -->
 	<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
	<script>tinymce.init({selector:'textarea'});</script>

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
    
    <section id="post" class="bg-light-gray">
	 	<div class="container">
	 		<div class="row">
		 		<div class="col-xs-12 text-center">
			 		<h1>食安問題檢舉</h1>
				 	<hr>
			 	</div>
		 	</div>
		 	<div class="row">
		 		<div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
			 		<!-- 檢舉PO文 -->
				 	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">	
			 			<h4 style="color:rgb(255, 73, 65)">檢舉人資料</h3>
			 			<hr>
			 			<!-- 檢舉人姓名 -->
			 			<div class="form-group">
				 			<label for="name" class="col-sm-2 control-label">姓名：</label>
				 			<div class="col-sm-10">
				 				<input class="form-control" type="text" name="name" id="name" placeholder="Your Name">
				 			</div>
						</div>
			 			<!-- 檢舉人email -->
			 			<div class="form-group">
				 			<label for="email" class="col-sm-2 control-label">Email：</label>
				 			<div class="col-sm-10">
				 				<input class="form-control" type="email" name="email" id="email" placeholder="Your Email">
				 			</div>
						</div>
						<br>
						<h4 style="color:rgb(255, 73, 65)">檢舉內容</h3>
						<hr>
						<!-- 檢舉標題 -->
			 			<div class="form-group">
				 			<label for="title" class="col-sm-2 control-label">檢舉標題：</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="title" id="title" placeholder="簡短說明">
							</div>
						</div>

						<!-- 餐廳 selects -->
						<select class="form-control" name="restaurant" id="restaurant">
						  <option value="default">請選擇餐廳</option>
						  <option value="學生第一餐廳店家">學生第一餐廳店家</option>
						  <option value="學生第三餐廳店家">學生第三餐廳店家</option>
						  <option value="教職員餐廳">教職員餐廳</option>
						</select>

						<br>

						<!-- 店家 selects -->
						<select class="form-control" name="store" id="store">
							<option value="default">請選擇店家</option>

							<optgroup class="store1">
							  <option class="store1" value="丼太郎">丼太郎</option>
							  <option class="store1" value="樂活複合料理">樂活複合料理</option>
							  <option class="store1" value="全家便利商店">全家便利商店</option>
							  <option class="store1" value="生活美而美(金盃美而美)">生活美而美(金盃美而美)</option>
							  <option class="store1" value="水霸鮮茶飲">水霸鮮茶飲</option>
							  <option class="store1" value="韓風小舖">韓風小舖</option>
							  <option class="store1" value="四海遊龍">四海遊龍</option>
							  <option class="store1" value="上品排骨">上品排骨</option>
							  <option class="store1" value="台灣古早味">台灣古早味</option>
							  <option class="store1" value="安娜的廚房">安娜的廚房</option>
							  <option class="store1" value="品客自助餐">品客自助餐</option>
							  <option class="store1" value="地中海私房料理">地中海私房料理</option>
							  <option class="store1" value="福客鐵板燒">福客鐵板燒</option>				
							  <option class="store1" value="Juice Bar">Juice Bar</option>
							  <option class="store1" value="奈手卷">奈手卷</option>
							  <option class="store1" value="摩斯漢堡">摩斯漢堡</option>
							  <option class="store1" value="水果攤">水果攤</option>
							  <option class="store1" value="醉時尚">醉時尚</option>
							</optgroup>

							<optgroup class="store2">
						  	  <option class="store2" value="昌聖麵包店">昌聖麵包店</option>
							  <option class="store2" value="金盃美而美">金盃美而美</option>
							  <option class="store2" value="豪享來">豪享來</option>
							  <option class="store2" value="七辣滷味">七辣滷味</option>
							  <option class="store2" value="雞同ㄚ講燒臘">雞同ㄚ講燒臘</option>
							  <option class="store2" value="八方雲集">八方雲集</option>
							  <option class="store2" value="帝一味自助餐">帝一味自助餐</option>
							  <option class="store2" value="日式手做料理">日式手做料理</option>
							  <option class="store2" value="藝素佳素食">藝素佳素食</option>
							  <option class="store2" value="潘記天津蔥抓餅">潘記天津蔥抓餅</option>
							  <option class="store2" value="阿水茶舖">阿水茶舖</option>
							  <option class="store2" value="7-11便利商店">7-11便利商店</option>
							</optgroup>

							<optgroup class="store3">
						  	  <option class="store3" value="自助餐部">自助餐部</option>
							  <option class="store3" value="快餐部">快餐部</option>
							  <option class="store3" value="好了啦超大杯茶舖">好了啦超大杯茶舖</option>
							  <option class="store3" value="中餐部(圓桌部)">中餐部(圓桌部)</option>
							</optgroup>
						</select>

						<br>

						<!-- 檢舉內容描述 -->
			 			<div class="form-group">
							<label for="body" class="control-label">檢舉內容：</label><br>		
							<textarea name="body" id="body" rows="10" placeholder="遇到了什麼食安問題？"></textarea>
						</div>

						<!-- 照片上傳 -->
			 			<div class="form-group">
							<label for="uploadImage" class="control-label">上傳照片</label>  			
			    			<input type="file" name="fileToUpload" id="fileToUpload">
		    			</div>
			 		
			 			<!-- 提交 -->
			 			<div class="form-group">
			 				<div class="text-center">
			 					<input type="submit" name="submit" value="送出" class="btn btn-xl">
			 				</div>
			 			</div>
				 	</form>
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
	

	<!-- 用jQuery做選擇完餐廳selector後，自動篩選出該餐廳有哪些店家 -->
 	<script>
		$('#restaurant').change(function () {
	        if ($('#restaurant option:selected').text() == "學生第一餐廳店家"){
	                $('.store1').css('display', 'block');
	                $('.store2').css('display', 'none');
	                $('.store3').css('display', 'none');
	        } else if ($('#restaurant option:selected').text() == "學生第三餐廳店家"){
	                $('.store1').css('display', 'none');
	                $('.store2').css('display', 'block');
	                $('.store3').css('display', 'none');
	        } else if ($('#restaurant option:selected').text() == "教職員餐廳"){
	                $('.store1').css('display', 'none');
	                $('.store2').css('display', 'none');
	                $('.store3').css('display', 'block');
        	}
        });
	</script>
 </body>
 </html>