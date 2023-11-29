<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $correo = $_POST["Correo"];
    $nueva_contrasena = $_POST["Contrasena"];
    $confirmacion_contrasena = $_POST["ConfirmacionContrasena"];

    // Configuración de la conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "lacarta";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener la contraseña actual de la base de datos
    $sql_select = "SELECT contrasena FROM users_lacarta WHERE correo = '$correo'";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contrasena_actual = $row["contrasena"];

        // Verificar si la nueva contraseña es igual a la contraseña actual
        if (password_verify($nueva_contrasena, $contrasena_actual)) {
            echo '<script>alert("La nueva contraseña no puede ser igual a la contraseña actual");</script>';
        } else {
            // Verificar si las contraseñas coinciden
            if ($nueva_contrasena != $confirmacion_contrasena) {
                echo '<script>alert("Las contraseñas no coinciden");</script>';
            } else {
                // Hashear la nueva contraseña
                $hashed_nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                // Actualizar la contraseña en la base de datos
                $sql_update = "UPDATE users_lacarta SET contrasena = '$hashed_nueva_contrasena' WHERE correo = '$correo'";

                if ($conn->query($sql_update) === true) {
                    echo '<script>alert("Contraseña reestablecida exitosamente");</script>';
                } else {
                    echo "Error al reestablecer la contraseña: " . $conn->error;
                }
            }
        }
    } else {
        echo '<script>alert("Usuario no encontrado");</script>';
    }

    // Cerrar la conexión
    $conn->close();
}
?>
