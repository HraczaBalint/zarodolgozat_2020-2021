<?php

namespace classes;

require_once 'classes/connection/connection_class.php';
use classes\connection\Connection;

/**
 * Manage all user related activity
 */
class Users
{

	public static function testInput($text) {

		$text = str_replace('|', '?', $text);
		$text = str_replace('&', '?', $text);
		$text = str_replace('"', '?', $text);
		$text = str_replace("'", "''", $text);
		$text = str_replace('%', '?', $text);
		$text = str_replace('*', '?', $text);
		$text = str_replace(' OR ', '?', $text);
		$text = str_replace(' AND ', '?', $text);
		$text = str_replace('=', '?', $text);
		$text = str_replace("\\", "?", $text);
		$text = trim($text);
		return $text;
	}


	public static function userLogin($email, $pass){

		$conn = new Connection();
		$sql = "SELECT * FROM users WHERE email = '$email' && password = '$pass'";
		$result = $conn->getConnectionString()->query($sql);

		if ($result->num_rows != 1) {
			$_SESSION['login_message'] = "Incorrect email or password!";
		}
		else{
			$row = $result->fetch_assoc();

			$_SESSION['user_id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['avatar'] = $row['avatar'];
			$_SESSION['level'] = $row['level'];

			header('location: index.php');
		}
	}

	public static function userRegistration($username, $email, $pass, $conf_pass, $av_name, $av_type, $av_tmp_name){

		if (strlen($username) < 2) {
			$_SESSION['registration_message'] = "Username not long enough!";
			return;
		}

		$conn = new Connection();
		$sql_username_check = "SELECT * FROM users WHERE username = '$username'";
		$result_username_check = $conn->getConnectionString()->query($sql_username_check);

		if ($result_username_check->num_rows > 0) {
			$_SESSION['registration_message'] = "Username already exists!";
			return;
		}

		$sql_email_check = "SELECT * FROM users WHERE email = '$email'";
		$result_email_check = $conn->getConnectionString()->query($sql_email_check);

		if ($result_email_check->num_rows != 0) {
			$_SESSION['registration_message'] = "Email address already exists!";
			return;
		}

		if ($pass != $conf_pass) {
			$_SESSION['registration_message'] = "Two password do not match!";
			return;
		}

		if (!preg_match("!image!", $av_type)) {
			$av_name = 'pictures/required/' . 'def_user_avatar.png';
		}
		else{
			if (!copy($av_tmp_name, $av_name)) {
				$_SESSION['registration_message'] = "File upload failed!";
				return;
			}
		}

		$sql_users_check = "SELECT * FROM users";
		$result_users_check = $conn->getConnectionString()->query($sql_users_check);

		if ($result_users_check->num_rows == 0) {
			$level = 5;
		}
		else{
			$level = 2;
		}

		$sql_insert = "INSERT INTO users (username, password, email, avatar, level) VALUES('$username', '$pass', '$email', '$av_name', '$level')";
		$result_insert = $conn->getConnectionString()->query($sql_insert);
		$sql = "SELECT * FROM users WHERE email = '$email' && password = '$pass'";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			$row = $result->fetch_assoc();

			$_SESSION['user_id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['avatar'] = $row['avatar'];
			$_SESSION['level'] = $row['level'];

			header('location: index.php');
		}
	}

	public static function userLogout(){

		session_start();
		session_unset();
		session_destroy();

		header('location: index.php');
	}

	public static function contentSelect($content_id){

		$conn = new Connection();
		$sql = "SELECT * FROM content WHERE id = '$content_id' && available = 1";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();
		if ($row['available'] == 0) {
			header('location: content_category.php');
			return;
		}

		return $row;
	}

	public static function insertStatistics($content_id, $user_id, $download){

		$conn = new Connection();
		$sql = "INSERT INTO statistics (content_id, user_id, download_date) VALUES ('$content_id', '$user_id', now())";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			unset($download);
			header('refresh: 0');
		}
	}

	public static function writeComment($content_id, $user_id, $comment){
		
		$conn = new Connection();
		$sql = "INSERT INTO comment (content_id, user_id, comment_text, comment_date) VALUES('$content_id', '$user_id', '$comment', now())";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			unset($comment);
			header('refresh: 0');
		}
	}

	public static function selectComments($content_id){

		$conn = new Connection();
		$sql = "SELECT users.username, users.avatar, comment.id, comment.comment_text, comment.comment_date FROM users JOIN comment ON comment.user_id = users.id WHERE comment.content_id = '$content_id' ORDER BY comment.id DESC";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}

	public static function redownloadContent($redownload_id){

		$conn = new Connection();
		$sql = "SELECT content.content FROM content JOIN statistics ON statistics.content_id = content.id WHERE content.id = '$redownload_id'";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();

		return $row;
	}

	public static function selectInventoryItems($user_id){

		$conn = new Connection();
		$sql = "SELECT DISTINCT(DATE(statistics.download_date)) AS 'download_date', content.id, content.name, content.icon, content.content, DATE(content.last_update) AS 'last_update', CASE WHEN statistics.download_date < content.last_update THEN 'update' END AS 'update_req' FROM statistics JOIN content ON content.id = statistics.content_id JOIN users ON users.id = statistics.user_id WHERE statistics.user_id = '$user_id' && content.available = 1 GROUP BY content.id ORDER BY statistics.id DESC";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}
}