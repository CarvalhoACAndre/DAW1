<!DOCTYPE html>
<html lang="en">
<head>
<title>WallMarket</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
</body>
</html> 
<?php
	/* This page is to be included in all pages. It may contain a navigation menu. The user must be checked to be authenticated or not and proceed accordingly.
	 */

	//check if a session is already started to avoid warnings.
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
   }
	
	if ( empty($_SESSION) || !array_key_exists('username', $_SESSION) || !isset($_SESSION['username']) ){
		//the user is not authenticated. This can be an error or a direct access. Send it back to the login page or see if this page can be seen without authorization.
		
		$path = 'goodies/ConfigApp.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
		
		//which is the script where the header is being included? Get the last position of the URL, remove the "." and the "php".
	   $scriptName = explode('/', $_SERVER['PHP_SELF']);
	   $scriptName = (explode('.', $scriptName[sizeof($scriptName)-1]))[0];
	   
	   // is it on the no authentication required list available on ConfigApp.php?
	   if( in_array( $scriptName, $pages )){
	   	//allow the user to navigate here - present the simple menu
	   	echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">
				  <div class="container-fluid">
					<a class="navbar-brand" href="#">Wallmarket</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
					  <ul class="navbar-nav">
						<li class="nav-item">
						  <a class="nav-link active" aria-current="page" href="index.php">Home</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="loginForm.php">Login</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link" href="registerForm.php">Register</a>
						</li>
					  </ul>
					</div>
				  </div>
				</nav>';
			
	   }
	   else{	
			//set the error to display in the login form
			$_SESSION['code'] = 101;
		
			//send the user away
			header('Location:loginForm.php');
			die();
		}
	}//end main if
	else{
		//the user is authenticated. Show the full menu. We can later differentiate between user types and show different menus
		//allow the user to navigate here - present the full menu
		if($_SESSION['tipo'] == 'admin'){
			echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">
				<div class="container-fluid">
				<a class="navbar-brand" href="#">HELLO '.$_SESSION['username'].' !</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
				  <ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link active" aria-current="page" href="Homepage.php">Home</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="updateForm.php">Update</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="logout.php">LogOut</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="uploadProducts.php">Insert Product</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="commentsForm.php">Delete Comments</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="admin.php">Admin</a>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>';
			echo '<br><br>';
		
		}else{
			echo '<nav class="navbar navbar-expand-lg bg-body-tertiary">
				<div class="container-fluid">
				<a class="navbar-brand" href="#">HELLO '.$_SESSION['username'].' !</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
				  <ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link active" aria-current="page" href="Homepage.php">Home</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="updateForm.php">Update</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="logout.php">LogOut</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="Products.php">Insert Product</a>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>';
			echo '<br><br>';
		}
		
	}	
?>