<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["Nombre"];
    $correo = $_POST["Correo"];
    $contrasena = password_hash($_POST["Contrasena"], PASSWORD_DEFAULT);

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "lacarta";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users_lacarta (nombrecompleto, correo, contrasena) VALUES ('$nombre', '$correo', '$contrasena')";

    if ($conn->query($sql) === true) {
        header("Location: login.html");
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }

    $conn->close();
}

?>
