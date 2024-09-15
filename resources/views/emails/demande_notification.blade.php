<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notification de Demande</title>
</head>
<body>
    <h1>Nouvelle Demande Reçue</h1>
    <p>Une nouvelle demande a été créée.</p>
    <p><strong>ID de la Demande :</strong> {{ $demande->id }}</p>
    <p><strong>Statut :</strong> {{ $demande->statut }}</p>
    <p><strong>Date de Création :</strong> {{ $demande->created_at }}</p>

    <h2>Détails des Articles</h2>
    <ul>
        @foreach ($demande->articles as $article)
            <li>
                <strong>ID de l'Article :</strong> {{ $article->pivot->article_id }}<br>
                <strong>Quantité :</strong> {{ $article->pivot->quantite }}<br>
                <strong>Prix :</strong> {{ $article->pivot->prix }}
            </li>
        @endforeach
    </ul>

    <p>Merci de prendre en compte cette demande.</p>
</body>
</html>
