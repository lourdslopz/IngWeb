<?php
function autenticarUsuario($correo, $contrasena) {
    // Check if the request method is set
    if (isset($_SERVER["REQUEST_METHOD"])) {
        // Conectar a la base de datos (ajusta las credenciales según tu configuración)
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "lacarta";
        

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }

        // Consulta SQL para verificar las credenciales
        $sql = "SELECT * FROM users_lacarta WHERE correo = '$correo' AND contrasena = '$contrasena'";
        $result = $conn->query($sql);

        // Verificar si se encontraron coincidencias
        if ($result->num_rows > 0) {
            // Inicio de sesión exitoso
            return true;
        } else {
            // Credenciales incorrectas
            return false;
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        // Handle the case where 'REQUEST_METHOD' is not set
        die("Error: 'REQUEST_METHOD' not set.");
    }
}
?>
