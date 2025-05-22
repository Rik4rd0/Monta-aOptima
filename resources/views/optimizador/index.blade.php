<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montaña Óptima - Optimizador de Elementos</title>
    
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8" x-data="optimizadorApp()">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">Montaña Óptima</h1>
            <p class="text-gray-600">Optimizador de elementos para excursionistas</p>
            
<a 
        href="/" 
        class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
        Volver a Inicio
    </a>
        </header>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Restricciones</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="peso_maximo" class="block text-sm font-medium text-gray-700 mb-1">
                        Peso máximo que se puede llevar
                    </label>
                    <input 
                        type="number" 
                        id="peso_maximo" 
                        x-model="pesoMaximo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        min="1"
                    >
                </div>
                <div>
                    <label for="calorias_minimas" class="block text-sm font-medium text-gray-700 mb-1">
                        Calorías mínimas requeridas
                    </label>
                    <input 
                        type="number" 
                        id="calorias_minimas" 
                        x-model="caloriasMinimas"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        min="1"
                    >
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Elementos disponibles</h2>
                <button 
                    @click="agregarElemento()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Agregar elemento
                </button>
            </div>
            
            <!-- Mensaje cuando no hay elementos -->
            <div x-show="elementos.length === 0" class="text-center py-8 text-gray-500">
                No hay elementos disponibles. Haga clic en "Agregar elemento" para comenzar.
            </div>
            
            <!-- Tabla de elementos -->
            <div x-show="elementos.length > 0" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calorías</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="(elemento, index) in elementos" :key="index">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="text" 
                                        x-model="elemento.id"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="text" 
                                        x-model="elemento.nombre"
                                        class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="number" 
                                        x-model="elemento.peso"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        min="0"
                                        step="0.1"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="number" 
                                        x-model="elemento.calorias"
                                        class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        min="0"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        @click="eliminarElemento(index)"
                                        class="text-red-600 hover:text-red-900 focus:outline-none"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="flex justify-center mb-8">
            <button 
                @click="calcular()"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                :disabled="cargando || elementos.length === 0"
            >
                <span x-show="!cargando">Calcular combinación óptima</span>
                <span x-show="cargando">Calculando...</span>
            </button>
        </div>
        
        <!-- Resultados -->
        <div x-show="resultado !== null" x-cloak class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Resultados</h2>
            
            <template x-if="resultado && resultado.combinaciones && resultado.combinaciones.length > 0">
                <div>
                    <div class="mb-4">
                        <p class="text-gray-700 font-medium" x-text="resultado.mensaje"></p>
                    </div>
                    
                    <div class="space-y-6">
                        <template x-for="(combinacion, idx) in resultado.combinaciones" :key="idx">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-800 mb-2">
                                    Combinación #<span x-text="idx + 1"></span>
                                </h3>
                                <div class="mb-3">
                                    <p class="text-gray-700">
                                        <span class="font-medium">Peso total:</span> 
                                        <span x-text="combinacion.pesoTotal"></span>
                                    </p>
                                    <p class="text-gray-700">
                                        <span class="font-medium">Calorías totales:</span> 
                                        <span x-text="combinacion.caloriasTotal"></span>
                                    </p>
                                </div>
                                
                                <h4 class="font-medium text-gray-700 mb-1">Elementos:</h4>
                                <ul class="list-disc pl-5">
                                    <template x-for="(elemento, index) in combinacion.elementos" :key="index">
                                        <li class="text-gray-700 mb-1">
                                            <span x-text="elemento.id"></span>: 
                                            <span x-text="elemento.nombre"></span> 
                                            (Peso: <span x-text="elemento.peso"></span>, 
                                            Calorías: <span x-text="elemento.calorias"></span>)
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            
            <template x-if="!resultado || !resultado.combinaciones || resultado.combinaciones.length === 0">
                <div class="p-4 bg-yellow-50 text-yellow-800 rounded-md">
                    <span x-text="resultado && resultado.mensaje ? resultado.mensaje : 'No se encontró una combinación que cumpla con los requisitos. Por favor, ajusta los parámetros.'"></span>
                </div>
            </template>
        </div>
    </div>
    
    <script src="{{ url('js/optimizador.js') }}"></script>
    <script>
        function optimizadorApp() {
            return {
                elementos: [],
                pesoMaximo: 10,
                caloriasMinimas: 15,
                resultado: null,
                cargando: false,
                
                // Función para verificar cálculos
                verificarCombinacion(elementos) {
                    // Calcular el peso total y calorías totales con precisión
                    let pesoTotal = 0;
                    let caloriasTotal = 0;
                    
                    for (const elemento of elementos) {
                        pesoTotal += parseFloat(elemento.peso || 0);
                        caloriasTotal += parseInt(elemento.calorias || 0);
                    }
                    
                    console.log('Verificando combinación:');
                    console.log('Elementos:', elementos);
                    console.log('Peso total calculado:', pesoTotal);
                    console.log('Calorías totales calculadas:', caloriasTotal);
                    
                    return {
                        pesoTotal: parseFloat(pesoTotal).toFixed(0),
                        caloriasTotal: caloriasTotal
                    };
                },
                
                agregarElemento() {
                    const nuevoId = `E${this.elementos.length + 1}`;
                    this.elementos.push({
                        id: nuevoId,
                        nombre: `Elemento ${this.elementos.length + 1}`,
                        peso: 0,
                        calorias: 0
                    });
                },
                
                eliminarElemento(index) {
                    this.elementos.splice(index, 1);
                },
                
                calcular() {
                    this.cargando = true;
                    this.resultado = null;
                    
                    if (this.elementos.length === 0) {
                        alert('Debe agregar al menos un elemento');
                        this.cargando = false;
                        return;
                    }
                    
                    if (!this.pesoMaximo || !this.caloriasMinimas) {
                        alert('Debe especificar el peso máximo y las calorías mínimas');
                        this.cargando = false;
                        return;
                    }
                    
                    // Usar el servicio de optimización con timeout para mostrar feedback de carga
                    setTimeout(() => {
                        try {
                            // Obtenemos todas las combinaciones válidas
                            this.resultado = OptimizadorService.optimizar(
                                this.elementos,
                                this.pesoMaximo,
                                this.caloriasMinimas
                            );
                            
                            if (this.resultado && this.resultado.combinaciones && this.resultado.combinaciones.length > 0) {
                                this.resultado.combinaciones.forEach(combinacion => {
                                    const verificacion = this.verificarCombinacion(combinacion.elementos);
                                    combinacion.pesoTotal = verificacion.pesoTotal;
                                    combinacion.caloriasTotal = verificacion.caloriasTotal;
                                });
                            }
                            
                            if (!this.resultado) {
                                this.resultado = { combinaciones: [], mensaje: "Error en el cálculo" };
                            }
                        } catch (error) {
                            console.error('Error al calcular las combinaciones válidas:', error);
                            alert('Ha ocurrido un error al calcular las combinaciones válidas');
                            this.resultado = { combinaciones: [], mensaje: "Error: " + error.message };
                        }
                        
                        this.cargando = false;
                    }, 500);
                }
            }
        }
    </script>
</body>
</html>