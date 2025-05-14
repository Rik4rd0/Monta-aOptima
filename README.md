# Montaña Óptima - Optimizador para Excursionistas

## Descripción del Proyecto
Montaña Óptima es una aplicación web diseñada para ayudar a excursionistas a optimizar la selección de elementos para escalar montañas, considerando restricciones de peso y requerimientos calóricos. El sistema encuentra todas las combinaciones posibles de elementos que satisfacen las restricciones especificadas, permitiendo a los usuarios tomar decisiones informadas sobre qué llevar en sus expediciones.

## Motivación y Enfoque de Diseño
Este proyecto fue desarrollado para resolver un problema común en excursionismo: optimizar el equipo llevado para maximizar su utilidad mientras se minimiza el peso. La aplicación fue implementada como una solución web para satisfacer los siguientes requerimientos:

- **Compatibilidad multiplataforma**: Funciona en Windows, Linux y macOS a través de cualquier navegador moderno.
- **Interoperabilidad**: Utiliza tecnologías web estándar para funcionar en múltiples plataformas.
- **Facilidad de mantenimiento**: Código modular con separación clara de responsabilidades.
- **Control de versiones**: Implementado utilizando Git/GitHub para facilitar el seguimiento y colaboración.
- **Persistencia de datos**: Información almacenable entre sesiones.
- **Escalabilidad**: Diseñada para manejar desde pequeñas listas de elementos hasta grandes inventarios.

## Tecnologías Utilizadas
- **Backend**: PHP/Laravel para el framework principal.
- **Frontend**: HTML, CSS, JavaScript con Alpine.js.
- **Estilos**: Tailwind CSS para una interfaz responsiva.
- **Algoritmo**: Implementación basada en fuerza bruta para encontrar combinaciones óptimas.

## Arquitectura de la Solución
La aplicación sigue una arquitectura MVC (Modelo-Vista-Controlador):

- **Modelo**: `OptimizadorService` (backend en PHP, frontend en JavaScript).
- **Vista**: Templates Blade con Alpine.js para interactividad.
- **Controlador**: Manejo de requests en Laravel y lógica de Alpine.js.

## Características Principales
- Interfaz de usuario intuitiva para ingresar elementos con sus pesos y valores calóricos.
- Configuración de restricciones (peso máximo permitido, calorías mínimas requeridas).
- Algoritmo de optimización que encuentra todas las combinaciones válidas.
- Visualización clara de resultados ordenados por eficiencia.
- Posibilidad de ajustar parámetros y recalcular soluciones.

## Instalación

```bash
# Clonar el repositorio
git clone https://github.com/Rik4rd0/Monta-aOptima.git

# Entrar al directorio
cd MontañaOptima

# Instalar dependencias
composer install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Ejecutar servidor de desarrollo
php artisan serve
```

## Uso
1. Accede a la aplicación a través de tu navegador.
2. Define el peso máximo permitido y las calorías mínimas requeridas.
3. Agrega los elementos con sus respectivos pesos y valores calóricos.
4. Haz clic en "Calcular combinación óptima".
5. Revisa las distintas combinaciones válidas que te ofrece el sistema.

## Decisiones de Diseño

### ¿Por qué mostrar todas las combinaciones?
A diferencia de un enfoque tradicional de algoritmos de optimización que solo mostrarían la "mejor" solución (la de menor peso), este sistema muestra todas las combinaciones válidas. Esto se implementó así porque:
- **Flexibilidad para el usuario**: Permite considerar otros factores no modelados en el algoritmo.
- **Transparencia**: Muestra el razonamiento detrás de las selecciones.
- **Adaptabilidad**: Permite adaptaciones según preferencias personales del excursionista.

### ¿Por qué usar un algoritmo de fuerza bruta?
Para conjuntos pequeños de elementos (como los típicamente usados en excursionismo), este enfoque es:
- **Preciso**: Garantiza encontrar todas las soluciones posibles.
- **Sencillo de entender**: Facilita el mantenimiento y modificaciones futuras.
- **Suficientemente eficiente**: Para el tamaño de problemas esperado (5-20 elementos).

Para conjuntos más grandes, se podría implementar una optimización basada en programación dinámica.

## Pseudocódigo de la Solución

