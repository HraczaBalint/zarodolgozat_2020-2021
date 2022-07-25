<?php

namespace classes;

require_once 'classes/connection/connection_class.php';
use classes\connection\Connection;

/**
 * Manage all administrator tasks
 */
class Admin
{
	public static function updateUserLevel($user_level, $user_id){

		$conn = new Connection();
		$sql = "UPDATE users SET level = '$user_level' WHERE id = '$user_id'";
		$result = $conn->getConnectionString()->query($sql);
	}

	public static function selectUsers(){

		$conn = new Connection();
		$sql = "SELECT id, username, email, registration_date, level FROM users ORDER BY level DESC, id";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}

	public static function contentDelete($content_id){

		$conn = new Connection();
		$sql = "DELETE FROM content WHERE id = '$content_id'";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			$_POST = array();
			header("refresh: 0");
		}
	}

	public static function contentTypeSelect(){

		$conn = new Connection();
		$sql = "SELECT id, name FROM content_type";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}

	public static function checkPicture($pic_name, $pic_type, $pic_tmp_name){

		if (!preg_match("!image!", $pic_type)) {
			$_SESSION['message'] = "Please select an image file!";
			return false;	
		}

		if (!copy($pic_tmp_name, $pic_name)) {
			$_SESSION['message'] = "File copy error!";
			return false;
		}

		return true;
	}

	public static function checkText($name, $text_value, $min_length){

		if (empty($text_value)) {
			$_SESSION['message_insert'] = "Content $name can not be empty!";
			return false;
		}

		if (strlen($text_value) < $min_length) {
			$_SESSION['message_insert'] =  "Content $name not long enough!";
			return false;
		}

		return true;
	}

	public static function insertNews($type_id, $name, $pic1, $des){

		$conn = new Connection();
		$sql = "INSERT INTO content (type_id, name, picture1, description, last_update) VALUES('$type_id', '$name', '$pic1', '$des', now())";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			$_POST = array();
			header("refresh: 0");
		}
	}

	public static function insertGames($type_id, $name, $icon, $pic1, $pic2, $pic3, $pic4, $des, $content){

		$conn = new Connection();
		$sql = "INSERT INTO content (type_id, name, icon, picture1, picture2, picture3, picture4, description, content, last_update) VALUES('$type_id', '$name', '$icon', '$pic1', '$pic2', '$pic3', '$pic4', '$des', 'contents/$content', now())";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			$_POST = array();
			header("refresh: 0");
		}
	}

	public static function insertAssets($type_id, $name, $icon, $des, $content){

		$conn = new Connection();
		$sql = "INSERT INTO content (type_id, name, icon, description, content, last_update) VALUES('$type_id', '$name', '$icon', '$des', 'contents/$content', now())";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			$_POST = array();
			header("refresh: 0");
		}
	}

	public static function updatePicture($db_pic_type, $pic_name, $pic_type, $pic_tmp_name, $content_id){

		if (!preg_match("!image!", $pic_type)) {
			return;	
		}

		if (!copy($pic_tmp_name, $pic_name)) {
			$_SESSION['message_update'] = "File Copy error!";
			return;
		}
		
		if (copy($pic_tmp_name, $pic_name)) {
			$conn = new Connection();
			$sql = "UPDATE content SET $db_pic_type = '$pic_name', last_update = now() WHERE id = '$content_id'";
			$result = $conn->getConnectionString()->query($sql);
		}

		if ($result) {
			unset($pic_name);
			header("refresh: 0");
		}
	}

	public static function updateText($db_text_type, $text_value, $content_id, $min_length){

		if (empty($text_value)) {
			return;
		}

		if (strlen($text_value) < $min_length) {
			return;
		}

		$conn = new Connection();
		$sql = "UPDATE content SET $db_text_type = '$text_value', last_update = now() WHERE id = $content_id";
		$result = $conn->getConnectionString()->query($sql);

		if ($result) {
			unset($text_value);
			header("refresh: 0");
		}
	}

	public static function updateVisibility($available, $content_id){

		$conn = new Connection();
		$sql = "UPDATE content SET available = '$available' WHERE id = $content_id";
		$result = $conn->getConnectionString()->query($sql);
	}

	public static function contentSelect($type_id){

		$conn = new Connection();
		$sql = "SELECT id, name, icon, picture1, picture2, picture3, picture4, description, content, DATE(last_update), available FROM content WHERE type_id = '$type_id' ORDER BY id DESC";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}
}