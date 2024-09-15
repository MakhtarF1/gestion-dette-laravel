<?php
namespace App\Http\Controllers;

use App\Services\DetteServiceInterface;
use App\Http\Requests\StoreDetteRequest;
use Exception;
use Illuminate\Http\Request;

class DetteController extends Controller
{
    protected $detteService;
    protected $archive;

    public function __construct(DetteServiceInterface $detteService)
    {
        $this->detteService = $detteService;
    }

    public function createDette(StoreDetteRequest $request)
    {
        $clientId = $request->input('client_id');
        $articlesData = $request->input('articles');

        $result = $this->detteService->createDette($clientId, $articlesData);

        return response()->json($result, 201);
    }

    public function index(){
        $dettes = $this->detteService->getAllDettes();
        return response()->json($dettes);  
    }

    public function addPaiement($dette_id,$client_id, Request $request){
        $client_id =$request->input('client_id');
        $montant_paiement = $request->input('montant_paiement');
        $result = $this->detteService->addPaiement($dette_id, $client_id,$montant_paiement);
        return response()->json($result);
    }

}   
