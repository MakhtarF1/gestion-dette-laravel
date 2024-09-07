<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
</head>
<body>
    <div>
        <img src="{{ $user->photo }}" alt="Photo de {{ $user->name }}">
        <h2>{{ $user->name }}</h2>
        <p>{{ $user->login }}</p>
    </div>
    <div>
        <img src="{{ $qrCodeDataUri }}" alt="QR Code">
    </div>
</body>
</html>
