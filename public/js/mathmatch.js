// MathMatch - Juego de factorización con defensas
let preguntas = [], preguntasDisponibles = [], preguntaActual = null, pasosUsuario = [];
let score = 0, currentDefense = 1, totalDefensas = 5, timeRemaining = 40, timerInterval = null;
let currentNumber = 0, numeroInicial = 0;

async function loadQuestions() {
    try {
        const { success, preguntas: data } = await (await fetch('/api/mathmatch/questions')).json();
        if (success) {
            preguntas = preguntasDisponibles = data;
            initGame();
        }
    } catch (error) {
        console.error('Error al cargar preguntas:', error);
    }
}

function initGame(resetTimer = true) {
    if (!preguntas.length) return;
    if (!preguntasDisponibles.length) preguntasDisponibles = [...preguntas];
    
    const indice = Math.floor(Math.random() * preguntasDisponibles.length);
    preguntaActual = preguntasDisponibles.splice(indice, 1)[0];
    
    numeroInicial = currentNumber = parseInt(preguntaActual.enunciado.match(/\d+/)?.[0] || 0);
    pasosUsuario = [];
    currentDefense = 1;
    totalDefensas = String(preguntaActual.solucion_correcta).length;
    
    if (resetTimer) {
        score = 0;
        timeRemaining = 40;
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            if (--timeRemaining <= 0) {
                clearInterval(timerInterval);
                gameOver('time');
            }
            updateDisplay();
        }, 1000);
    }
    
    updateDisplay();
    showDefense();
}

function updateDisplay() {
    document.getElementById('current-number').textContent = currentNumber;
    document.getElementById('score').textContent = score;
    document.getElementById('defense-level').textContent = `${currentDefense}/${totalDefensas}`;
    if (preguntaActual) document.getElementById('enunciado').textContent = preguntaActual.enunciado;
    
    const timer = document.getElementById('timer');
    timer.textContent = timeRemaining;
    timer.className = timeRemaining <= 10 ? 'text-3xl font-bold text-red-600' : 
                      timeRemaining <= 20 ? 'text-3xl font-bold text-orange-600' : 
                      'text-3xl font-bold text-blue-600';
}

function showDefense() {
    const container = document.getElementById('defense-container');
    const stack = document.createElement('div');
    stack.id = 'defense-stack';
    stack.className = 'absolute top-1/2 transform -translate-y-1/2 transition-all duration-700 ease-out flex flex-col gap-4 items-center';
    stack.style.left = `${10 + ((currentDefense - 1) / (totalDefensas - 1)) * 88}%`;
    
    if (currentDefense < totalDefensas) {
        const correctOption = obtenerDivisorMasPequeno(currentNumber);
        generarOpcionesAleatorias(currentNumber, correctOption).forEach(opt => 
            stack.appendChild(createDefenseCard(opt))
        );
    } else {
        ['64px', currentNumber, '64px'].forEach(item => {
            const div = typeof item === 'number' ? createDefenseCard(item) : 
                document.createElement('div');
            if (typeof item === 'string') {
                div.className = 'w-32 opacity-0 pointer-events-none';
                div.style.height = item;
            }
            stack.appendChild(div);
        });
    }
    
    container.innerHTML = '';
    container.appendChild(stack);
}

function obtenerDivisorMasPequeno(num) {
    if (num <= 1) return 1;
    for (let i = 2; i <= Math.sqrt(num); i++) {
        if (num % i === 0) return i;
    }
    return num;
}

function generarOpcionesAleatorias(numeroActual, opcionCorrecta) {
    const opciones = new Set([opcionCorrecta]);
    const primos = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47];
    const divisores = [];
    
    for (let i = 2; i <= Math.sqrt(numeroActual); i++) {
        if (numeroActual % i === 0) {
            divisores.push(i, Math.floor(numeroActual / i));
        }
    }
    
    while (opciones.size < 4) {
        const rand = Math.random();
        let distractor = rand < 0.4 ? primos[Math.floor(Math.random() * primos.length)] :
                        rand < 0.7 && divisores.length ? divisores.filter(d => d !== opcionCorrecta && d > 1)[Math.floor(Math.random() * divisores.length)] :
                        opcionCorrecta + (Math.random() < 0.5 ? 1 : -1) * (Math.floor(Math.random() * 5) + 1);
        
        if (distractor > 1 && distractor <= numeroActual) opciones.add(distractor);
    }
    
    return Array.from(opciones).sort(() => Math.random() - 0.5);
}

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

function selectOption(number) {
    document.querySelectorAll('#defense-stack [onclick]').forEach(opt => opt.style.pointerEvents = 'none');

    if (currentDefense < totalDefensas) {
        const divisorCorrecto = obtenerDivisorMasPequeno(currentNumber);
        if (number !== divisorCorrecto) return gameOver('wrong');
        
        pasosUsuario.push(number);
        currentNumber /= number;
        score += 10;
        currentDefense++;
        updateDisplay();
        showSuccessAnimation();
        setTimeout(showDefense, 500);
    } else {
        if (number !== currentNumber) return gameOver('wrong');
        pasosUsuario.push(number);
        currentNumber /= number;
        score += 50;
        updateDisplay();
        verificarSolucionCompleta();
    }
}

function verificarSolucionCompleta() {
    const solucionCorrecta = String(preguntaActual.solucion_correcta).split('').map(Number);
    const verificacion = pasosUsuario.reduce((acc, val) => acc * val, 1);
    
    const esCorrecto = verificacion === numeroInicial && 
                      pasosUsuario.length === solucionCorrecta.length &&
                      pasosUsuario.every((paso, i) => paso === solucionCorrecta[i]);
    
    esCorrecto ? showGoalModal() : gameOver('wrong');
}

function showSuccessAnimation() {
    const div = document.createElement('div');
    div.className = 'absolute inset-0 flex items-center justify-center pointer-events-none';
    div.innerHTML = '<div class="text-6xl font-bold text-green-500 animate-bounce">✓ +10</div>';
    document.getElementById('defense-container').appendChild(div);
    setTimeout(() => div.remove(), 500);
}

function gameOver(reason = 'wrong') {
    clearInterval(timerInterval);
    document.getElementById('final-score').textContent = score;
    document.getElementById('defenses-passed').textContent = `${currentDefense - 1}/${totalDefensas}`;
    document.getElementById('game-over-reason').textContent = 
        reason === 'time' ? '¡Se acabó el tiempo!' : 'Respuesta incorrecta';
    document.getElementById('game-over-modal').classList.remove('hidden');
}

function showGoalModal() {
    document.getElementById('goal-score').textContent = score;
    document.getElementById('goal-modal').classList.remove('hidden');
    setTimeout(nextRound, 2000);
}

function restartGame() {
    document.getElementById('game-over-modal').classList.add('hidden');
    preguntasDisponibles = [...preguntas];
    initGame(true);
}

function nextRound() {
    document.getElementById('goal-modal').classList.add('hidden');
    initGame(false);
}

// No cargar automáticamente, esperar a que el menú inicie el juego
