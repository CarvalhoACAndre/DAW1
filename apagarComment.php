<?php
$id=$_GET['id'];

$path = 'goodies/DatabaseManager.php';		
		   if (  file_exists($path) ){
				 require_once($path);				
		   }
//ligar a base de dados
$myDb = establishDbConnection();

$apagar= mysqli_query($myDb,"DELETE FROM comments WHERE id_comment='$id'");

header("Location:commentsForm.php");
?>