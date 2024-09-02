<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateClientData
{
    // Instance unique de la classe
    private static $instance = null;

    // Constantes pour les règles de validation
    private const RULES = [
        'surnom' => 'required|string',
        'prenom' => 'required|string',
        'adresse' => 'required|string',
        'telephone' => 'required|phone:SN',
        
        'login' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string'
    ];

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {}

    // Méthode pour obtenir l'instance unique de la classe
    public static function getInstance(): ValidateClientData
    {
        if (self::$instance === null) {
            self::$instance = new ValidateClientData();
        }

        return self::$instance;
    }

    // Méthode pour valider les données client
    public function validate(array $data)
    {
        $validator = Validator::make($data, self::RULES);

        // Vérification personnalisée pour le numéro de téléphone sénégalais
        $validator->after(function ($validator) use ($data) {
            if (!ValidateSenegalPhone::getInstance()->validate('telephone', $data['telephone'])) {
                $validator->errors()->add('telephone', 'Le téléphone doit être un numéro de téléphone sénégalais valide.');
            }
        });

        return $validator->fails() ? $validator->errors() : null;
    }
}
