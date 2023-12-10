<?php
/* This file contains all the validation functions that are developed in this class. Moreover, each different form
 * in the web application under development will have it's own validation function, responsible for calling each
 * individual validation for the different form fields submitted.
 * As each validation function may depend on available web application parameters - described in the ConfigApp.php file - 
 * there is the need to include them in the code, whenever it will be needed. Please pay attention that each function
 * is contained, which means that if the ConfigApp.php file (or any other by the way) is needed in different functions
 * it has to be included every time.
 */
	
function validateUpdateForm($data){
		
	# relative path to the web root folder. 
	$path = 'goodies/ConfigApp.php';	
	if (  file_exists($path) ){
		require($path);				
   }
	else{
	   return 'Internal server error: please try again later (Code: 9).';
	   die();		
	}	
	
	/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
	 * will enable to return to the function caller the list of possible errors so that it can show the user
	 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	 */
	$errors = array( 'email' => array(false, "Invalid email format"),
	                 'password' => array(false, "The password must have between $minPassword and $maxPassword alfanumeric or special chars."),
	                 'rpassword' => array(false, "Passwords do not match.")
            	   );
   
	//check if the data array sent has all the needed fields
	if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
		//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
		return ('Form data mismatches. Please correct it.');
	}
   			   			
	//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
	$flag = false; # no form field has errors presently
	if ( ! validateEmail($data['email']) ){
		//the email field is invalid.
		$errors['email'][0] = true;
		$flag = true;
	}			
			
	if ( ! validatePassword($data['password'], $minPassword, $maxPassword ) ){
		//the password field is not correct.
	   $errors['password'][0] = true;
		$flag = true;
	}
	elseif( $data['rpassword'] != $data['password'] ){
		//the rpassword content is not the same as the password, which is an error.
		$errors['rpassword'][0] = true;
		$flag = true;
	}			
						
	//the form was validated. Is there an error? If so, return the errors array. Otherwise, return true.
	if( !$flag ){
		return(true);
	}	
	else{
		return( $errors );			
	}
} 
  
