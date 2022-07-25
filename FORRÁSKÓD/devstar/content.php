<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/navigation_class.php';
	use classes\Navigation;

	require_once 'classes/users_class.php';
	use classes\Users;

	if (isset($_COOKIE['content_id'])) {

		$row = Users::contentSelect($_COOKIE['content_id']);

		if (isset($_SESSION['level'])) {

			$result = Navigation::contentCheckInventory($_COOKIE['content_id'], $_SESSION['user_id']);
		}
	}

	Navigation::contentToContentCategory($_COOKIE['content_id']);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['go_to_inventory'])) {
			header('location: inventory.php');
		}

		if (isset($_POST['download'])) {

			if (isset($_SESSION['level'])) {

				Users::insertStatistics($_COOKIE['content_id'], $_SESSION['user_id'], $_POST['download']);
			}
			else{
				header("location: login.php");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $row['name']; ?> - Devstar</title>
	<?php include 'include/head.php'; ?>

	<script>
		function start_download(){
			window.open('<?php echo $row["content"]; ?>');
		}
	</script>
</head>
<body>
	<header>
		<?php include 'include/header.php'; ?>
	</header>
	
	<nav>
		<?php include 'include/navigation.php'; ?>
	</nav>
	<article>
		<div class="container-fluid container-xl p-0">
			<div class="content text-center pb-5 px-0 px-lg-5 col-xl-12 min-vh-100">
			<?php


				if ($row['type_id'] == 1) { // news ?>
					<div class="my-5 mx-3">
						<div class="col-12 col-md-9 content_button mx-auto">
							<div class="container">
								<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
								<div class="row">
									<h3 class="text-center text-dark col-12"><?php echo $row['name']; ?></h3>
								</div>
								<div class="row">
									<img class="rounded p-1 col-12" style="width: 300px; height: 180px" src="<?php echo $row['picture1'] ?>">
								</div>
								<div class="row">
									<textarea class="col-12 content_textarea" rows="5" cols="25" readonly="true"><?php echo $row['description']; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				else if($row['type_id'] == 2){ // games ?>
					<div class="my-5 mx-3">
						<div class="col-12 col-md-9 content_button mx-auto">
							<div class="container">
								<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
								<div class="row">
									<h3 class="text-center text-dark col-12"><?php echo $row['name']; ?></h3>
								</div>
								<div class="row">
									<img class="rounded p-1 col-6 offset-3 col-sm-4 offset-sm-0" style="max-width: 150px; height: 150px;" src="<?php echo $row['icon'] ?>">
									<textarea class="col-12 ml-sm-3 col-sm-8 col-lg-9 content_textarea" rows="5" cols="25" readonly="true"><?php echo $row['description']; ?></textarea>
								</div>
								<div class="row">
									<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture1'] ?>">
									<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture2'] ?>">
								</div>
								<div class="row">
									<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture3'] ?>">
									<img class="rounded p-1 col-12 col-sm-6" style="width: 300px;" src="<?php echo $row['picture4'] ?>">
								</div>
								<div class="row">
									<div class="col-12 text-center mt-3 text-white bg-dark p-3 rounded">
										<?php
										if (isset($_SESSION['level'])) {
											if ($result->num_rows != 0) { ?>
												<p class="m-0">This item is in your</p>
												<form method="post">
													<input class="btn btn-link" type="submit" name="go_to_inventory" value="Inventory">
												</form>
											<?php
											}
											else{ ?>
												<form method="post">
													<button onclick="start_download()" class="btn bg-primary text-white my-3" type="submit" name="download">Grab it for free</button>
												</form>
											<?php
											}
										}
										else{ ?>
											<form method="post">
												<button class="btn bg-primary text-white my-3" type="submit" name="download">Grab it for free</button>
											</form>
										<?php
										}			
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				else if($row['type_id'] == 3){ // script - asset ?>
					<div class="my-5 mx-3">
						<div class="col-12 col-md-9 content_button mx-auto">
							<div class="container">
								<input type="hidden" name="content_id" value="<?php echo $row['id']; ?>">
								<div class="row">
									<h3 class="text-center text-dark col-12"><?php echo $row['name']; ?></h3>
								</div>
								<div class="row">
									<img class="rounded p-1 col-6 offset-3 col-sm-3 offset-sm-0" style="width: 150px; height: 150px;" src="<?php echo $row['icon'] ?>">
									<textarea class="col-sm-9 content_textarea" rows="5" cols="25" readonly="true"><?php echo $row['description']; ?></textarea>
								</div>
								<div class="row">
									<div class="col-12 text-center mt-3 text-white bg-dark p-3 rounded">
										<?php
										if (isset($_SESSION['level'])) {
											if ($result->num_rows != 0) { ?>
												<p class="m-0">This item is in your</p>
												<form method="post">
													<input class="btn btn-link" type="submit" name="go_to_inventory" value="Inventory">
												</form>
											<?php
											}
											else{ ?>
												<form method="post">
													<button onclick="start_download()" class="btn bg-primary text-white my-3" type="submit" name="download">Grab it for free</button>
												</form>
											<?php
											}
										}
										else{ ?>
											<form method="post">
												<button class="btn bg-primary text-white my-3" type="submit" name="download">Grab it for free</button>
											</form>
										<?php
										}				
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}

				include("include/comment.php");
			?>
			</div>
		</div>
	</article>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>