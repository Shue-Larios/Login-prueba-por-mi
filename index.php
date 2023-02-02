<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="src/css/style.css">
  <title>Bienvenido</title>
</head>

<?php
// inicio php
//conexion a la base de datos
require ("config/database.php");
$db =  conectarDB();


// autenticamos al usuario
// para leer los datos del metodo post
//arreglo vacio para los errores
$errores = [];

////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //  agregamos a variables los datos q traemos por post
  // ponemos un filtro para saber si es tipo correo
  // como interactua directamente con la base le ponemos mysqli_real_escape_string
  $user = mysqli_real_escape_string($db, filter_var($_POST['user'], FILTER_VALIDATE_EMAIL));
  $password = mysqli_real_escape_string($db, $_POST['password']);

  //  en caso que no hay email
  if (!$user) {
      $errores [] = "EL usuario es obligatorio o no es valido";
  }
  if (!$password) {
      $errores [] = "el password es obligatorio o no es valido";
  }
  // en caso que las validaciones esten vacias
  if (empty($errores)) {
      //revisar si el usuario existe
      $query = "SELECT * FROM usuarios WHERE email = '${user}'";
      $resultado = mysqli_query($db, $query);

  // var_dump($resultado);
// aca si num_rows viene en cero es xk el usuario no existe
  if ($resultado -> num_rows) {

      //REVISAR SI EL PASSWORD ES CORRECTO
      $usuario = mysqli_fetch_assoc($resultado);

      // verificar si el password es correcto o no con password_verify que toma dos argumentos
      // el password q el usuario a ingresado y dos el password ya hasheado
      $auth = password_verify($password, $usuario['password']);
      // var_dump($auth); me regresa un false si es incorrecto y true si es correcto
//  para mandar un msj diciendo q el password es incorrecto
      if ($auth) {
// autenticamos el  usuario
// con la super globarl Session esta va a mantener informacion de la sesion del usuario
session_start();

//llenamos el arreglo de la sesion
$_SESSION['usuario'] = $usuario['user'];
$_SESSION['login'] = true;
//redireccionamos al usuario a la pagina que queremos entre
header("location: /pagina1.php?login=1");

      }else {
          $errores[] = "Password incorrecto";
      }
  }else {
     $errores[] = "El usuario no existe";
  }
}
}

///////////////////

?>



<body>
  
<div class="login">
   <!-- el foreach se va a ejecutar mientras el arreglo tenga datos  para imprimir los errores-->
 <?php  foreach($errores as $error):?>
    <div class="alerta error">
<?php  echo $error;?>
    </div>
<?php  endforeach;?>
	<h1>Ingresa al Sistema</h1>
    <form method="POST">
    	<input type="text" name="user" placeholder="Username" />
      <div class="contenedor">
      <input type="password" name="password" placeholder="Password"  id="password"/>
        <div class="input-group-append">
            <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
          </div>

      </div>
        
        <button type="submit" class="btn btn-primary btn-block btn-large">Ingresar</button>

    </form>
</div>
<script type="text/javascript" src="src/js/app.js"> </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>

