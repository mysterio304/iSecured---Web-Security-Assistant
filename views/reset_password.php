<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/recovery_page.css">
	<link rel="icon" href="assets/icons/title-icon.ico" type="image/x-icon">
	<title>Password Reset</title>
</head>

<body>

	<section class="container border rounded-5 bg-white shadow">
		<header>Password Reset</header>
		<small id="errorText"></small>
		<form method="post" class="form" id="updatePassword">
			<div class="input-group mb-3">
				<input type="password" id="password" class="form-control form-control-lg bg-light fs-6"
					placeholder="New Password" required>
			</div>
			<div class="input-group mb-3">
				<input type="password" id="confPassword" class="form-control form-control-lg bg-light fs-6"
					placeholder="Confirm New Password" required>
			</div>
			<div class="input-group mb-3">
				<button class="btn btn-lg btn-primary w-100 fs-6">Reset</button>
			</div>
		</form>
		<div class="row update-success-block" style="display: none;">
			<small>Password was successfully updated. <a href="/login">Go to login</a></small>
		</div>
	</section>

</body>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/main.js"></script>

</html>