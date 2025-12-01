// Variables del juego
let preguntas = [], preguntasDisponibles = [], preguntaActual = null, pasosUsuario = [];
let score = 0, currentDefense = 1, totalDefensas = 5, tiempo = 0, timerInterval = null;
let currentNumber = 0, numeroInicial = 0, fallos = 0, intentos = 0, numerosCompletados = 0;

// Cargar preguntas
async function loadQuestions() {
    const res = await fetch('/api/mathmatch/questions');
    const data = await res.json();
    if (data.success) {
        preguntas = preguntasDisponibles = data.preguntas;
        initGame();
    }
}

// Inicializar juego
function initGame(resetTimer = true) {
    if (!preguntas.length) return;
    if (!preguntasDisponibles.length) preguntasDisponibles = [...preguntas];
    
    preguntaActual = preguntasDisponibles.splice(Math.floor(Math.random() * preguntasDisponibles.length), 1)[0];
    numeroInicial = currentNumber = parseInt(preguntaActual.enunciado.match(/\d+/)[0]);
    pasosUsuario = [];
    currentDefense = 1;
    totalDefensas = String(preguntaActual.solucion_correcta).length;
    
    if (resetTimer) {
        score = 0;
        fallos = 0;
        intentos = 1;
        numerosCompletados = 0;
        tiempo = 0;
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            tiempo++;
            updateDisplay();
        }, 1000);
    } else {
        intentos++;
    }
    
    guardarCookies("intentos", intentos, 1);
    updateDisplay();
    showDefense();
}

// Actualizar pantalla
function updateDisplay() {
    document.getElementById('current-number').textContent = currentNumber;
    document.getElementById('score').textContent = score;
    document.getElementById('defense-level').textContent = `${currentDefense}/${totalDefensas}`;
    if (preguntaActual) document.getElementById('enunciado').textContent = preguntaActual.enunciado;
    
    const timer = document.getElementById('timer');
    timer.textContent = tiempo;
    timer.className = 'text-3xl font-bold text-blue-600';
    
    guardarCookies("tiempo", tiempo, 1);
                      
}

// Mostrar defensas
function showDefense() {
    const container = document.getElementById('defense-container');
    const stack = document.createElement('div');
    stack.id = 'defense-stack';
    stack.className = 'absolute top-1/2 transform -translate-y-1/2 transition-all duration-700 ease-out flex flex-col gap-4 items-center';
    
    // Calcular posición: de 10% a 98%
    const progreso = totalDefensas > 1 ? (currentDefense - 1) / (totalDefensas - 1) : 1;
    stack.style.left = `${10 + progreso * 88}%`;
    
    if (currentDefense < totalDefensas) {
        generarOpcionesAleatorias(currentNumber, obtenerDivisorMasPequeno(currentNumber))
            .forEach(opt => stack.appendChild(createDefenseCard(opt)));
    } else {
        [64, currentNumber, 64].forEach((item, i) => {
            const div = i === 1 ? createDefenseCard(item) : document.createElement('div');
            if (i !== 1) {
                div.className = 'w-32 opacity-0 pointer-events-none';
                div.style.height = item + 'px';
            }
            stack.appendChild(div);
        });
    }
    
    container.innerHTML = '';
    container.appendChild(stack);
}

// Obtener divisor más pequeño
function obtenerDivisorMasPequeno(num) {
    if (num <= 1) return 1;
    for (let i = 2; i <= Math.sqrt(num); i++) {
        if (num % i === 0) return i;
    }
    return num;
}

// Generar opciones aleatorias
function generarOpcionesAleatorias(num, correcta) {
    const opciones = new Set([correcta]);
    const primos = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47];
    const divisores = [];
    
    for (let i = 2; i <= Math.sqrt(num); i++) {
        if (num % i === 0) divisores.push(i, Math.floor(num / i));
    }
    
    while (opciones.size < 4) {
        const rand = Math.random();
        let dist = rand < 0.4 ? primos[~~(Math.random() * primos.length)] :
                   rand < 0.7 && divisores.length ? divisores.filter(d => d !== correcta && d > 1)[~~(Math.random() * divisores.length)] :
                   correcta + (Math.random() < 0.5 ? 1 : -1) * (~~(Math.random() * 5) + 1);
        
        if (dist > 1 && dist <= num) opciones.add(dist);
    }
    
    return Array.from(opciones).sort(() => Math.random() - 0.5);
}

// Crear carta de defensa
function createDefenseCard(number) {
    const div = document.createElement('div');
    div.className = 'relative cursor-pointer transform transition-all duration-300 hover:scale-110';
    div.innerHTML = `<div class="relative flex items-center justify-center">
        <img src="/img/Defensa_MathMatch.png" alt="Defensa" class="w-32 h-auto drop-shadow-2xl">
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-5xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">${number}</span>
        </div></div>`;
    div.onclick = () => selectOption(number);
    return div;
}

// Seleccionar opción
function selectOption(number) {
    document.querySelectorAll('#defense-stack [onclick]').forEach(opt => opt.style.pointerEvents = 'none');

    const divisorCorrecto = obtenerDivisorMasPequeno(currentNumber);
    if (number !== divisorCorrecto) {
        gameOver('wrong');
        return;
    }
    
    pasosUsuario.push(number);
    currentNumber /= number;
    score += 1;
    guardarCookies("puntos", score, 1);
    currentDefense++;
    updateDisplay();
    showSuccessAnimation();
    
    // Si completó 5 números, victoria automática
    if (pasosUsuario.length >= 5) {
        setTimeout(() => {
            document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/porteria_mathmatch.png')";
            setTimeout(showPenaltyScreen, 300);
        }, 500);
    } else if (currentDefense <= totalDefensas) {
        setTimeout(showDefense, 500);
    } else {
        // Si hay más defensas pero ya completó 5 pasos
        setTimeout(() => {
            document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/porteria_mathmatch.png')";
            setTimeout(showPenaltyScreen, 300);
        }, 500);
    }
}

