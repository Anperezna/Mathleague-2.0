// MathMatch - Juego de factorización con defensas
let currentNumber = 64;
let score = 0;
let currentDefense = 1;
let divisorChain = [];
let correctDivisor = null;
let timeRemaining = 60; // Segundos restantes
let timerInterval = null; // Intervalo del temporizador

// Posiciones horizontales de las defensas (de izquierda a derecha)
const defensePositions = [
    { left: '10%', label: 'Tu Área' },           // Defensa 1
    { left: '28%', label: 'Medio Campo Propio' }, // Defensa 2
    { left: '46%', label: 'Centro' },            // Defensa 3
    { left: '64%', label: 'Medio Campo Rival' }, // Defensa 4
    { left: '98%', label: 'Portería Rival' }     // Defensa 5 - En la portería
];

/**
 * Generar cadena de divisores (4 divisores que multiplicados dan el número inicial)
 * Evita números primos de primeras generando números con varios factores
 */
function generateDivisorChain() {
    const chain = [];
    const length = 4;
    
    // Estrategia: generar números compuestos con múltiples factores (más complejos)
    const smallPrimes = [2, 3, 5, 7];
    const mediumPrimes = [11, 13];
    
    const strategies = [
        // Estrategia 1: Números pequeños y medianos mezclados (ej: 2,3,7,5 = 210)
        () => {
            const arr = [];
            for (let i = 0; i < length; i++) {
                if (i < 2) {
                    arr.push(smallPrimes[Math.floor(Math.random() * smallPrimes.length)]);
                } else {
                    arr.push(smallPrimes[Math.floor(Math.random() * 3)]); // Solo 2, 3, 5
                }
            }
            return arr;
        },
        // Estrategia 2: Potencias variadas (ej: 2,2,3,5 = 60)
        () => {
            const arr = [];
            const base = smallPrimes[Math.floor(Math.random() * 3)]; // 2, 3, o 5
            arr.push(base, base); // Dos veces el mismo
            arr.push(smallPrimes[Math.floor(Math.random() * smallPrimes.length)]);
            arr.push(smallPrimes[Math.floor(Math.random() * smallPrimes.length)]);
            return arr;
        },
        // Estrategia 3: Con un número mediano (ej: 2,3,5,11 = 330)
        () => {
            const arr = [];
            arr.push(mediumPrimes[Math.floor(Math.random() * mediumPrimes.length)]);
            for (let i = 1; i < length; i++) {
                arr.push(smallPrimes[Math.floor(Math.random() * 3)]); // 2, 3, 5
            }
            return arr;
        },
        // Estrategia 4: Mix completo (ej: 3,5,7,2 = 210)
        () => {
            const arr = [];
            for (let i = 0; i < length; i++) {
                arr.push(smallPrimes[Math.floor(Math.random() * smallPrimes.length)]);
            }
            return arr;
        }
    ];
    
    // Elegir una estrategia aleatoria
    const strategy = strategies[Math.floor(Math.random() * strategies.length)];
    const result = strategy();
    
    // Mezclar para que no sean predecibles
    return result.sort(() => Math.random() - 0.5);
}

/**
 * Inicializar juego
 */
function initGame() {
    divisorChain = generateDivisorChain();
    currentNumber = divisorChain.reduce((a, b) => a * b, 1);
    score = 0;
    currentDefense = 1;
    timeRemaining = 60;
    
    // Limpiar intervalo anterior si existe
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    // Iniciar temporizador
    timerInterval = setInterval(() => {
        timeRemaining--;
        updateDisplay();
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            gameOver('time');
        }
    }, 1000);
    
    updateDisplay();
    showDefense();
}

/**
 * Actualizar pantalla
 */
