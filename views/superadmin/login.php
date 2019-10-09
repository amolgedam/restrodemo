<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - Zeon Restro</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/finalLogin/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/finalLogin/css/main.css">
<!--===============================================================================================-->
<style>
    .myPadding
    {
        padding: 85px 130px 33px 95px;
    }
    @media (max-width: 992px) {
      .wrap-login100 {
        padding: 177px 90px 33px 85px;
      }
      .login100-pic {
        width: 35%;
      }
    }
    
    @media (max-width: 768px) {
      .wrap-login100 {
        padding: 100px 80px 33px 80px;
      }
      .login100-pic {
        display: none;
      }
    }
    @media (max-width: 576px) {
      .wrap-login100 {
        padding: 100px 15px 33px 15px;
      }
    }
    
</style>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 myPadding">
				<div class="login100-pic js-tilt" data-tilt style=" margin-top:40px;">
					<img src="<?php echo base_url() ?>assets/images/companyimg/<?php echo "duresys.jpg" ?>" alt="Duresys">
				</div>

				<form action="<?php echo base_url('superadmin/login') ?>" method="post" class="login100-form validate-form">
					<span class="login100-form-title">
						Welcome to ZEON ERP
					</span>
					
					
					<span style="padding-left: 11px">
						<?php echo validation_errors(); ?>  

						<?php if(!empty($errors)) {
							echo $errors."<br>";
						} ?> 
					</span> 
				
					<div class="wrap-input100">
						<input class="input100" type="text" name="email" placeholder="Enter Username" required>
						<!-- <span class="focus-input100"></span> -->
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" id="password" placeholder="Enter Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" style="background-color:#1F618D">
							Login
						</button>
					</div>

										<div class="text-center p-t-12">
						<span class="txt1" style="font-size: 15px; color: black; padding-top: 5px">
							Powered by DURESYS TECHNOLOGIES
						</span>
					<!--	<a class="txt2" href="#">-->
					<!--		Username / Password?-->
					<!--	</a>-->
					</div>

					<!--	<div class="text-center p-t-136">
							<a class="txt2" href="#">
								Create your Account
								<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
							</a>
						</div>	-->
				</form> 
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?php echo base_url() ?>assets/finalLogin/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url() ?>assets/finalLogin/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url() ?>assets/finalLogin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url() ?>assets/finalLogin/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url() ?>assets/finalLogin/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?php echo base_url() ?>assets/finalLogin/js/main.js"></script>

</body>
</html>