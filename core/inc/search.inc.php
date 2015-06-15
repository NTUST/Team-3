<?php 
	
function get_search(mysqli $link, $keyword){
	$keyword = trim($keyword);
	$keyword = mysqli_real_escape_string($link, $keyword);
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
			WHERE `posts`.`post_title` LIKE '%$keyword%'
			OR `posts`.`post_body` LIKE '%$keyword%'
			OR `posts`.`post_user` LIKE '%$keyword%'
			OR `posts`.`post_date` LIKE '%$keyword%'
			OR `posts`.`post_restaurant` LIKE '%$keyword%'
			OR `posts`.`post_store` LIKE '%$keyword%'
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


?>