function updateDisplay() {
    document.getElementById('current-number').textContent = currentNumber;
    document.getElementById('score').textContent = score;
    document.getElementById('defense-level').textContent = `${currentDefense}/5`;
    
    // Actualizar temporizador
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        timerElement.textContent = timeRemaining;
        // Cambiar color si quedan menos de 10 segundos
        if (timeRemaining <= 10) {
            timerElement.classList.add('text-red-600');
            timerElement.classList.remove('text-orange-600');
        } else if (timeRemaining <= 20) {
            timerElement.classList.add('text-orange-600');
            timerElement.classList.remove('text-red-600');
        } else {
            timerElement.classList.remove('text-red-600', 'text-orange-600');
        }
    }
}

/**
 * Mostrar defensa actual - Todas las defensas en vertical en el lado izquierdo, avanzando horizontalmente
 */
function showDefense() {
    const container = document.getElementById('defense-container');
    container.innerHTML = '';
    
    // Crear contenedor vertical para todas las defensas
    const verticalStack = document.createElement('div');
    verticalStack.className = 'absolute top-1/2 transform -translate-y-1/2 transition-all duration-700 ease-out';
    verticalStack.style.left = defensePositions[currentDefense - 1].left;
    verticalStack.id = 'defense-stack';
    
    // Contenedor flex vertical
    const stackContainer = document.createElement('div');
    stackContainer.className = 'flex flex-col gap-4 items-center';

    if (currentDefense <= 5) {
        // Defensas 1-5: mostrar 3 opciones
        correctDivisor = divisorChain[currentDefense - 1];
        const options = generateOptions(correctDivisor, currentNumber);
        
        options.forEach((option) => {
            const defenseDiv = createDefenseCard(option, option === correctDivisor);
            stackContainer.appendChild(defenseDiv);
        });
    } else {
        // Defensa 5: solo mostrar opción 1 (mantener tamaño con defensas invisibles)
        // Defensa invisible superior
        const emptyTop = document.createElement('div');
        emptyTop.className = 'w-32 h-auto opacity-0 pointer-events-none';
        emptyTop.style.height = '128px'; // Mismo alto aproximado que una defensa
        stackContainer.appendChild(emptyTop);
        
        // Defensa con el 1 (opción correcta)
        const goalOption = createDefenseCard(1, true);
        stackContainer.appendChild(goalOption);
        
        // Defensa invisible inferior
        const emptyBottom = document.createElement('div');
        emptyBottom.className = 'w-32 h-auto opacity-0 pointer-events-none';
        emptyBottom.style.height = '128px';
        stackContainer.appendChild(emptyBottom);
    }
    
    verticalStack.appendChild(stackContainer);
    container.appendChild(verticalStack);
}

/**
 * Generar opciones (1 correcta + 3 distractores = 4 opciones totales)
 * Mejorado para evitar números primos y generar distractores más inteligentes
 */
function generateOptions(correct, currentNum) {
    const options = [correct];
    const used = new Set([correct]);
    
    // Obtener todos los divisores del número actual
    const allDivisors = getDivisors(currentNum);
    allDivisors.push(currentNum); // Agregar el número mismo como divisor

    // Generar distractores (ahora 3 en lugar de 2)
    while (options.length < 4) {
        let distractor;
        const rand = Math.random();
        
        if (rand < 0.5 && allDivisors.length > 0) {
            // 50% de probabilidad: usar un divisor real pero incorrecto
            const filteredDivisors = allDivisors.filter(d => d !== correct && d > 1);
            if (filteredDivisors.length > 0) {
                distractor = filteredDivisors[Math.floor(Math.random() * filteredDivisors.length)];
            } else {
                distractor = correct + 1;
            }
        } else if (rand < 0.75) {
            // 25%: número cercano al correcto
            const offset = Math.floor(Math.random() * 3) + 1;
            distractor = correct + (Math.random() < 0.5 ? offset : -offset);
        } else {
            // 25%: múltiplo del correcto
            const multiplier = Math.floor(Math.random() * 3) + 2;
            distractor = correct * multiplier;
        }

        // Validar que el distractor sea válido
        if (distractor > 1 && !used.has(distractor) && distractor <= currentNum * 2) {
            options.push(distractor);
            used.add(distractor);
        }
    }

    // Mezclar opciones
    return options.sort(() => Math.random() - 0.5);
}