function validateLoginForm($data){
		
			# relative path to the web root folder. 
			$path = 'goodies/ConfigApp.php';	
		   if (  file_exists($path) ){
				 require($path);				
		   }
		   else{
			   return 'Internal server error: please try again later (Code: 9).';
			   die();		
		   }	
	
			/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
			 * will enable to return to the function caller the list of possible errors so that it can show the user
			 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	       */
			$errors = array( 'username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername alfabetic and/or numeric chars. The underscore is also allowed."),
			                 'password' => array(false, "The password must have between $minPassword and $maxPassword alfanumeric or special chars.")
            			   );
   
			//check if the data array sent has all the needed fields
			if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
				//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
				return ('Form data mismatches. Please correct it.');
			}
   			   			
			//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
			$flag = false; # no form field has errors presently
			if ( ! validateUsername($data['username'], $minUsername, $maxUsername ) ){
				//the username field is not correct.
				$errors['username'][0] = true;
				$flag = true;
			}			
						
			if ( ! validatePassword($data['password'], $minPassword, $maxPassword ) ){
				//the password field is not correct.
				$errors['password'][0] = true;
				$flag = true;
			}
	
			//the form was validated. Is there an error? If so, return the errors array. Otherwise, return true.
			if( !$flag ){
				return(true);
			}	
			else{
				return( $errors );			
			}
	}

	function validateRegisterForm($data){
		
			# relative path to the web root folder. 
			$path = 'goodies/ConfigApp.php';	
		   if (  file_exists($path) ){
				 require($path);				
		   }
		   else{
			   return 'Internal server error: please try again later (Code: 9).';
			   die();		
		   }	
	
			/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
			 * will enable to return to the function caller the list of possible errors so that it can show the user
			 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	       */
			$errors = array( 'username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername alfabetic and/or numeric chars. The underscore is also allowed."),
			                 'email' => array(false, 'Invalid email format.'),
			                 'password' => array(false, "The password must have between $minPassword and $maxPassword alfanumeric or special chars."),
			                 'rpassword' => array(false, "Passwords do not match.")
            			   );
   
			//check if the data array sent has all the needed fields
			if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
				//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
				return ('Form data mismatches. Please correct it.');
			}
   			   			
			//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
			$flag = false; # no form field has errors presently
			if ( ! validateUsername($data['username'], $minUsername, $maxUsername ) ){
				//the username field is not correct.
				$errors['username'][0] = true;
				$flag = true;
			}			
			
			if ( ! validateEmail($data['email']) ){
				//the email field is invalid.
				$errors['email'][0] = true;
				$flag = true;
			}			
			
			if ( ! validatePassword($data['password'], $minPassword, $maxPassword ) ){
				//the password field is not correct.
				$errors['password'][0] = true;
				$flag = true;
			}
			elseif( $data['rpassword'] != $data['password'] ){
				//the rpassword content is not the same as the password, which is an error.
				$errors['rpassword'][0] = true;
				$flag = true;
			}	
	
			//the form was validated. Is there an error? If so, return the errors array. Otherwise, return true.
			if( !$flag ){
				return(true);
			}	
			else{
				return( $errors );			
			}
	}

	function validateDeleteForm($data){
		
			# relative path to the web root folder. 
			$path = 'goodies/ConfigApp.php';	
		   if (  file_exists($path) ){
				 require($path);				
		   }
		   else{
			   return 'Internal server error: please try again later (Code: 9).';
			   die();		
		   }	
	
			/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
			 * will enable to return to the function caller the list of possible errors so that it can show the user
			 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	       */
			$errors = array( 'username' => array(false, "Invalid username: it must have between $minUsername and $maxUsername alfabetic and/or numeric chars. The underscore is also allowed."),
			                );
   
			//check if the data array sent has all the needed fields
			if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
				//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
				return ('Form data mismatches. Please correct it.');
			}
   			   			
			//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
			$flag = false; # no form field has errors presently
			if ( ! validateUsername($data['username'], $minUsername, $maxUsername ) ){
				//the username field is not correct.
				$errors['username'][0] = true;
				$flag = true;
			}			
	}

	function postcomments(){
		if(!empty($_POST)){
				
		$path = 'goodies/ConfigApp.php';		
		   if (  file_exists($path) ){
				 require_once($path);				
		   }
		   else{
			   echo 'Internal server error: please try again later (Code: 11).';
			   die();		
		   }
		

		$path = 'goodies/DatabaseManager.php';		
		   if (  file_exists($path) ){
				 require_once($path);				
		   }
		   else{
			   echo 'Internal server error: please try again later (Code: 11).';
			   die();		
		   }

		$myDb = establishDbConnection();

		$query = 'INSERT INTO comments (comment) VALUES(?)';
		$type = array('s');
		$arguments = array($_POST['comment']);
		$result = executeQuery( $myDb, $query, $type, $arguments);
         	 
		if(!empty($result)&& is_string($result)){
			echo $result;
		}else{
			echo 'Write something to comment';
			//check if a session is already started to avoid warnings.
				if (session_status() === PHP_SESSION_NONE) {
					session_start();
			}
			
			//place the success code in the session
			$_SESSION['code'] = 100;
			
			//the user is registered. Go to the homepage.
				header('Location:Homepage.php');
				die();       	
			}
			$result = endDbConnection( $myDb );
			die();
		}
		
	}

	function validateComments($data){
		
		# relative path to the web root folder. 
			$path = 'goodies/ConfigApp.php';	
		   if (  file_exists($path) ){
				 require($path);				
		   }
		   else{
			   return 'Internal server error: please try again later (Code: 9).';
			   die();		
		   }	
	
			/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
			 * will enable to return to the function caller the list of possible errors so that it can show the user
			 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	       */
			$errors = array( 'comments' => array(false, "Invalid comment!"),
			                 );
   
			//check if the data array sent has all the needed fields
			if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
				//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
				return ('Something Happened. Try again!!');
			}
   			   			
			//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
			$flag = false; # no form field has errors presently
			if ( ! validateComment($data['comment']) ){
				//the username field is not correct.
				$errors['comment'][0] = true;
				$flag = true;
			}			
			
			//the comment was validated. Is there an error? If so, return the errors array. Otherwise, return true.
			if( !$flag ){
				return(true);
			}	
			else{
				return( $errors );			
			}
	}
	
	

	function showComments(){

		
		$path = 'goodies/DatabaseManager.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}

		$myDb = establishDbConnection();
	
		$query="SELECT comment FROM comments ORDER BY id_comment";
		$result = mysqli_query($myDb,$query);

		if (mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_assoc($result);
			while($row = mysqli_fetch_assoc($result)){
				echo '<div class="comments" >Comment </br>'.$row['comment'].' </br></br></br></div>';
			}
		}
	}

