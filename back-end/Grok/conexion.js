// conexion.js
const url = 'https://api.x.ai/v1/chat/completions';
const headers = {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer xai-RUgL1I0YMKbVzKEPAnMBnpL9pvlT8YQmbS7qUwWg3MrVhxS7RTUm7356SCNufqsMWcWIlP4AC3WiT2Sb'
};
const data = {
    messages: [
        {
            role: 'system',
            content: 'You are a test assistant.'
        },
        {
            role: 'user',
            content: 'Testing. Just say hi and hello world and nothing else.'
        }
    ],
    model: 'grok-2-latest',
    stream: false,
    temperature: 0
};

fetch(url, {
    method: 'POST',
    headers: headers,
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));