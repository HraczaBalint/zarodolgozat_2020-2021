<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/navigation_class.php';
	use classes\Navigation;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if (isset($_POST['category_id'])) {
			
			Navigation::mainToContentCategory($_POST['category_id']);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home - Devstar</title>
	<?php include 'include/head.php'; ?>
</head>
<body>
	<header>
		<?php include 'include/header.php'; ?>
	</header>

	<nav>
	<?php include 'include/navigation.php'; ?>
	</nav>
	<section>
	<div class="container-fluid container-xl p-0">
		<div class="content text-center px-0 px-lg-5 col-xl-12 min-vh-100">
		<div class="d-flex align-items-center min-vh-100">
		<div class="container p-0">

		<?php 
		if (isset($_SESSION['level']) && empty($_COOKIE['category_id']) && empty($_COOKIE['type_id'])) { ?>
			<div class="col-12 form-group">
				<h3 class="alert alert-link text-center"><?php echo "Welcome back, " . $_SESSION['username'] . "!"; ?></h3>
			</div>
		<?php 
		}
		
		foreach (Navigation::mainSelect() as $row) { ?>
			<form method="post">
				<button type="submit" class="m-3 col-10 col-lg-6 content_button" style="background-image: url(<?php echo $row['background_image'] ?>);">
					<input type="hidden" name="category_id" value="<?php echo $row['id'] ?>">
					<div class="m-0">
						<h2 style="color: white"><?php echo $row['name'] ?></h2>
						<img src="<?php echo $row['icon'] ?>" style="height: 130px;">
					</div>
				</button>
			</form>
		<?php 
		}
		?>
		
		</div>
		</div>
		</div>
	</div>
	</section>
	
	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>