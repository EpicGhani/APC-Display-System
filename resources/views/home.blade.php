<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Project Prototype</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-900 flex items-center justify-center h-screen">
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg rounded-lg p-10 bg-opacity-25">
        <h1 class="text-white text-3xl mb-4 tect-center">Welcome to Display Project Prototype</h1>
        <div class="flex space-x-4 justify-center">
            <button class="bg-blue-400 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick='(function(){window.location="/console";})()'>
                Console
            </button>
            <button class="bg-blue-400 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick='(function(){window.location="/display";})()'>
                Display
            </button>
        </div>
    </div>
</body>
</html