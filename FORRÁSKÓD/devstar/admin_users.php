<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/admin_class.php';
	use classes\Admin;

	if ($_SESSION['level'] == 5) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if (isset($_POST['update'])) {

				Admin::updateUserLevel($_POST['level'], $_POST['user_id']);
			}
		}
	}
	else{
		header('location: index.php');
	}

	$result = Admin::selectUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Users - Devstar</title>
	<?php include 'include/head.php'; ?>
</head>
<body>
	<header>
		<?php include 'include/header.php'; ?>
	</header>

	<nav>
		<?php include 'include/navigation.php'; ?>
	</nav>
	<div class="container-fluid container-xl p-0">
		<div class="content text-center px-0 px-lg-5 col-xl-12 min-vh-100">

	<?php
	if ($result->num_rows != 0) { ?>
		
		<table class="table table-bordered table-responsive-sm text-center text-nowrap table-dark mt-5">
			<thead>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Registration date</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>
			<?php
		while ($row = $result->fetch_assoc()) { ?>
				<form method="post" action="#" autocomplete="off">
					<input type="hidden" name="user_id" value="<?php echo $row['id'] ?>">
					<tr>
						<td class="align-middle">
							<?php echo $row['username'] ?>
						</td>
						<td class="align-middle">
							<?php echo $row['email'] ?>
						</td>
						<td class="align-middle">
							<?php echo $row['registration_date']; ?>
						</td>
						<td class="align-middle">
							<?php 
							if ($row['id'] == $_SESSION['user_id']) {
								echo $row['level'];
							}
							else{ ?>
								<input type="number" name="level" min="1" max="5" value="<?php echo $row['level'] ?>">
							<?php
							} ?>
						</td>
						
							<?php 
							if ($row['id'] != $_SESSION['user_id']) { ?>
								<td class="align-middle">
							 		<input class="btn btn-success text-white" type="submit" name="update" value="Update">
							 	</td>
							<?php
							} ?>
						
					</tr>
				</form>
			<?php
		} ?>
			</tbody>
		</table>
		<?php
	} ?>
		</div>
	</div>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>