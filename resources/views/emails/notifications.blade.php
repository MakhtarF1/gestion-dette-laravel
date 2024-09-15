<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Demande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #34495e;
        }
        .details {
            margin-top: 20px;
        }
        .details strong {
            color: #2c3e50;
        }
        .article-list {
            margin-top: 15px;
            padding-left: 20px;
        }
        .article-list li {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouvelle Demande Reçue</h1>
        <p>Une nouvelle demande a été soumise avec succès. Voici les détails :</p>

        <div class="details">
            <p><strong>ID de la Demande :</strong> {{ $demande->id }}</p>
            <p><strong>Statut :</strong> {{ $demande->statut }}</p>
            <p><strong>Date de Création :</strong> {{ $demande->created_at }}</p>
        </div>

        <h2>Détails des Articles</h2>
        <ul class="article-list">
            @foreach ($demande->articles as $article)
                <li>
                    <strong>Article :</strong> {{ $article->libelle }}<br> <!-- Remplace l'ID par le libelle -->
                    <strong>Quantité :</strong> {{ $article->pivot->quantite }}<br>
                    <strong>Prix :</strong> {{ $article->pivot->prix }} CFA
                </li>
            @endforeach
        </ul>

        <p>Merci de prendre en compte cette demande.</p>

        <div class="footer">
            <p>Ce message a été généré automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
