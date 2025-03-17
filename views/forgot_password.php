<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/recovery_page.css">
	<link rel="icon" href="assets/icons/title-icon.ico" type="image/x-icon">
	<title>Recover Password</title>
</head>

<body>

	<section class="container border rounded-5 bg-white shadow">
		<header>Password Recovery</header>
		<small id="errorText"></small>
		<form method="post" class="form" id="reset">
			<div class="input-group mb-3">
				<input type="text" id="email" class="form-control form-control-lg bg-light fs-6"
					placeholder="Email address" required>
			</div>
			<div class="input-group mb-3">
				<button class="btn btn-lg btn-primary w-100 fs-6">Send Email</button>
			</div>
		</form>
		<div class="input-group mb-3">
			<a href="/login" style="width: 100%;">
				<button class="btn btn-lg btn-light w-100 fs-6">Back</button>
			</a>
		</div>
	</section>

</body>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/main.js"></script>

</html>