```plaintext
ALGORITMO MontañaÓptima

ENTRADAS:
    elementos: Lista de objetos con {id, nombre, peso, calorías}
    pesoMáximo: Número decimal positivo
    caloríasMínimas: Número entero positivo

SALIDA:
    combinacionesVálidas: Lista de combinaciones que cumplen con las restricciones

INICIO
    // Validación de entradas
    SI elementos está vacío O pesoMáximo ≤ 0 O caloríasMínimas ≤ 0 ENTONCES
        RETORNAR lista vacía con mensaje de error
    FIN SI

    // Filtrar elementos válidos
    elementosVálidos ← FILTRAR elementos DONDE
        peso es número positivo Y
        calorías es número entero positivo

    SI elementosVálidos está vacío ENTONCES
        RETORNAR lista vacía con mensaje de error
    FIN SI

    combinacionesVálidas ← lista vacía
    n ← longitud de elementosVálidos
    totalCombinaciones ← 2^n - 1  // Excluimos el conjunto vacío

    // Generar todas las posibles combinaciones
    PARA i DESDE 1 HASTA totalCombinaciones HACER
        combinaciónActual ← lista vacía
        pesoTotal ← 0
        caloríasTotal ← 0

        // Construir combinación basada en representación binaria
        PARA j DESDE 0 HASTA n-1 HACER
            SI bit j de i está activado ENTONCES
                AGREGAR elementosVálidos[j] a combinaciónActual
                pesoTotal ← pesoTotal + elementosVálidos[j].peso
                caloríasTotal ← caloríasTotal + elementosVálidos[j].calorías
            FIN SI
        FIN PARA

        // Verificar restricciones
        SI pesoTotal ≤ pesoMáximo Y caloríasTotal ≥ caloríasMínimas ENTONCES
            AGREGAR {
                elementos: combinaciónActual,
                pesoTotal: pesoTotal,
                caloríasTotal: caloríasTotal
            } a combinacionesVálidas
        FIN SI
    FIN PARA

    // Ordenar resultados por peso (ascendente)
    ORDENAR combinacionesVálidas POR pesoTotal ASCENDENTE

    RETORNAR combinacionesVálidas con mensaje informativo
FIN
```

## Ejemplo de Aplicación
Para el conjunto de datos presentado en los requerimientos:

| Elemento | Peso | Calorías |
|----------|------|----------|
| E1       | 5    | 3        |
| E2       | 3    | 5        |
| E3       | 5    | 2        |
| E4       | 1    | 8        |
| E5       | 2    | 3        |

Con restricciones:
- **Peso máximo**: 10
- **Calorías mínimas**: 15

El sistema encontrará múltiples combinaciones válidas, incluyendo:
- **E2 + E4 + E5**: Peso 6, Calorías 16 (solución de menor peso).
- **E1 + E2 + E4**: Peso 9, Calorías 16 (combinación mencionada en el ejemplo).

## Evidencia de la Plataforma

La aplicación Montaña Óptima cuenta con una interfaz intuitiva y funcional que permite a los usuarios optimizar su equipamiento para excursiones.

### Página de Inicio

![Página de inicio de Montaña Óptima](docs/images/montana-optima-home.png)

La página principal presenta la aplicación con una imagen inspiradora de montañismo y explica el propósito del optimizador. Los usuarios pueden apreciar las características principales del sistema antes de comenzar a usarlo.

### Sección Informativa

![Sección informativa](docs/images/montana-optima-info.png)

Esta sección describe detalladamente qué es Montaña Óptima y presenta las características principales del sistema:
- Algoritmo avanzado de optimización
- Interfaz intuitiva y amigable
- Personalización de elementos
- Resultados visuales claros

### Herramienta de Optimización


![Herramienta de optimización](docs/images/montana-optima-tool.png)

La herramienta principal permite a los usuarios:
1. Establecer restricciones de peso máximo y calorías mínimas
2. Agregar elementos con sus respectivos pesos y valores calóricos
3. Calcular la combinación óptima según los parámetros establecidos

Los resultados se presentan de manera clara, mostrando todas las combinaciones válidas ordenadas por eficiencia, permitiendo al usuario tomar una decisión informada sobre qué elementos llevar en su excursión.



