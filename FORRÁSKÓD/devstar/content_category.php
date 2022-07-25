<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/navigation_class.php';
	use classes\Navigation;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		if (isset($_POST['content_id'])){

			Navigation::contentCategoryToContent($_POST['content_id']);
		}
	}
		
	Navigation::contentCategoryToMain($_COOKIE['category_id']);

	$row_name = Navigation::contentCategoryNameSelect($_COOKIE['category_id']);

	$result = Navigation::contentCategorySelect($_COOKIE['category_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $row_name['name']; ?> - Devstar</title>
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

			<div class="col-12 form-group">
				<h3 class="alert alert-link text-center"><?php echo($_SESSION['content_category_message']); ?></h3>
			</div>

			<?php
			while ($row = $result->fetch_assoc()) {
				if ($row['type_id'] == 1) { ?>
					<form method="post">
						<div class="my-5 mx-3">
							<button type="submit" class="col-12 col-md-9 content_button">
								<div class="container">
									<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
									<div class="row">
										<h3 class="text-center col-12"><?php echo $row['name']; ?></h3>
									</div>
									<div class="row">
										<img class="rounded p-1 col-12" style="width: 300px; height: 180px" src="<?php echo $row['picture1'] ?>">
									</div>
									<div class="row">
										<textarea class="col-12 content_textarea" rows="5" cols="25" readonly><?php echo $row['description']; ?></textarea>
									</div>
								</div>
							</button>
						</div>
					</form>
					<?php
				}
				else if ($row['type_id'] == 2) { ?>
					<form method="post">
						<div class="my-5 mx-3">
							<button type="submit" class="col-12 col-md-9 content_button">
								<div class="container">
									<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
									<div class="row">
										<h3 class="text-center col-12"><?php echo $row['name']; ?></h3>
									</div>
									<div class="row">
										<img class="rounded p-1 col-6 offset-3 col-sm-4 offset-sm-0" style="max-width: 150px; height: 150px;" src="<?php echo $row['icon'] ?>">
										<textarea class="col-12 ml-sm-3 col-sm-8 col-lg-9 content_textarea" rows="5" cols="25" readonly="true"><?php echo $row['description']; ?></textarea>
									</div>
									<div class="row">
										<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture1'] ?>">
										<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture2'] ?>">
									</div>
								</div>
							</button>
						</div>
					</form>
					<?php
				}
				else if ($row['type_id'] == 3) { ?>
					<form method="post">
						<div class="my-5 mx-3">
							<button type="submit" class="col-12 col-md-9 content_button">
								<div class="container">
									<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
									<div class="row">
										<h3 class="text-center col-12"><?php echo $row['name']; ?></h3>
									</div>
									<div class="row">
										<img class="rounded p-1 col-6 offset-3 col-sm-3 offset-sm-0" style="width: 150px; height: 150px;" src="<?php echo $row['icon'] ?>">
										<textarea class="col-sm-9 content_textarea" rows="5" cols="25" readonly="true"><?php echo $row['description']; ?></textarea>
									</div>
								</div>
							</button>
						</div>
					</form>
					<?php
				}
			} ?>
		</div>
	</div>
	</section>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>