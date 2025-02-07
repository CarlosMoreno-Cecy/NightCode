<?php

if (isset($_POST['submit'])) {
    if (empty($_POST['nombre']) ||
        empty($_POST['email']) ||
        empty($_POST['mensaje']))
    {
        /*
        Si no están llenos los campos, redirecciona con error.
        */
        header("Location: ../contacto.html?llena-todos-los-campos");
        exit();
    } else {
        // DATOS DEL FORMULARIO A ENVIAR
        $info['nombre'] = $_POST['nombre'];
        $info['email'] = $_POST['email'];
        if (empty($_POST['tel'])) {
            $info['telefono'] = 'No ingresó número de teléfono';
        } else {
            $info['telefono'] = $_POST['tel'];
        }
        $info['mensaje'] = $_POST['mensaje'];
        $info['ip'] = $_SERVER['REMOTE_ADDR'];
        $info['fecha'] = date('d M Y H:i:s');

        /*
        Solo para probar localmente
        */
        $mensaje = "
        <html>
        <body>
        <h3>Tu mensaje ha sido enviado</h3>
        <p><strong>Nombre:</strong> {$info['nombre']}</p>
        <p><strong>E-mail:</strong> {$info['email']}</p>
        <p><strong>Teléfono:</strong> {$info['telefono']}</p>
        <p><strong>Mensaje:</strong> {$info['mensaje']}</p>
        <br>
        <p><strong>IP:</strong> {info['ip']}</p>
        <p><strong>Fecha:</strong> {info['fecha']}</p>
        </body>
        </html>
        ";

        /*
        Envio real del formulario
        */
        $para = "hellow@joystick.com.mx";
        $de = $para;

        // Asunto del correo
        $asunto = "Hola, es mi primer correo - Blackparadox";

        // Cabeceras que aparecen arriba de tu correo
        $headers = "From: $de\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-type: text/html; charset=utf-8\r\n";

        // Mensaje del correo
        // $mensaje es el mensaje

        // Enviando el formulario
        $enviar = mail($para, $asunto, $mensaje, $headers);
        if ($enviar) {
            // Si se envió el correo
            header("Location: ../contacto.html?success");
            exit();
        } else {
            header("Location: ../contacto.html?error");
            exit();
        }
    }
} else {
    /* 
    Si no se manda el formulario, regresa a contactos con error
    */
    header("Location: ../contacto.html?error");
}

?>

<br>
<a href="../contacto.html">Regresar</a>