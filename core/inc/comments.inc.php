<?php 

// fetches all of the comments for a given blog post
function get_comments(mysqli $link, $pid){
	$pid = (int)$pid;
	$query = "SELECT
				comment_body AS body,
				comment_user AS user,
				DATE_FORMAT(comment_date, '%Y/%m/%d %H:%i:%s') AS `date`
			FROM comments
			WHERE post_id = {$pid}";

	$result = mysqli_query($link, $query);
	$comment = array();
	$counter=0;
	while (($row = mysqli_fetch_array($result))) {
		// print_r($row);
		$comment[$counter]=$row;
		$counter+=1;
	}
	$counter=0;//initialize
	return $comment;
	mysqli_free_result($result);
}

function add_comment(mysqli $link, $pid, $user, $body){
	if (valid_pid($link, $pid)===false) {
		return false;
	}

	$pid = (int)$pid;
	$user = mysqli_real_escape_string($link, $user);
	$body = mysqli_real_escape_string($link, $body);
	$nowTime = date("Y/m/d  G:i:sa");

	mysqli_query( $link, "INSERT into comments (post_id, comment_user, comment_body, comment_date) VALUES ( '{$pid}', '{$user}', '{$body}', '{$nowTime}' )" );
	return true;
}

?>