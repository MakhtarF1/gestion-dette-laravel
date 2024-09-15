<?php
// require '../vendor/autoload.php'; // Ajustez le chemin

// // Charger les variables d'environnement depuis le fichier .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

// $dotenv->load();

// $uri = getenv('MONGODB_URI');

// if (!$uri) {
//     die('La chaîne de connexion MongoDB n\'est pas définie.');
// }

// $client = new MongoDB\Client($uri);

// try {
//     $client->listDatabases(); // Essayer de lister les bases de données
//     echo "Connection successful!";
// } catch (Exception $e) {
//     echo "Connection failed: " . $e->getMessage();
// }