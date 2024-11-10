<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post Layout</title>
    @vite('resources/css/app.css','resources/js/app.js')
</head>
<body>


    <x-navbar />
    <div class="max-w-6xl mx-auto">  
    {{ $slot }}
    </div>
</body>
</html>