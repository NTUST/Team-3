<?php 

// checks if the given post id is in the table.確認傳入的pid是否已經存在於資料庫中，因為要讀取文章
function valid_pid(mysqli $link, $pid){
	$pid = (int)$pid;
	$query = "SELECT * FROM `posts` WHERE `post_id` = {$pid}";
	$result = mysqli_query($link, $query);
	$check = mysqli_num_rows($result);
	if ($check) {
		return true;//資料庫中有此pid，valid pid
	}else{
		return false;//資料庫中沒有此pid，invalid pid
	}
	mysqli_free_result($result);
}

// 增加文章，配合資料庫欄位給變數
function add_post(mysqli $link, $name, $title, $body, $email, $restaurant, $store, $imgPath){
	$name = mysqli_real_escape_string($link, $name);
	$title = mysqli_real_escape_string($link, $title);
	$body = mysqli_real_escape_string($link, $body);
	$email = mysqli_real_escape_string($link, $email);
	$nowTime = date("Y/m/d G:i:sa");
	//insert data
	mysqli_query( $link, "INSERT into posts (post_user, post_title, post_body, post_date, post_email, post_restaurant, post_store, post_imagePath) VALUES ( '{$name}', '{$title}', '{$body}', '{$nowTime}', '{$email}', '{$restaurant}', '{$store}', '{$imgPath}' )" );
}

//抓全部的文章
function get_posts(mysqli $link){
	$query = "SELECT
					`posts`.`post_id` AS `id`,
					`posts`.`post_title` AS `title`,
					LEFT(`posts`.`post_body`, 50) AS `preview`,
					`posts`.`post_user` AS `user`,
					DATE_FORMAT(`posts`.`post_date`, '%Y/%m/%d %H:%i:%s') AS `date`,
					`posts`.`post_restaurant` AS `restaurant`,
					`posts`.`post_store` AS `store`,
					`comments`.`total_comments`,
					DATE_FORMAT(`comments`.`last_comment`, '%Y/%m/%d %H:%i:%s') AS `last_comment`
				FROM `posts`
				LEFT JOIN(
					SELECT
						`post_id`,
						COUNT(`comment_id`) AS `total_comments`,
						MAX(`comment_date`) AS `last_comment`
					FROM `comments`
					GROUP BY `post_id`
				) AS `comments`
				ON `posts`.`post_id` = `comments`.`post_id`
				ORDER BY `posts`.`post_date` DESC";

	$result = mysqli_query($link, $query);
	$rows = array();
	$counter=0;
	while(($row = mysqli_fetch_array($result))){
		// print_r($row);
		$rows[$counter] = $row;
		if ($row['total_comments']===null) {
			$rows[$counter]['total_comments']=0;	
		}
		if ($row['last_comment']===null) {
			$rows[$counter]['last_comment']="尚無回應";	
		}
		$counter+=1;
	}
	$counter=0;//initialize
	return $rows;
	mysqli_free_result($result);

}

// 抓單一文章
function get_post(mysqli $link, $pid){
	$pid = (int)$pid;
	$query = "SELECT 
				`post_title` AS `title`,
				`post_body` AS `body`,
				`post_user` AS `user`,
				`post_date` AS `date`,
				`post_restaurant` AS `restaurant`,
				`post_store` AS `store`,
				`post_imagePath` AS `imagePath`
			FROM `posts`
			WHERE `post_id` = {$pid}";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	$row['comments'] = get_comments($link, $pid);
	return $row;
	mysqli_free_result($result);

}

?>	