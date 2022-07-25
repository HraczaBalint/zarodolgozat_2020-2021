<?php 
	header('Content-type: text/html; charset=utf-8');
	session_start();

	require_once 'classes/admin_class.php';
	use classes\Admin;

	require_once 'classes/users_class.php';
	use classes\Users;

	if ($_SESSION['level'] == 5) {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if (isset($_POST['insert'])) {

				if (isset($_FILES['icon']['name'])) {
					$icon_isset = Admin::checkPicture('pictures/content_image/' . $_FILES['icon']['name'], $_FILES['icon']['type'], $_FILES['icon']['tmp_name']);
				}else{$icon_isset = false;}

				if (isset($_FILES['picture1']['name'])) {
					$picture1_isset = Admin::checkPicture('pictures/content_image/' . $_FILES['picture1']['name'], $_FILES['picture1']['type'], $_FILES['picture1']['tmp_name']);
				}else{$picture1_isset = false;}

				if (isset($_FILES['picture2']['name'])) {
					$picture2_isset = Admin::checkPicture('pictures/content_image/' . $_FILES['picture2']['name'], $_FILES['picture2']['type'], $_FILES['picture2']['tmp_name']);
				}else{$picture2_isset = false;}

				if (isset($_FILES['picture3']['name'])) {
					$picture3_isset = Admin::checkPicture('pictures/content_image/' . $_FILES['picture3']['name'], $_FILES['picture3']['type'], $_FILES['picture3']['tmp_name']);
				}else{$picture3_isset = false;}

				if (isset($_FILES['picture4']['name'])) {
					$picture4_isset = Admin::checkPicture('pictures/content_image/' . $_FILES['picture4']['name'], $_FILES['picture4']['type'], $_FILES['picture4']['tmp_name']);
				}else{$picture4_isset = false;}

				$name_isset = Admin::checkText('name', Users::testInput($_POST['name']), 2);

				$description_isset = Admin::checkText('description', Users::testInput($_POST['description']), 10);

				if (isset($_POST['content_text'])) {
					$content_isset = Admin::checkText('file', Users::testInput($_POST['content_text']), 3);
				}else{$content_isset = false;}

				if ($icon_isset && $picture1_isset && $picture2_isset && $picture3_isset && $picture4_isset && $name_isset && $description_isset && $content_isset) {

					$games_insert_result = Admin::insertGames($_COOKIE['type_id'], Users::testInput($_POST['name']), 'pictures/content_image/' . $_FILES['icon']['name'], 'pictures/content_image/' . $_FILES['picture1']['name'], 'pictures/content_image/' . $_FILES['picture2']['name'], 'pictures/content_image/' . $_FILES['picture3']['name'], 'pictures/content_image/' . $_FILES['picture4']['name'], Users::testInput($_POST['description']), Users::testInput($_POST['content_text']));
				}
				else if($name_isset && $icon_isset && $description_isset && $content_isset){

					$assets_insert_result = Admin::insertAssets($_COOKIE['type_id'], Users::testInput($_POST['name']), 'pictures/content_image/' . $_FILES['icon']['name'], Users::testInput($_POST['description']), Users::testInput($_POST['content_text']));
				}
				else if ($picture1_isset && $name_isset && $description_isset) {
					
					$news_insert_result = Admin::insertNews($_COOKIE['type_id'], Users::testInput($_POST['name']), 'pictures/content_image/' . $_FILES['picture1']['name'], Users::testInput($_POST['description']));					
				}
			}

			if (isset($_POST['delete'])) {
					
				Admin::contentDelete($_POST['content_id']);
			}

			if (isset($_POST['update'])) {

				if (isset($_FILES['icon']['name'])) {
					Admin::updatePicture('icon','pictures/content_image/' . $_FILES['icon']['name'], $_FILES['icon']['type'], $_FILES['icon']['tmp_name'], $_POST['content_id']);
				}

				if (isset($_FILES['picture1']['name'])) {
					Admin::updatePicture('picture1','pictures/content_image/' . $_FILES['picture1']['name'], $_FILES['picture1']['type'], $_FILES['picture1']['tmp_name'], $_POST['content_id']);
				}

				if (isset($_FILES['picture2']['name'])) {
					Admin::updatePicture('picture2','pictures/content_image/' . $_FILES['picture2']['name'], $_FILES['picture2']['type'], $_FILES['picture2']['tmp_name'], $_POST['content_id']);
				}

				if (isset($_FILES['picture3']['name'])) {
					Admin::updatePicture('picture3','pictures/content_image/' . $_FILES['picture3']['name'], $_FILES['picture3']['type'], $_FILES['picture3']['tmp_name'], $_POST['content_id']);
				}

				if (isset($_FILES['picture4']['name'])) {
					Admin::updatePicture('picture4','pictures/content_image/' . $_FILES['picture4']['name'], $_FILES['picture4']['type'], $_FILES['picture4']['tmp_name'], $_POST['content_id']);
				}

				if (isset($_POST['name'])) {
					Admin::updateText('name', Users::testInput($_POST['name']), $_POST['content_id'], 2);
				}
				
				if (isset($_POST['description'])) {
					Admin::updateText('description', Users::testInput($_POST['description']), $_POST['content_id'], 10);
				}

				if (isset($_POST['content_text'])) {
					Admin::updateText('content', 'contents/' . Users::testInput($_POST['content_text']), $_POST['content_id'], 3);
				}

				if (isset($_POST['available'])) {
					Admin::updateVisibility($_POST['available'], $_POST['content_id']);
				}
				else{
					Admin::updateVisibility(0, $_POST['content_id']);
				}
			}

			if (isset($_POST['name'])) {
				$name = $_POST['name'];
			}

			if (isset($_POST['description'])) {
				$description = $_POST['description'];
			}

			if (isset($_POST['content_text'])) {
				$content = $_POST['content_text'];
			}
		}
		else{
			$_SESSION['message_insert'] = "";
			$_SESSION['message_update'] = "";
			$name = "";
			$description = "";
			$content = "";
		}

		$type_result = Admin::contentTypeSelect();
	}
	else{
		header('location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contents - Devstar</title>
	<?php include 'include/head.php'; ?>

  	<script>
		function selectContentTypeId() {
			var content_type_id = document.getElementById("content_types").value;
			Cookies.set('type_id', content_type_id, { path: '/' });

			location.reload();
		}

		function confirmDelete() {
			return confirm('This is irreversible. Are you sure?');
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
	<div class="container-fluid container-xl p-0">
		<div class="content text-center px-0 px-lg-5 col-xl-12 min-vh-100">

		<h5>Select a displayable content type</h5>
		<div class="col-12 form-group">
			<div class="alert alert-link text-center"><?php echo($_SESSION['message_update']); ?></div>
		</div>
		<select id="content_types" onchange="selectContentTypeId()">
			<option value="valassz">---Choose---</option>
			<?php 
				while ($row = $type_result->fetch_assoc()) { ?>
					<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
				<?php
				}
			?>
		</select>

		<?php
		if (isset($_COOKIE['type_id'])) {

			$content_select_result = Admin::contentSelect($_COOKIE['type_id']);

			if ($_COOKIE['type_id'] == 1) {
				if ($content_select_result->num_rows != 0) { ?>

					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<tr>
								<th>Name</th>
								<th>Picture1</th>
								<th>Description</th>
								<th>Last update</th>
								<th>Available</th>
							</tr>
						</thead>
						<tbody>
					<?php
					while ($row1 = $content_select_result->fetch_assoc()) { ?>
							<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
								<input type="hidden" name="content_id" value="<?php echo $row1['id'] ?>">
								<tr>
									<td class="align-middle">
										<input type="text" name="name" minlength="2" value="<?php echo $row1['name'] ?>">
									</td>
									<td class="align-middle">
										<img style="width: 70px; height: 50px" name="picture1" src="<?php echo $row1['picture1'] ?>"><br />
										<input type="file" name="picture1" accept="image/*">
									</td>
									<td class="align-middle">
										<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description"><?php echo $row1['description'] ?></textarea>
									</td>
									<td class="align-middle">
										<input type="hidden" name="last_update" value="<?php echo $row1['DATE(last_update)'] ?>">
										<?php echo $row1['DATE(last_update)'] ?>
									</td>
									<td class="align-middle">
										<input type="checkbox" name="available" value="1" <?php echo ($row1['available'] == 1 ? 'checked' : '')?>>
									</td>
									<td class="align-middle">
										<input class="btn btn-success text-white" type="submit" name="update" value="Update">
									</td>
									<td class="align-middle">
										<input class="btn btn-danger text-white" type="submit" name="delete" value="Delete" onclick="return confirmDelete()">
									</td>
								</tr>
							</form>
					<?php
					} ?>
						</tbody>
					</table>
				<?php
				} ?>

				<h5 class="mt-5">Or insert a new one</h5>

			    <div class="col-12 form-group">
			        <div class="alert alert-link text-center"><?php echo($_SESSION['message_insert']); ?></div>
			    </div>

				<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<th>Name</th>
							<th>Picture1</th>
							<th>Description</th>
						</thead>
						<tbody>
							<td class="align-middle">
								<input type="text" name="name" minlength="2" value="<?php echo $name ?>" required>
							</td>
							<td class="align-middle">
								<input type="file" name="picture1" accept="image/*" required>
							</td>
							<td class="align-middle">
								<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description" required><?php echo $description ?></textarea>
							</td>
							<td class="align-middle">
								<input class="btn btn-primary text-white" type="submit" name="insert" value="Insert">
							</td>
						</tbody>
					</table>
				</form>
				<?php
			}

			if ($_COOKIE['type_id'] == 2) {
				if ($content_select_result->num_rows != 0) { ?>
				
					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<tr>
								<th>Name</th>
								<th>Icon</th>
								<th>Picture1</th>
								<th>Picture2</th>
								<th>Pciture3</th>
								<th>Picture4</th>
								<th>Description</th>
								<th>Content</th>
								<th>Last update</th>
								<th>Available</th>
							</tr>
						</thead>
						<tbody>
					<?php
					while ($row1 = $content_select_result->fetch_assoc()) { ?>
							<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
								<input type="hidden" name="content_id" value="<?php echo $row1['id'] ?>">
								<tr>
									<td class="align-middle">
										<input type="text" name="name" minlength="2" value="<?php echo $row1['name'] ?>">
									</td>
									<td class="align-middle">
										<img style="width: 50px; height: 50px" name="icon" src="<?php echo $row1['icon'] ?>">
										<input type="file" name="icon" accept="image/*">
									</td>
									<td class="align-middle">
										<img style="width: 70px; height: 50px" name="picture1" src="<?php echo $row1['picture1'] ?>">
										<input type="file" name="picture1" accept="image/*">
									</td>
									<td class="align-middle">
										<img style="width: 70px; height: 50px" name="picture2" src="<?php echo $row1['picture2'] ?>">
										<input type="file" name="picture2" accept="image/*">
									</td>
									<td class="align-middle">
										<img style="width: 70px; height: 50px" name="picture3" src="<?php echo $row1['picture3'] ?>">
										<input type="file" name="picture3" accept="image/*">
									</td>
									<td class="align-middle">
										<img style="width: 70px; height: 50px" name="picture4" src="<?php echo $row1['picture4'] ?>">
										<input type="file" name="picture4" accept="image/*">
									</td>
									<td class="align-middle">
										<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description"><?php echo $row1['description'] ?></textarea>
									</td>
									<td class="align-middle">
										<a href="<?php echo $row1['content'] ?>" download><p><?php echo basename($row1['content']) ?></p></a>
										<span>contents/ </span><input type="text" name="content_text" value="<?php echo basename($row1['content']) ?>">
									</td>
									<td class="align-middle">
										<input type="hidden" name="last_update" value="<?php echo $row1['DATE(last_update)'] ?>">
										<?php echo $row1['DATE(last_update)'] ?>
									</td>
									<td class="align-middle">
										<input type="checkbox" name="available" value="1" <?php echo ($row1['available'] == 1 ? 'checked' : '')?>>
									</td>
									<td class="align-middle">
										<input class="btn btn-success text-white" type="submit" name="update" value="Update">
									</td>
									<td class="align-middle">
										<input class="btn btn-danger text-white" type="submit" name="delete" value="Delete" onclick="return confirmDelete()">
									</td>
								</tr>
							</form>
					<?php
					} ?>
						</tbody>
					</table>
				<?php
				} ?>

				<h5 class="mt-5">Or insert a new one</h5>

			    <div class="col-12 form-group">
			        <div class="alert alert-link text-center"><?php echo($_SESSION['message_insert']); ?></div>
			    </div>

				<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<th>Name</th>
							<th>Icon</th>
							<th>Picture1</th>
							<th>Picture2</th>
							<th>Picture3</th>
							<th>Picture4</th>
							<th>Description</th>
							<th>Content</th>
						</thead>
						<tbody>
							<td class="align-middle">
								<input type="text" name="name" minlength="2" value="<?php echo $name ?>" required>
							</td>
							<td class="align-middle">
								<input type="file" name="icon" accept="image/*" required>
							</td>
							<td class="align-middle">
								<input type="file" name="picture1" accept="image/*" required>
							</td>
							<td class="align-middle">
								<input type="file" name="picture2" accept="image/*" required>
							</td>
							<td class="align-middle">
								<input type="file" name="picture3" accept="image/*" required>
							</td>
							<td class="align-middle">
								<input type="file" name="picture4" accept="image/*" required>
							</td>
							<td class="align-middle">
								<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description" required><?php echo $description ?></textarea>
							</td>
							<td class="align-middle">
								<span>contents/ </span><input type="text" name="content_text" value="<?php echo $content ?>" required>
							</td>				
							<td class="align-middle">
								<input class="btn btn-primary text-white" type="submit" name="insert" value="Insert">
							</td>
						</tbody>
					</table>
				</form>
				<?php
			}
			
			if ($_COOKIE['type_id'] == 3) {
				if ($content_select_result->num_rows != 0) { ?>
				
					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<tr>
								<th>Name</th>
								<th>Icon</th>
								<th>Description</th>
								<th>Content</th>
								<th>Last update</th>
								<th>Available</th>
							</tr>
						</thead>
						<tbody>
					<?php
					while ($row1 = $content_select_result->fetch_assoc()) { ?>
							<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
								<input type="hidden" name="content_id" value="<?php echo $row1['id'] ?>">
								<tr>
									<td class="align-middle">
										<input type="text" name="name" minlength="2" value="<?php echo $row1['name'] ?>">
									</td>
									<td class="align-middle">
										<img style="width: 50px; height: 50px" name="icon" src="<?php echo $row1['icon'] ?>"><br />
										<input type="file" name="icon" accept="image/*">
									</td>
									<td class="align-middle">
										<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description"><?php echo $row1['description'] ?></textarea>
									</td>
									<td class="align-middle">
										<a href="<?php echo $row1['content'] ?>" download><p><?php echo basename($row1['content']) ?></p></a>
										<span>contents/ </span><input type="text" name="content_text" value="<?php echo basename($row1['content']) ?>">
									</td>
									<td class="align-middle">
										<input type="hidden" name="last_update" value="<?php echo $row1['DATE(last_update)'] ?>">
										<?php echo $row1['DATE(last_update)'] ?>
									</td>
									<td class="align-middle">
										<input type="checkbox" name="available" value="1" <?php echo ($row1['available'] == 1 ? 'checked' : '')?>>
									</td>
									<td class="align-middle">
										<input class="btn btn-success text-white" type="submit" name="update" value="Update">
									</td>
									<td class="align-middle">
										<input class="btn btn-danger text-white" type="submit" name="delete" value="Delete" onclick="return confirmDelete()">
									</td>
								</tr>
							</form>
					<?php
					} ?>
						</tbody>
					</table>
				<?php
				} ?>

				<h5 class="mt-5">Or insert a new one</h5>

			    <div class="col-12 form-group">
			        <div class="alert alert-link text-center"><?php echo($_SESSION['message_insert']); ?></div>
			    </div>

				<form method="post" action="#" autocomplete="off" enctype="multipart/form-data">
					<table class="table table-bordered table-responsive text-center text-nowrap table-dark mt-5">
						<thead>
							<th>Name</th>
							<th>Icon</th>
							<th>Description</th>
							<th>Content</th>
						</thead>
						<tbody>
							<td class="align-middle">
								<input type="text" name="name" minlength="2" value="<?php echo $name ?>" required>
							</td>
							<td class="align-middle">
								<input type="file" name="icon" accept="image/*" required>
							</td>
							<td class="align-middle">
								<textarea rows="5" cols="25" minlength="10" maxlength="250" name="description" required><?php echo $description ?></textarea>
							</td>
							<td class="align-middle">
								<span>contents/ </span><input type="text" name="content_text" value="<?php echo $content ?>" required>
							</td>
							<td class="align-middle">
								<input class="btn btn-primary text-white" type="submit" name="insert" value="Insert">
							</td>
						</tbody>
					</table>
				</form>
				<?php
			}
		}?>
		</div>
	</div>

	<footer>
		<?php include 'include/footer.php'; ?>
	</footer>
</body>
</html>