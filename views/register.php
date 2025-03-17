<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="ToDo App">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/style.css">
	<link rel="icon" href="assets/icons/title-icon.ico" type="image/x-icon">
	<title>Sign Up</title>
</head>
<body>
	
	<div class="container d-flex justify-content-center align-items-center min-vh-100">
		<div class="row border rounded-5 p-3 bg-white shadow box-area">
			<!-- Left box -->
			<div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-color: #103cbe;">
				<div class="featured-image mb-3">
					<img src="assets/images/register-box-image.png" alt="Register Image" class="img-fluid" style="width: 250px;">
				</div>
				<p class="text-white fs-2 text-center" style="font-weight: 600;">Join the Security Revolution!</p>
				<small class="text-white text-wrap text-center" style="width: 17rem;">Create an account to generate strong passwords, detect scams, and keep your online presence safe. Because security isn’t an option—it’s a necessity!</small>
			</div>


			<!-- Right box -->
			<div class="col-md-6 right-box">
				<div class="row align-items-center">
					<div class="header-text mb-3">
						<h2>Sign Up</h2>
					</div>
					<div class="mb-1">
						<small id="errorText"></small>
					</div>
					<form id="register" method="post">
						<div class="input-group mb-3">
							<input type="text" id="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address" required>
						</div>
						<div class="input-group mb-3">
							<input type="password" id="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
						</div>
						<div class="input-group mb-3">
							<input type="password" id="confirmPassword" class="form-control form-control-lg bg-light fs-6" placeholder="Confirm Password" required>
						</div>
						<div class="input-group mb-3">
							<button class="btn btn-lg btn-primary w-100 fs-6">Sign Up</button>
						</div>
						<div class="input-group mb-3">
							<button class="btn btn-lg btn-light w-100 fs-6"><img src="assets/images/google.png" alt="Google" style="width: 20px;" class="me-2">
								<small>Sign Up with Google</small>
							</button>
						</div>
					</form>
					<div class="row">
						<small>Have an account? <a href="login">Sign In</a></small>
					</div>
				</div>
		  </div>
		</div>
	</div>

</body>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/main.js"></script>
</html>