// Verificar solución completa
function verificarSolucionCompleta() {
    // Verificar que el producto de todos los pasos sea igual al número inicial
    const producto = pasosUsuario.reduce((a, v) => a * v, 1);
    const correcto = producto === numeroInicial && currentNumber === 1;
    
    if (correcto) {
        document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/porteria_mathmatch.png')";
        setTimeout(showPenaltyScreen, 300);
    } else {
        gameOver('wrong');
    }
}

// Mostrar pantalla de penalti
function showPenaltyScreen() {
    document.getElementById('penalty-screen').classList.remove('hidden');
    const gk = document.getElementById('goalkeeper');
    gk.style.bottom = '25%';
    gk.style.left = '50%';
    gk.style.transform = 'translateX(-50%)';
}

// Tirar penalti
function shootPenalty(choice) {
    document.querySelectorAll('#penalty-screen button').forEach(btn => btn.disabled = true);
    const positions = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
    const gkChoice = positions[~~(Math.random() * positions.length)];
    moveGoalkeeper(gkChoice);
    
    setTimeout(() => {
        document.getElementById('penalty-screen').classList.add('hidden');
        document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/Campo_MathMatch.png')";
        
        if (choice === gkChoice) {
            // Portero paró el penalti - Game Over
            gameOver('goalkeeper');
        } else {
            score += 5;
            numerosCompletados++;
            guardarCookies("puntos", score, 1);
            updateDisplay();
            showGoalModal();
        }
        
        document.querySelectorAll('#penalty-screen button').forEach(btn => btn.disabled = false);
    }, 800);
}

// Mover portero
function moveGoalkeeper(pos) {
    const gk = document.getElementById('goalkeeper');
    const positions = {
        'top-left': { bottom: '45%', left: '15%' },
        'top-right': { bottom: '45%', left: '70%' },
        'bottom-left': { bottom: '15%', left: '15%' },
        'bottom-right': { bottom: '15%', left: '70%' }
    };
    const p = positions[pos];
    gk.style.bottom = p.bottom;
    gk.style.left = p.left;
    gk.style.transform = 'translateX(0)';
}

// Animación de éxito
function showSuccessAnimation() {
    const div = document.createElement('div');
    div.className = 'absolute inset-0 flex items-center justify-center pointer-events-none';
    div.innerHTML = '<div class="text-6xl font-bold text-green-500 animate-bounce">✓ +10</div>';
    document.getElementById('defense-container').appendChild(div);
    setTimeout(() => div.remove(), 500);
}

// Game Over
function gameOver(reason = 'wrong') {
    clearInterval(timerInterval);
    fallos = 1;
    guardarCookies("final", true, 1);
    
    // Ocultar elementos del juego
    document.getElementById('penalty-screen').classList.add('hidden');
    document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/Campo_MathMatch.png')";
    
    // Enviar datos al servidor
    enviarDatosAlServidor();
    
    // Actualizar y mostrar modal
    document.getElementById('final-score').textContent = score;
    document.getElementById('final-time').textContent = tiempo;
    document.getElementById('game-over-reason').textContent = reason === 'goalkeeper' ? '¡El portero paró tu penalti!' : 'Respuesta incorrecta';
    
    const modal = document.getElementById('game-over-modal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

// Mostrar modal de gol
function showGoalModal() {
    document.getElementById('goal-score').textContent = score;
    document.getElementById('goal-points').textContent = '+5 puntos';
    document.getElementById('goal-modal').classList.remove('hidden');
    
    // Enviar datos al servidor cuando completa un número
    enviarDatosAlServidor();
    
    setTimeout(() => {
        document.getElementById('goal-modal').classList.add('hidden');
        nextRound();
    }, 2000);
}

// Reiniciar juego
function restartGame() {
    const modal = document.getElementById('game-over-modal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    preguntasDisponibles = [...preguntas];
    initGame(true);
}

// Siguiente ronda
function nextRound() {
    document.getElementById('goal-modal').classList.add('hidden');
    initGame(false);
}

function enviarDatosAlServidor() {
    const csrfToken = document.querySelector('meta[name="csrf-token"')?.getAttribute('content');
    
    const datosJuego = {
        tiempo: tiempo,
        puntos: score,
        fallos: fallos,
        intentos: intentos,
        numerosCompletados: numerosCompletados,
        id_juego: 3 
    };

    fetch('/guardar-sesion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            body: JSON.stringify(datosJuego)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Sesión guardada:', data);
        })
    .catch(error => {
        console.error('Error al guardar la sesión:', error);
    });
}

// Guardar cookies
function guardarCookies(nombre, valor, dias) {
    const estado = {
        tiempo: tiempo,
        puntos: score,
        fallos: fallos,
        intentos: intentos,
        numerosCompletados: numerosCompletados
    };
    const fecha = new Date();
    fecha.setTime(fecha.getTime() + 1 * 24 * 60 * 60 * 1000); // 1 día
    document.cookie = "mathmatch=" + JSON.stringify(estado) + ";expires=" + fecha.toUTCString() + ";path=/";
}

// Leer cookie
function leerCookie() {
    const nombreCookie = "mathmatch=";
    const contenido = document.cookie.split(';');
    for (let i = 0; i < contenido.length; i++) {
        let cookieCompleta = contenido[i].trim();
        if (cookieCompleta.indexOf(nombreCookie) === 0) {
            const estadoStr = cookieCompleta.substring(nombreCookie.length);
            const valorCookie = JSON.parse(estadoStr);
            return valorCookie;
        }
    }
    return null;
}  
