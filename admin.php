
<?php
	error_reporting (E_ALL ^ E_NOTICE); 

	include 'goodies/codes.php';
	// start session
	session_start();
	// check if username is admin
	if($_SESSION['tipo'] !== 'admin'){
		// isn't admin, redirect them to a different page
		echo '<h1>'.$codes[103].'</h1>';
		echo '<a href="Homepage.php">Home</a>';
	}else{
		echo '</br><a href="Homepage.php">Home</a>';
		echo '</br><a href="commentsForm.php">Delete Comments</a>';
	}

	
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="css/updateForm.css" rel="stylesheet">
</head>
<body>
<h1  style="color: white;">Admin page</h1>
</body>
</html> 

