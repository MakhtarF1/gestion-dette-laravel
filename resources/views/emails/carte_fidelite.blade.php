<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte de Fidélité</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            text-align: center;
            margin: auto;
        }
        .header {
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4a4a4a;
            margin-bottom: 10px;
        }
        .title {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .badge {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 48px;
            font-weight: bold;
            margin: 0 auto 30px;
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
        }
        .user-info {
            margin-bottom: 30px;
        }
        .user-info strong {
            font-size: 24px;
            display: block;
            margin-bottom: 5px;
            color: #34495e;
        }
        .user-info p {
            font-size: 16px;
            margin: 5px 0;
            color: #7f8c8d;
        }
        .qr-code {
            margin-top: 30px;
        }
        .qr-code img {
            max-width: 150px;
            height: auto;
            border: 2px solid #ecf0f1;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #95a5a6;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">Dette Storee</div>
            <div class="title">Carte de Fidélité</div>
        </div>
        <div class="badge">
            @if ($user->client)
                {{ $user->surname }} <!-- Initiales du nom et prénom -->
            @else
                N/A
            @endif
        </div>
        <div class="user-info">
            @if ($user->client)
                <strong>{{ $user->surname }}</strong> <!-- Affichage du nom et prénom -->
            @else
                <strong>Client Non Disponible</strong>
            @endif
            <p>{{ $user->login }}</p> <!-- Affichage du login -->
        </div>
        <div class="qr-code">
            @if ($user->qr_code)
                <img src="{{ asset('storage/qrcodes/' . $user->qr_code) }}" alt="QR Code"> <!-- Utilisation de qr_code -->
            @else
                <p>QR Code Non Disponible</p>
            @endif
        </div>
        <div class="footer">
            Merci de votre fidélité !
        </div>
    </div>
</body>
</html>
