<?php
   //check for authentication information and potential navigation menu
	$path = 'goodies/header.php';		
	if (  file_exists($path) ){
	   require_once($path);				
	}
	else{
	   echo 'Internal server error: please try again later (Code: 8).';
	   die();		
	}
	
	if ( !empty($_POST) ){ #Code execution only enters the if after a first form submission (with or without data in the form fields).
		
		/* Let's include the validation function - BagOfTtricks.php - 
		 * so that it can be used in this process.	
	   */
	   # this file is in a folder - "goodies". Therefore, it needs to be included in the path.
	   $path = 'goodies/BagOfTricks.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
		 	
		/* Form' fields validation is dealt with by a function designed for each different form and implemented in the BagOfTricks.php file.
		 * That function will return an array if any field has content that is not compliant with the established rules or a true value if 
		 * no errors are detected.
		 * It accepts, as a parameter, all the data that the user submitted via form, which is nicely packaged in $_POST.
	   */
	   
		$validationResult = validateLoginForm ($_POST);
		
		//check if there were errors in filling out the form by checking the value in the $validationResult variable. 
		if ( ! is_array($validationResult) && ! is_string($validationResult) ){
			/* no errors were present in the form. Proceed to insert the new user in the "users" table from "aulas" database. The latter
			 * can be accessed via browser, using http://localhost/adminer. Table "users" will be created in class. All the database
			 * related processes are implemented in the DatabaseManager.php file. As such, it must be included.
		    */ 			
			$path = 'goodies/DatabaseManager.php';		
		   if (  file_exists($path) ){
				 require_once($path);				
		   }
		   else{
			   echo 'Internal server error: please try again later (Code: 11).';
			   die();		
		   }
			
			// establish a connection to the database by calling the proper function that exists in the DatabaseManager.php file			
			$myDb = establishDbConnection();		
         
			//check if a fatal error occourred          
         if ( is_string( $myDb) ){
				// unable to connect to the database, which constitutes a fatal error.         
         	echo "The web application is unable to function properly at this time. Please try again later.";
         	die();
         }
         else {
         	// prepare and execute the MySQl statement to search for the username/password pair in the 'users' table.
				//$query = 'SELECT id_users,username,email FROM users WHERE username=? AND password=?';
				$query = 'SELECT users.id_users,users.username,tipos_user.tipo FROM users LEFT JOIN users_tiposusers ON users.id_users = users_tiposusers.id_user LEFT JOIN tipos_user ON users_tiposusers.id_tipo = tipos_user.id_tipo WHERE users.username=? AND users.password=?';
				$type = array('s','s');
				$arguments = array($_POST['username'], md5($_POST['password']) );
         	$result = executeQuery( $myDb, $query, $type, $arguments);
         	
         	// close the active database connection
         	endDbConnection( $myDb );
         	
         	//check if an error has occurred (result is a string)
         	if ( is_string($result) ){
					echo $result;	
				   die(); 
         	}
         	elseif( !$result ){
         		echo "This operation is unavailable right now. Please try again later (Code: 20)";
				   die(); 
         	}
         	else{
         		
					// yet another security check: was only one row returned from the table, as it should (only one user with that username/password data)?         		
					if ( mysqli_num_rows($result) != 1 ){
						echo "Fatal error! There is something inherently wrong with the system. Please try again later.";
						die();
					}         		
         		else{
         			// get the user's data obtained from the database table	
         			$row = mysqli_fetch_assoc($result);
						
						// create a new session for the authenticated user
					   session_start();
					
						// save in the magic variable $_SESSION the user's ID and username for future usages, during the session's duration.					
						$_SESSION['id_users'] = $row['id_users'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['tipo'] = $row['tipo'];
						 
						//send the user to the home page, for example
						if($row['tipo'] == 'admin'){
							 header('Location:admin.php');
						}else{
							header('Location:Homepage.php');
						}
						
						die();
					}
         	}
			}      
		}
		// if the code execution reaches this line, it means that there is at least one error in the form. It will be printed near the respective form field.	
	} //end main if
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='css/loginForm.css'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src='main.js'></script>
</head>
<body>
<?php
	/* print an error message if the form validation function is being incorrectly used. If that happens, $validationResult
	 * will have a string with the error.
    */
    if ( !empty($validationResult) && is_string($validationResult) ){
    	echo $validationResult;
    }

	//was this a redirect from an unauthorized access atempt?
	//check if a session is already started to avoid warnings.
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
   }
   
	//check if there is any message to present the user with.
	if ( !empty($_SESSION) && array_key_exists('code', $_SESSION) && isset($_SESSION['code']) ){
		//we need the code book	
		require_once('goodies/codes.php');
		
		//is this code valid?
		if ( isset($codes[$_SESSION['code']] ) ){
			echo $codes[$_SESSION['code']] . '<br>';
			
			//clean the variable and respective code so not to have repeated messages.
			unset($_SESSION['code']);
		}
	}
?>
<div class="registerForm">
<h2>Login</h2>
<form action="" method="POST">
<div class="user-box">
  <label for="username">Username:</label><br>
  <input type="text" id="username" name="username" value="<?php
  		// check if this field has a reported error. If not, place the value that the user submitted.
  		if ( !empty($validationResult) && isset($validationResult['username']) && !$validationResult['username'][0] ){
  			echo $_POST['username'];
  		}  
  ?>"></div>
  <?php
  		// check if this field has a reported error. If so, show it.
  		if ( !empty( $validationResult) && isset($validationResult['username']) && $validationResult['username'][0] ){
  			echo $validationResult['username'][1] . '<br>';
  		}  
  ?>
 <div class="user-box">
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password"><br>
  <?php
      // check if this field has a reported error. If so, show it.
  		if ( !empty($validationResult) && isset($validationResult['password']) && $validationResult['password'][0] ){
  			echo $validationResult['password'][1] . '<br>';
  		}
  ?>
  </div>
		<input class="submit" type="submit" value="Submit">	
</form> 
</div>
</body>
</html>