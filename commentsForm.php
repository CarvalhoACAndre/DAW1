<!DOCTYPE html>
<html>
<head>
	<title>Ready 2 Go! | Mensagens</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/commentsForm.css">
		<link rel="stylesheet" href="style.php">
		<link rel="stylesheet" type="text/css" href="indexstyle.css">
</head>
<body>

<?php

	//verifica a autenticação e inclui a barra de navegação
	$path = 'goodies/header.php';		
	if (  file_exists($path) ){
	   require_once($path);				
	}
	else{
	   echo 'Internal server error: please try again later (Code: 8).';
	   die();		
	}
		
	//verifica se uma sessão já foi iniciada, para evitar avisos
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
   }
   
	//check if there is any message to present the user with.
	if ( !empty($_SESSION) && array_key_exists('code', $_SESSION) && isset($_SESSION['code']) ){
		//we need the code book	
		require_once('goodies/codes.php');
		
		//is this code valid?
		if ( isset($codes[$_SESSION['code']] ) ){
			echo '<br>' . $codes[$_SESSION['code']] . '<br>';
			
			//clean the variable and respective code so not to have repeated messages.
			unset($_SESSION['code']);
		}
	}
	if ($_SESSION['tipo'] == "User"){
		require_once('goodies/codes.php');
		unset( $_SESSION['id_users']);   
		unset( $_SESSION['username']);
		session_destroy();
		$_SESSION = array();
	
	//now send the user to the login page
	header('Location:loginForm.php');
	die();
	}
?>

<div class="title-wrapper-catalog">
<p>Aqui é possivel gerir as mensagem recebidas</p>
<h3 class="cata">Mensagens</h3>

<?php 
	//ficheiro de ligação á base de dados
	$path = 'goodies/DatabaseManager.php';		
		   if (  file_exists($path) ){
				 require_once($path);				
		   }
	//ligar a base de dados
	$myDb = establishDbConnection();
		//mostrar dados da tabela
		$query = "SELECT * FROM comments";
		$result = mysqli_query($myDb, $query);
?>
<div class="formulario">
<table style="width:100%">
<tr>
<th style="width: 10%; padding-bottom: 20px">ID</th>	
<th style="width: 10%; padding-bottom: 20px">Mensagem</th>
</tr>
<?php
while($row = mysqli_fetch_assoc($result)) {
 ?>

<div class="showformulario">
<tr>
<td style="padding-bottom: 10px" valign=middle align=middle><?php echo $row['id_comment']; ?></td>
<td style="padding-bottom: 10px" valign=middle align=middle><?php echo $row['comment']; ?></td>
<td style="padding-bottom: 10px" valign=middle align=middle><?php echo $row['id_parent']; ?></td>  
<td style="padding-bottom: 10px" valign=middle align=middle><a href="apagarComment.php?id=<?php echo $row ['id_comment']; ?>">Apagar</a></td>  
</tr>
</div>



           
<?php }


?>
</table>
</div>
</body>
</html>