<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatting</title>
</head>
<body style="background : rgb(204, 231, 204)">
    <input type="hidden" id="b_parrent_chatWith" value="{{ $chatWith }}">
    <div id="app">
        <chatting></chatting>
        {{-- :current-user="{{ auth()->id() }}" --}}
    </div>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>