/*
-------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------
*/

	function validateProducts($data){
		
		$path = 'goodies/ConfigApp.php';	
		   if (  file_exists($path) ){
				 require($path);				
		   }
		   else{
			   return 'Internal server error: please try again later (Code: 9).';
			   die();		
		   }
	
			/* Declare an error array to keep track of possible errors in the submitted form' fields. This structure
			 * will enable to return to the function caller the list of possible errors so that it can show the user
			 * whenever and wherever it is deemed more effective. For this reason, each form' field must be in this array.
	       */
			$errors = array( 'name' => array(false, "Invalid name: it must have between $minUsername and $maxUsername alfabetic and/or numeric chars. The underscore is also allowed."),
			                 'price' => array(false, 'Invalid price format.Please use it like this ex:00.00'),
			                 'description' => array(false, "The password must have between $minPassword and $maxPassword alfanumeric or special chars."),
							 'image' => array(false, "Invalid image!")
			                 );
   
			//check if the data array sent has all the needed fields
			if ( count(array_diff(array_keys($errors), array_keys($data))) != 0){
				//the arrays are not the same. Something is wrong and both the required fields, errors array and from data sent may need to be corrected 		
				return ('Form data mismatches. Please correct it.');
			}
   			   			
			//begin to validate fields assuming that they are all required. Furthermore declare an error flag to simplify in the end.
			$flag = false; # no form field has errors presently
			if ( ! validateName($data['name'], $minUsername, $maxUsername ) ){
				//the username field is not correct.
				$errors['name'][0] = true;
				$flag = true;
			}			
			
			if ( ! validatePrice($data['price']) ){ 	
				//the email field is invalid.
				$errors['price'][0] = true;
				$flag = true;
			}			
			
			elseif ( ! validateDescription($data['description'], $minPassword, $maxPassword ) ){
				//the description field is invalid.
				$errors['description'][0] = true;
				$flag = true;
			}
			
	
			//the form was validated. Is there an error? If so, return the errors array. Otherwise, return true.
			if( !$flag ){
				return(true);
			}	
			else{
				return( $errors );			
			}
	}	

	function showProducts(){
		$path = 'goodies/ConfigApp.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
			
		$path = 'goodies/DatabaseManager.php';		
		if (  file_exists($path) ){
		   require_once($path);				
		}
		else{
		   echo 'Internal server error: please try again later (Code: 8).';
		   die();		
		}
		 
		
		$myDb = establishDbConnection();
		
		$query = "SELECT * FROM products";
		$result = mysqli_query($myDb, $query);
		
		if (mysqli_num_rows($result) >0){
			while($row = mysqli_fetch_assoc($result)){
				echo '<div class=products1>';
				echo '<h6>User que vende:</h6>'.$row['username'];
				echo '</br><img class="productimg" src="'.$row['image'].'">';
				echo '</br><h6>Descrição do produto:</h6>'.$row['description'];
				echo '</div>';
			}
		}
	}

	

	/* ----------------------------------------------------------------------------------- */
	// Individual validation functions to be used multiple times if it is needed

	// This function validates an email regarding it's structure.
	function validateEmail($email){
		return( filter_var($email, FILTER_VALIDATE_EMAIL) ); # it will return false if the email is invalid and true if valid.		
	}

   // This function validates an username regarding it's structure and content.
	function validateUsername($username, $min, $max){
		$expression = '/^(?=[\W]+[a-zA-Z0-9]|[a-zA-Z0-9]+[\W]|[a-zA-Z0-9]+).{'. $min . ',' . $max .'}$/';
		/* This expression in adapted from the web: it allows special and alfanumeric chars but only 
		 * in the presence of one another. Please note that \W means any word char (including special chars)
		 */ 
		return( preg_match($expression, $username) );		
	}

	// This function validates a password regarding both structure and content
	function validatePassword($password, $min, $max){
		$expression = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{' . $min . ',' . $max . '}$/';
		/* This expression was obtained in https://uibakery.io/regex-library/password-regex-php
		 * Please read the source to obtain a more detailed explanation but in short the password must have
		 * an upper case, lower case, numeric and special char to be valid, between a minimum and a maximum.
		 */
		 return( preg_match($expression, $password) );	
	}

	
	// This function validates an username regarding it's structure and content.
	function validateName($name, $min, $max){
		$expression = '/^(?=[\W]+[a-zA-Z0-9]|[a-zA-Z0-9]+[\W]|[a-zA-Z0-9]+).{'. $min . ',' . $max .'}$/';
		/* This expression in adapted from the web: it allows special and alfanumeric chars but only 
		 * in the presence of one another. Please note that \W means any word char (including special chars)
		 */ 
		return( preg_match($expression, $name) );

	}

	//Function validates the introduction of a valid format for price
	function validatePrice($price){
		$expression = '/^(0|[1-9]\d*)(\.\d{5})?$/';
		
		return( preg_match($expression,$price) );

	}
	
	//Validates the introduction of a valid format for category
	function validateDescription($description, $min, $max){
		$expression = '/^(?=[\W]+[a-zA-Z0-9]|[a-zA-Z0-9]+[\W]|[a-zA-Z0-9]+)$/';
		/* This expression in adapted from the web: it allows special and alfanumeric chars but only 
		 * in the presence of one another. Please note that \W means any word char (including special chars)
		 */ 
		return( preg_match($expression, $description) );

	}
	
?>
