<?php 

	require_once 'classes/users_class.php';
	use classes\Users;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['comment'])) {

			if (isset($_POST['send_comment'])) {
			
				Users::writeComment($_COOKIE['content_id'], $_SESSION['user_id'], Users::testInput($_POST['comment']));
			}
		}
	}
?>

<script>
	$(document).ready(function(){

    	$('.send_comment').prop('disabled',true);

	    	$('textarea').keyup(function(){

	        if($(this).val().trim().length != 0){
	            $('.send_comment').prop('disabled', false);
	        }
	        else{
	            $('.send_comment').prop('disabled', true);
	        }
	    })

	    $('textarea').each(function() {
	        $(this).height($(this).prop('scrollHeight'));
	    });

	});

	function auto_grow(element) {
		element.style.height = "5px";
		element.style.height = (element.scrollHeight)+"px";
	}
</script>

	<div class="container">
		<div class="my-5 px-3 px-md-0">
			<form method="post">
			<div class="row">
				<?php 
				if (empty($_SESSION['level'])) { ?>
					<textarea onclick="location.href='login.php'" class="col-md-8 offset-md-2 comment_textarea_write" rows="3" placeholder="Write a comment..."></textarea>
				<?php
				}
				else{ ?>
					<textarea oninput="auto_grow(this)" class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 comment_textarea_write" maxlength="500" minlength="1" name="comment" placeholder="Write a comment..."></textarea>
				<?php
				} ?>
			</div>
			<div class="row mx-2">
				<button class="offset-9 offset-sm-10 offset-md-9 mt-3 btn btn-secondary send_comment" type="submit" name="send_comment">Comment</button>
			</div>
			</form>
		</div>
	</div>

	<div class="my-3 px-3 px-md-0">
	<?php
	$result = Users::selectComments($_COOKIE['content_id']);

	if ($result->num_rows != 0) {

		while ($row = $result->fetch_assoc()) { ?>
			<div class="container">
				<div class="row mt-5 mb-3">
					<img class="offset-md-2 profile_picture" src="<?php echo $row['avatar'] ?>" />
					<span class="mx-2"><?php echo $row['username']; ?></span>
				</div>
				<div class="row">
					<textarea class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 comment_textarea_show" readonly><?php echo $row['comment_text']; ?></textarea>
				</div>
			</div>
		<?php
		}
	} ?>
	</div>