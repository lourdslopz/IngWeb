<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["Correo"];
    $contrasena = $_POST["Contrasena"];

    // Configuración de la conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "lacarta";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users_lacarta WHERE correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row["contrasena"])) {
            // Inicio de sesión exitoso
            $_SESSION["usuario"] = $row["nombrecompleto"];
            
            // Redirigir a la página deseada (por ejemplo, la página de bienvenida)
            header("Location: home.html");
            exit();
        } else {
            echo '<script>alert("Credenciales incorrectas");</script>';
        }
    } else {
        echo '<script>alert("Usuario no encontrado");</script>';
    }

    $conn->close();
}
?>
