<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-tocken" content="{{ csrf_tocken() }}">
    <title>Document</title>
</head>
<body>
    <div id="app">
        <ul>
            <li v-for="message in messages">
              {{message}}
            </li>
          </ul>
    </div>
    <script src="{{ asset('js/app.js') }}"></script> <!--js폴더 안에 있는 laravel echo, pusher 로드--> 
</body>
</html>