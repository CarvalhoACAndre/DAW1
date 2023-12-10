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
	if (session_status() === PHP_SESSION_NONE){
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
//se o formulário for submetido
if (isset($_POST['Submit'])){
	
	//guarda os dados nas variáveis
	$arquivo = $_FILES['image'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$id_users = $_SESSION['id_users'];
	$username = $_SESSION['username'];

	//upload da imagem
	$mensagem = "";
	$nomeDoArquivo = $arquivo['name'];
	$extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION)); //obter extensao da imagem
	$imagem = "images/" . md5(time()). "." . $extensao; //altera o nome da imagem para que nao haja imagens com o mesmo nome
	$target = "images/".basename($imagem); //basename() tira as "/" da "informação" da variavel(neste caso que é uma variavel)
	

	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$mensagem = "Imagem carregada com sucesso!";
  	}else{
  		$mensagem = "A imagem não foi carregada!";
  	}


    if ($extensao == "jpg" || $extensao == "jpeg" || $extensao == "png") {

		//ficheiro de ligação á base de dados
		$path = 'goodies/DatabaseManager.php';		
				   if (  file_exists($path) ){
						 require_once($path);				
				   }

		//ligar a base de dados
		$myDb = establishDbConnection();

			//guardar na tabela
		  	$inserir = mysqli_query($myDb, "INSERT INTO products (name,description,price,image,id_users, username) VALUES('$name','$description','$price','$imagem','$id_users', '$username')");

		  	//Verificar se entrou na tabela
		  	if ($inserir) {

		  		echo '<p class="texto">Produto adicionado com sucesso!</p>';
				header('Location:Homepage.php');
		  	}else{
		  		echo '<p class="texto">Não foi possível adicionar o produto!</p>';}

		}else{echo '<p class="texto">O formato da imagem é inválido!</p>';}
		
}
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<title>Ready 2 Go! | Anunciar</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/registerProducts.css">
		<link rel="stylesheet" href="style.php">

</head>
<body>
	<div class="title-wrapper-catalog">
				
				<h3 class="cata">Anunciar</h3>

		<form action="" method="POST" enctype="multipart/form-data">
		<div class="formulario">
			<div class="campos">
				<input class="campos" maxlength="20" placeholder="Nome de anúncio..." type="text" name="name" required>
			</div>
			</br>
			<div>
				<textarea maxlength="50" class="campos" placeholder="Descrição do anúncio..." name="description"></textarea>
			</div>
			</br>
			<div>
				<input placeholder="Preço de anúncio..." maxlength="9" class="campos" type="number"name="price" min="0.00" max="100000.00" step="0.01" required>
			</div>
			</br>
			<div class="campos">
				<label style="font-size: 13px" for="image">Imagem: <span style="color:red; font-style: italic;">(Apenas ficheiros JPG, JPEG ou PNG. Máx: 2MB)</span></label><br>
				</br>
				<input type="file" name="image" required>
			</div>
			</br>
        	<div>
				<input class="campos" name="Submit" type="submit" value="Submit">
			</div>
        	</div>
        </form>
		
		</div>

</body>
</html>