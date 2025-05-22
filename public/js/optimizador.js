const OptimizadorService = {
    /**
     * 
     * @param {Array} elementos - Lista de elementos disponibles
     * @param {Number} pesoMaximo - Peso máximo permitido
     * @param {Number} caloriasMinimas - Calorías mínimas requeridas
     * @return {Object} Resultado con todas las combinaciones válidas
     */
    optimizar(elementos, pesoMaximo, caloriasMinimas) {
        try {
            // Validar los datos de entrada
            if (!elementos || elementos.length === 0 || !pesoMaximo || !caloriasMinimas) {
                return { 
                    combinaciones: [],
                    mensaje: "Datos de entrada no válidos"
                };
            }

            const elementosValidos = elementos.filter(e => 
                !isNaN(parseFloat(e.peso)) && 
                !isNaN(parseInt(e.calorias)) && 
                parseFloat(e.peso) > 0 && 
                parseInt(e.calorias) > 0
            );

            if (elementosValidos.length === 0) {
                return { 
                    combinaciones: [],
                    mensaje: "No hay elementos válidos para procesar"
                };
            }

            // Convertir valores a números
            const elementosNormalizados = elementosValidos.map(e => ({
                ...e,
                peso: parseFloat(e.peso),
                calorias: parseInt(e.calorias)
            }));

            const combinacionesValidas = [];

            // Generar todas las posibles combinaciones (2^n)
            const totalCombinaciones = Math.pow(2, elementosNormalizados.length);
            
            for (let i = 1; i < totalCombinaciones; i++) {

                const elementosCombinacion = [];
                let pesoTotal = 0;
                let caloriasTotal = 0;
                
                for (let j = 0; j < elementosNormalizados.length; j++) {
                    if (i & (1 << j)) {
                        elementosCombinacion.push(elementosNormalizados[j]);
                        pesoTotal += elementosNormalizados[j].peso;
                        caloriasTotal += elementosNormalizados[j].calorias;
                    }
                }
                
                if (pesoTotal <= pesoMaximo && caloriasTotal >= caloriasMinimas) {
                    combinacionesValidas.push({
                        elementos: elementosCombinacion,
                        pesoTotal: pesoTotal.toFixed(1),
                        caloriasTotal: caloriasTotal
                    });
                }
            }

            if (combinacionesValidas.length === 0) {
                return { 
                    combinaciones: [],
                    mensaje: "No se encontraron combinaciones que cumplan con las restricciones"
                };
            }
            
            combinacionesValidas.sort((a, b) => {
                return parseFloat(a.pesoTotal) - parseFloat(b.pesoTotal);
            });
            
            // Devolvemos todas las combinaciones válidas
            return {
                combinaciones: combinacionesValidas,
                mensaje: `Se encontraron ${combinacionesValidas.length} combinaciones válidas`
            };
        } catch (error) {
            console.error("Error en OptimizadorService:", error);
            return {
                combinaciones: [],
                mensaje: "Error en el proceso de optimización: " + error.message
            };
        }
    }
};

if (typeof module !== 'undefined' && module.exports) {
    module.exports = OptimizadorService;
}