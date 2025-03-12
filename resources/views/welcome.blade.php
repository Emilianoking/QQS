<!DOCTYPE html>
<html>
<head>
    <title>Mi Proyecto</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <h1>Habla con Grok</h1>
    <input type="text" id="message" placeholder="Escribe tu mensaje">
    <button onclick="sendMessage()">Enviar</button>
    <pre id="response"></pre>

    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;
            fetch('/api/xai', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>