<?php
if (!isset($_POST)) {
    die('No autorizado');
}

// Función para trabajar nuestras respuestas
function json_output($status = 200, $msg = 'OK', $data = []) {
    echo json_encode(['status' => $status, 'msg' => $msg, 'data' => $data]);
    die();
}

if (empty($_POST['nombre'])) {
    json_output(400, 'Ingresa un nombre válido.');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    json_output(400, 'Ingresa un email válido.');
}

if (empty($_POST['tel'])) {
    json_output(400, 'Ingresa un teléfono válido.');
}

if (empty($_POST['mensaje']) || strlen($_POST['mensaje']) < 5) {
    json_output(400, 'Ingresa un mensaje válido.');
}

// Información del formulario
$info['nombre'] = $_POST['nombre'];
$info['email'] = $_POST['email'];
$info['telefono'] = $_POST['tel'];
$info['mensaje'] = $_POST['mensaje'];
$info['ip'] = $_SERVER['REMOTE_ADDR'];
$info['fecha'] = date('d M Y H:i:s');

// Remitente y destinatario
$para = $_POST['email'];

// Debe ser un email del servidor local
$de = 'black@blackparadox.com';

// Asunto del mensaje
$asunto = "Nuevo mensaje para Blackparadox";

// Cabeceras que aparecen arriba de tu correo
$headers = "From: {$de}\r\n";
$headers.= "MIME-Version: 1.0" . "\r\n";
$headers.= "Content-type: text/html; charset=utf-8" . "\r\n";

// Mensaje del correo
$mensaje = "
        <html>
        <body>
        <h3>Tu mensaje ha sido enviado</h3>
        <p><strong>Nombre:</strong> {$info['nombre']}</p>
        <p><strong>E-mail:</strong> {$info['email']}</p>
        <p><strong>Teléfono:</strong> {$info['telefono']}</p>
        <p><strong>Mensaje:</strong> {$info['mensaje']}</p>
        <br>
        <p><strong>IP:</strong> {$info['ip']}</p>
        <p><strong>Fecha:</strong> {$info['fecha']}</p>
        </body>
        </html>
        ";

// Valida si se envía o no
$enviar = mail($para, $asunto, $mensaje, $headers);
if (!$enviar) {
    json_output(400, 'Hubo un error al enviar el mensaje.');
}

json_output(200, 'Mensaje enviado con éxito.', $mensaje);