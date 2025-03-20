<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        select,
        input,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .response {
            margin-top: 20px;
        }

        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>HTTP Client</h1>
        <div class="input-group">
            <select id="method">
                <option value="GET">GET</option>
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
            <input type="text" id="url" placeholder="Enter URL">
            <button id="send">Send</button>
        </div>
        <div class="input-group">
            <textarea id="headers" placeholder="Headers (JSON)"></textarea>
        </div>
        <div class="input-group">
            <textarea id="body" placeholder="Request Body (JSON)"></textarea>
        </div>
        <div class="response">
            <h2>Response</h2>
            <pre id="response"></pre>
        </div>
    </div>
    <script>
        document.getElementById('send').addEventListener('click', function () {
            const method = document.getElementById('method').value;
            const url = document.getElementById('url').value;
            const headers = document.getElementById('headers').value;
            const body = document.getElementById('body').value;

            const requestOptions = {
                method: method,
                headers: headers ? JSON.parse(headers) : {},
                body: body ? JSON.stringify(JSON.parse(body)) : null
            };

            fetch(url, requestOptions)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('response').textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    document.getElementById('response').textContent = 'Error: ' + error.message;
                });
        });
    </script>
</body>

</html>