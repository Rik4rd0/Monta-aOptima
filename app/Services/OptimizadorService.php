<?php

namespace App\Services;

class OptimizadorService
{
    /**
     * 
     * 
     * @param array $elementos Lista de elementos con peso y calorías
     * @param int $pesoMaximo Peso máximo que se puede llevar
     * @param int $caloriasMinimas Calorías mínimas requeridas
     * @return array Combinación óptima de elementos
     */
    public function optimizar(array $elementos, int $pesoMaximo, int $caloriasMinimas)
    {
        $n = count($elementos);
        
        // Si no hay elementos, no hay solución
        if ($n === 0) {
            return [
                'elementos' => [],
                'pesoTotal' => 0,
                'caloriasTotal' => 0
            ];
        }

        $combinacionesValidas = [];
        
        // Función para generar todas las combinaciones posibles usando bitmasks
        for ($mask = 0; $mask < (1 << $n); $mask++) {
            $combinacionActual = [];
            $pesoTotal = 0;
            $caloriasTotal = 0;
            
            for ($i = 0; $i < $n; $i++) {
                if ($mask & (1 << $i)) {
                    $combinacionActual[] = $elementos[$i];
                    $pesoTotal += $elementos[$i]['peso'];
                    $caloriasTotal += $elementos[$i]['calorias'];
                }
            }
            
            // Si la combinación cumple, lo guardamos
            if ($pesoTotal <= $pesoMaximo && $caloriasTotal >= $caloriasMinimas) {
                $combinacionesValidas[] = [
                    'elementos' => $combinacionActual,
                    'pesoTotal' => $pesoTotal,
                    'caloriasTotal' => $caloriasTotal
                ];
            }
        }
        
        if (empty($combinacionesValidas)) {
            return [
                'elementos' => [],
                'pesoTotal' => 0,
                'caloriasTotal' => 0
            ];
        }
        
        // Ordenar combinaciones válidas primero por peso (ascendente) y luego por calorías (descendente)
        usort($combinacionesValidas, function($a, $b) {
            if ($a['pesoTotal'] !== $b['pesoTotal']) {
                return $a['pesoTotal'] <=> $b['pesoTotal']; // Menor peso primero
            }
            return $b['caloriasTotal'] <=> $a['caloriasTotal']; // Mayor calorías primero en caso de empate
        });
        
        return $combinacionesValidas[0];
    }
}