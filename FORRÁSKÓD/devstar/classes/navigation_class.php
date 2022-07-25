<?php

namespace classes;

require_once 'classes/connection/connection_class.php';
use classes\connection\Connection;

/**
 * Navigation between pages, cookie management and option selection
 */
class Navigation
{
	public static function mainSelect(){

		$conn = new Connection();
		$sql = "SELECT id, name, icon, background_image FROM content_type";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}

	public static function mainToContentCategory($category_id){

		setcookie('category_id', $category_id);
		header('location: content_category.php');
	}

	public static function contentCategoryToMain($category_id){

		$conn = new Connection();
		$sql = "SELECT MAX(id), MIN(id) FROM content_type";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();

		if (empty($category_id) || $category_id > $row['MAX(id)'] || $category_id < $row['MIN(id)']) {

			header('location: index.php');
		}
	}

	public static function contentCategoryNameSelect($category_id){

		$conn = new Connection();
		$sql = "SELECT name FROM content_type WHERE id = '$category_id'";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();

		return $row;
	}

	public static function contentCategorySelect($category_id){

		$conn = new Connection();
		$sql = "SELECT * FROM content WHERE available = 1 && type_id = $category_id ORDER BY last_update DESC";
		$result = $conn->getConnectionString()->query($sql);

		if ($result->num_rows == 0) {
			$_SESSION['content_category_message'] = "No content available :(";
		}
		else{
			$_SESSION['content_category_message'] = "";
		}

		return $result;
	}

	public static function contentCategoryToContent($content_id){

		setcookie('content_id', $content_id);
		header('location: content.php');
	}

	public static function contentToContentCategory($content_id){

		$conn = new Connection();
		$sql = "SELECT MAX(id), MIN(id) FROM content";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();

		if (empty($content_id) || $content_id > $row['MAX(id)'] || $content_id < $row['MIN(id)']) {
			
			header('location: content_category.php');
		}
	}

	public static function contentCheckInventory($content_id, $user_id){

		$conn = new Connection();
		$sql = "SELECT * FROM statistics WHERE content_id = '$content_id' && user_id = '$user_id'";
		$result = $conn->getConnectionString()->query($sql);

		return $result;
	}

	public static function revisitContent($revisit_id){

		$conn = new Connection();
		$sql = "SELECT id FROM content WHERE id = '$revisit_id'";
		$result = $conn->getConnectionString()->query($sql);
		$row = $result->fetch_assoc();

		setcookie('content_id', $row['id']);
		header('location: content.php');
	}

	public static function setCookiePath(){

		$full_path = realpath(dirname(__FILE__));
		$folder_array = explode('\\', $full_path);
		$last_folder = count($folder_array) - 1;
		$result_folder = $folder_array[$last_folder];

		return $result_folder;
	}
	
}