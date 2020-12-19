<!DOCTYPE html>
<html lang="en">
<head>
    @base
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="@asset('public/bootstrap-4.4.1/dist/css/bootstrap.min.css')" rel="stylesheet">
    <title>hyFer</title>
</head>
<body>
    @yield('content')
    <script src="@asset('public/js/jquery-3.5.1.min.js')"></script>
    <script src="@asset('public/bootstrap-4.4.1/dist/js/bootstrap.min.js')"></script>
</body>
</html>