<?php

$servername = "localhost";
$username = "root"; 
$password = "";
$database = "mydb"; 

$conn = new mysqli($servername, $username, $password, $database); 

if ($conn->connect_error) { 

 die("Conexión fallida: " . $conn->connect_error); 

}else{  echo ""; 

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y limpiarlos
    $Correo = isset($_POST["Correo"]) ? htmlspecialchars($_POST["Correo"]) : "";
    $Contrasena = isset($_POST["Contrasena"]) ? htmlspecialchars($_POST["Contrasena"]) : "";



    // Verificar que los campos no estén vacíos
    if(!empty($Correo) && !empty($Contrasena)) {
        // Consulta para verificar las credenciales del usuario
        $sql = "SELECT * FROM usuarios WHERE Correo = '$Correo' AND Contraseña = '$Contrasena'";


       // Ejecutar la consulta
       $resultado = $conn->query($sql);

       // Verificar si se encontraron resultados
       if ($resultado->num_rows > 0) {
           // Obtener información adicional del usuario
           while($usuario = $resultado->fetch_assoc()){
           $esAdmin = $usuario['Tipo']; // Supongamos que es_admin es el campo que indica si es administrador o no
           }

           
           // Redirigir según si es administrador o usuario normal
           if ($esAdmin == 1) {
              header("Location: header.php ");
           } else {
              header("Location: usuario_normal.php");
           }
           exit(); // Detener la ejecución del script después de la redirección
       } else {
           // Usuario no encontrado o credenciales incorrectas
           echo "Credenciales incorrectas. Por favor, intente de nuevo.";
       }
   }
} else {
   // Si no se envió el formulario, mostrar un mensaje de error
   echo "Error: El formulario no se envió correctamente.";
}
?>