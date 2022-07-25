<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/users_class.php';
	use classes\Users;

	require_once 'classes/navigation_class.php';
	use classes\Navigation;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['revisit'])) {

			Navigation::revisitContent($_POST['revisit_id']);
		}

		if (isset($_POST['redownload'])) {

			$row2 = Users::redownloadContent($_POST['redownload_id']);

			header('location: ' . $row2['content']);
			
			Users::insertStatistics($_POST['redownload_id'], $_SESSION['user_id'], $_POST['redownload']);		
		}
	}

	$result = Users::selectInventoryItems($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Inventory - Devstar</title>
	<?php include 'include/head.php'; ?>
</head>
<body>
	<?php
		if (isset($_SESSION['level'])) {?>
		<header>
			<?php include 'include/header.php'; ?>
		</header>
		<nav>
			<?php include 'include/navigation.php'; ?>
		</nav>
		<div class="container-fluid container-xl p-0">
			<div class="content text-center px-0 px-lg-5 col-xl-12 min-vh-100">
				<table class="table table-striped table-responsive-md text-nowrap text-center table-dark mt-5">
				<tbody>
				<?php
				if ($result->num_rows != 0) {
					while ($row = $result->fetch_assoc()) { ?>
						<tr>
							<td class="align-middle"><p>Download date:<br><?php echo $row['download_date'] ?></p></td>
							<td class="align-middle"><img width="50px" height="50px" src="<?php echo $row['icon'] ?>"></td>
							<td class="align-middle">
								<form method="post">
									<input type="hidden" name="revisit_id" value="<?php echo $row['id'] ?>">
									<input class="btn btn-link" type="submit" name="revisit" value="<?php echo $row['name'] ?>">
								</form>
							</td>
							<td class="align-middle"><p>Last update:<br><?php echo $row['last_update'] ?></p></td>
							<td class="align-middle">
								<form method="post">
									<input type="hidden" name="redownload_id" value="<?php echo $row['id'] ?>">
									<?php 
									if ($row['update_req'] == 'update') { ?>
									<button class="btn btn-secondary" type="submit" name="redownload">Download newer version</button>
									<?php
									}
									else{ ?>
									<button class="btn btn-secondary" type="submit" name="redownload">Download current version</button>
									<?php
									}
									?>
								</form>
							</td>
						</tr>
						<?php
					}
				}
				else{ ?>
					<tr>
						<td><?php echo "Your inventory is empty :("; ?></td>
					</tr>
				<?php
				}

				?>
				</tbody>
				</table>
			</div>
		</div>
		<?php
		}
		else{
			header('location: login.php');
		} ?>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>