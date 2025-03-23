<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeMessageController extends Controller
{
    public function getWelcomeMessage()
    {
        try {
            // Obtener el nombre del usuario autenticado
            $userName = Auth::user()->nombre ?? 'Invitado';

            // Definir los tres mensajes de bienvenida
            $messages = [
                // Opción 1
                "**¡Hola $userName!** 👋  
¡Estamos aquí para ayudarte a encontrar lo que más te gusta! 🚀  

➡️ **¿No has empezado?** Pasa por el **blog** y responde las preguntas.  
➡️ **¿Ya terminaste?** Mira tus resultados y recomendaciones en **\"Resumen.\"**  
➡️ **¿Ya sabes qué quieres estudiar?** Revisa las carreras en **\"Portafolio\"** de **Uniminuto** y **UNAD**.  

🤔 ¿Dudas sobre la ubicación o algún término raro? Ve a **\"Contacto\"** y habla con nuestra IA para resolver cualquier pregunta. ¡Estamos para ayudarte! 😎",

                // Opción 2
                "**¡Hola $userName!** 👋  
¿Listo para descubrir tu futuro? 🌟  

✅ Si aún no has empezado, entra al **blog** y responde las preguntas.  
✅ Luego, revisa tus resultados y sugerencias en **\"Resumen\"**.  
✅ ¿Ya sabes qué estudiar? Mira las carreras disponibles en **\"Portafolio\"** de **Uniminuto** y **UNAD**.  

💬 ¿Tienes alguna duda sobre la ubicación o algún término raro? Ve a **\"Contacto\"** y nuestra IA te ayudará con lo que necesites. ¡Vamos, tú puedes! 🚀",

                // Opción 3
                "**¡Hey $userName!** 😎  
¡Estamos aquí para ayudarte a encontrar tu camino! 🚀  

👉 Si aún no has empezado, entra al **blog** y responde las preguntas.  
👉 ¿Terminaste? Consulta tus resultados en **\"Resumen\"** para ver las recomendaciones.  
👉 Si ya tienes claro qué quieres, explora las carreras en **\"Portafolio\"** de **Uniminuto** y **UNAD**.  

❓ ¿Te perdiste o tienes alguna duda? Ve a **\"Contacto\"** y habla con nuestra IA para aclarar cualquier cosa. ¡Tú decides el siguiente paso! 🌟"
            ];

            // Seleccionar un mensaje aleatorio
            $randomMessage = $messages[array_rand($messages)];

            return response()->json(['message' => $randomMessage]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Hola $userName, bienvenido a tu panel de orientación vocacional."], 500);
        }
    }
}