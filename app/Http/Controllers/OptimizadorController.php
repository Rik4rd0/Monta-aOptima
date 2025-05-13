<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OptimizadorService;

class OptimizadorController extends Controller
{
    protected $optimizador;
    
    public function __construct(OptimizadorService $optimizador)
    {
        $this->optimizador = $optimizador;
    }
    
    public function index()
    {
        return view('optimizador.index');
    }
    
    public function calcular(Request $request)
    {
        $request->validate([
            'elementos' => 'required|array',
            'elementos.*.id' => 'required|string',
            'elementos.*.nombre' => 'required|string',
            'elementos.*.peso' => 'required|numeric|min:0',
            'elementos.*.calorias' => 'required|numeric|min:0',
            'peso_maximo' => 'required|numeric|min:1',
            'calorias_minimas' => 'required|numeric|min:1',
        ]);
        
        $elementos = $request->elementos;
        $pesoMaximo = $request->peso_maximo;
        $caloriasMinimas = $request->calorias_minimas;
        
        $resultado = $this->optimizador->optimizar($elementos, $pesoMaximo, $caloriasMinimas);
        
        return response()->json([
            'success' => true,
            'resultado' => $resultado
        ]);
    }
}
