<?php 

	$path = 'goodies/header.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
?>
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href="css/homepage.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Example Home Page</title>
</head>
<body>
<div class="products">
<?php

	$path = 'goodies/BagOfTricks.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
	showProducts();
		
?>
</div>
<div class="formComments">
	<form method="POST" action="">
		<label for="comment">Comment:</label>
		<input type="text" id="comment" name="comment">
		<?php
			$path = 'goodies/BagOfTricks.php';		
			if (  file_exists($path) ){
			   require_once($path);				
			}
			else{
			   echo 'Internal server error: please try again later (Code: 8).';
			   die();		
			}

			 if ( !empty($validationProducts) && is_string($validationProducts) ){
			echo $validationProducts;
		}

			postcomments();
			$validationComments = validateComments($_POST);
			if ( !empty($validationComments) && isset($validationComments['comment']) && !$validationComments['comment'][0] ){
				echo $_POST['comment'];
			}  	
		?>
		</input><br>
		<input type="submit" value="submit"><br></br></br>
		</form>
		<?php

			$path = 'goodies/BagOfTricks.php';		
			if (  file_exists($path) ){
			   require_once($path);				
			}
			else{
			   echo 'Internal server error: please try again later (Code: 8).';
			   die();		
			}
				
			showComments();
		?>
	</div>
</br>
</body>
</html>