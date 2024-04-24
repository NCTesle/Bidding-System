<?php session_start() ?>
<?php
$name = $contact = $email = $address = $username = $name_err = $emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $address = test_input($_POST["address"]);
  $username = test_input($_POST["username"]);
  $error = false;
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
	$name_err = "Only letters and white space allowed";
	$error = true;
  }
  $email = test_input($_POST["email"]);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$emailErr = "Invalid email format";
  }
  $contact = test_input($_POST["contact"]);
  if (strlen($inputField) > 10) {
	$inputField = substr($inputField, 0, 10);
}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign-in</title>

</head>
<body>
<div class="container-fluid">
	<form action="" id="signup-frm">
		<div class="form-group">
			<label for="" class="control-label">Name</label>
			<input type="text" name="name" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Contact</label>
			<input type="tel" name="contact"  pattern="[0-9]{10}" class="form-control"  oninput="limitInputLength(this, 10)" required>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Address</label>
			<textarea cols="30" rows="3" name="address" required="" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" name="email" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Username</label>
			<input type="text" name="username" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="password" name="password" required="" class="form-control">
		</div>
		<button class="button btn btn-primary btn-sm">Create</button>
		<button class="button btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>

	</form>
</div>
	
</body>
</html>


<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<script>
        function limitInputLength(input, maxLength) {
            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength);
            }
        }
   

	$('#signup-frm').submit(function(e){
		e.preventDefault()
		start_load()
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'admin/ajax.php?action=signup',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');

			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					$('#signup-frm').prepend('<div class="alert alert-danger">Email already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>
