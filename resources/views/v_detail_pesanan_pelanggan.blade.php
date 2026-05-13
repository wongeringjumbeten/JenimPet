<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    @vite('resources/css/app.css')
</head>
<body>
    <h1>Detail Pesanan #{{ $pesanan->id_pesanan }}</h1>
    <p>Status: {{ $pesanan->status_pesanan }}</p>
</body>
</html>
