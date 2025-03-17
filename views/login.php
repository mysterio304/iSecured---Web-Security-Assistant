<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/style.css">
	<link rel="icon" href="assets/icons/title-icon.ico" type="image/x-icon">
	<title>Sign In</title>
</head>
<body>
	<div class="container d-flex justify-content-center align-items-center min-vh-100">
		
		<div class="row border rounded-5 p-3 bg-white shadow box-area">



			<!-- Left box -->
			 <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-color: #103cbe;">
				<div class="featured-image mb-3">
					<img src="assets/images/login-box-image.png" alt="Register Image" class="img-fluid" style="width: 250px;">
				</div>
				<p class="text-white fs-2 text-center" style="font-weight: 600;">Stay Secure, Stay Smart!</p>
				<small class="text-white text-wrap text-center" style="width: 17rem;">Log in to protect yourself from phishing scams, AI fraud, and weak passwords. Your digital safety starts here!</small>
			 </div>

			 <!-- Right box -->
			  <div class="col-md-6 right-box">
					<div class="row align-items-center">
						<div class="header-text mb-3">
							<h2>Sign In</h2>
						</div>
						<div class="mb-1">
							<small id="errorText"></small>
						</div>
						<form id="login" method="post">
							<div class="input-group mb-3">
								<input type="text" id="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email address" required>
							</div>
							<div class="input-group mb-1">
								<input type="password" id="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
							</div>
							<div class="input-group mb-5 d-flex justify-content-between">
								<div class="form-check">
									<input type="checkbox" id="rememberMe" class="form-check-input">
									<label for="rememberMe" class="form-check-label text-secondary"><small>Remember Me</small></label>
								</div>
								<div class="forgot">
									<small><a href="forgot_password">Forgot Password?</a></small>
								</div>
							</div>
							<div class="input-group mb-3">
								<button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
							</div>
						</form>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-light w-100 fs-6" id="googleLogin"><img src="assets/images/google.png" alt="Google" style="width: 20px;" class="me-2">
                                <small>Sign In with Google</small>
                            </button>
                        </div>
						<div class="row">
							<small>Don't have an account? <a href="register">Sign Up</a></small>
						</div>
					</div>
			  </div>
		</div>

	</div>
</body>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/main.js"></script>
</html>