/**
 * Obtener divisores de un número
 */
function getDivisors(num) {
    const divisors = [];
    for (let i = 2; i <= Math.sqrt(num); i++) {
        if (num % i === 0) {
            divisors.push(i);
            if (i !== num / i && num / i !== num) {
                divisors.push(num / i);
            }
        }
    }
    return divisors;
}

/**
 * Crear tarjeta de defensa - Los números aparecen sin fondo circular
 */
function createDefenseCard(number, isCorrect) {
    const div = document.createElement('div');
    div.className = 'relative cursor-pointer transform transition-all duration-300 hover:scale-110';
    div.innerHTML = `
        <div class="relative flex items-center justify-center">
            <img src="/img/Defensa_MathMatch.png" alt="Defensa" class="w-32 h-auto drop-shadow-2xl">
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-5xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">${number}</span>
            </div>
        </div>
    `;
    
    div.onclick = () => selectOption(number, isCorrect, div);
    return div;
}

/**
 * Seleccionar opción
 */
function selectOption(number, isCorrect, selectedDiv) {
    if (!isCorrect) {
        // Opción incorrecta - Game Over
        gameOver();
        return;
    }

    // Deshabilitar clicks durante la animación
    const allOptions = document.querySelectorAll('#defense-stack [onclick]');
    allOptions.forEach(opt => opt.style.pointerEvents = 'none');

    if (currentDefense <= 4) {
        // Dividir el número
        currentNumber = currentNumber / number;
        score += 10;
        currentDefense++;
        updateDisplay();
        
        // Animación de éxito
        showSuccessAnimation();
        
        // Avanzar horizontalmente después de la animación
        setTimeout(() => {
            showDefense();
        }, 500);
    } else {
        // Defensa 5 - Gol!
        score += 50;
        updateDisplay();
        
        // Animación de gol
        setTimeout(() => {
            showGoalModal();
        }, 500);
    }
}

/**
 * Mostrar animación de éxito
 */
function showSuccessAnimation() {
    const container = document.getElementById('defense-container');
    const successDiv = document.createElement('div');
    successDiv.className = 'absolute inset-0 flex items-center justify-center pointer-events-none';
    successDiv.innerHTML = `
        <div class="text-6xl font-bold text-green-500 animate-bounce">
            ✓ +10
        </div>
    `;
    container.appendChild(successDiv);
    
    setTimeout(() => {
        successDiv.remove();
    }, 500);
}

/**
 * Game Over
 */
function gameOver(reason = 'wrong') {
    // Limpiar temporizador
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    document.getElementById('final-score').textContent = score;
    document.getElementById('defenses-passed').textContent = currentDefense - 1;
    
    const reasonElement = document.getElementById('game-over-reason');
    if (reasonElement) {
        if (reason === 'time') {
            reasonElement.textContent = '¡Se acabó el tiempo!';
        } else {
            reasonElement.textContent = 'Respuesta incorrecta';
        }
    }
    
    document.getElementById('game-over-modal').classList.remove('hidden');
}

/**
 * Mostrar modal de gol
 */
function showGoalModal() {
    // Limpiar temporizador
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    document.getElementById('goal-score').textContent = score;
    document.getElementById('goal-modal').classList.remove('hidden');
}

/**
 * Reiniciar juego
 */
function restartGame() {
    document.getElementById('game-over-modal').classList.add('hidden');
    initGame();
}

/**
 * Siguiente ronda
 */
function nextRound() {
    document.getElementById('goal-modal').classList.add('hidden');
    initGame();
}

// Iniciar al cargar
window.addEventListener('DOMContentLoaded', initGame);
