// Variables del juego
let preguntas = [], preguntasDisponibles = [], preguntaActual = null, pasosUsuario = [];
let puntuacion = 0, defensaActual = 1, totalDefensas = 5, tiempo = 0, intervaloTemporizador = null;
let numeroActual = 0, numeroInicial = 0, fallos = 0, intentos = 0, numerosCompletados = 0;

// Inicializar juego
function inicializarJuego(reiniciarTemporizador = true) {
    if (!preguntas.length && window.preguntas) preguntas = preguntasDisponibles = window.preguntas;
    if (!preguntas.length) return;
    if (!preguntasDisponibles.length) preguntasDisponibles = [...preguntas];
    
    preguntaActual = preguntasDisponibles.splice(Math.floor(Math.random() * preguntasDisponibles.length), 1)[0];
    numeroInicial = numeroActual = parseInt(preguntaActual.enunciado.match(/\d+/)[0]);
    pasosUsuario = [];
    defensaActual = 1;

    // Calcular el número total de factores primos (defensas)
    totalDefensas = contarFactoresPrimos(numeroInicial);
    
    if (reiniciarTemporizador) {
        puntuacion = fallos = numerosCompletados = tiempo = 0;
        intentos = 1;
        clearInterval(intervaloTemporizador);
        intervaloTemporizador = setInterval(() => { tiempo++; actualizarPantalla(); }, 1000);
    } else {
        intentos++;
    }
    
    guardarCookies("intentos", intentos, 1);
    actualizarPantalla();
    mostrarDefensa();
}

// Actualizar pantalla
function actualizarPantalla() {
    document.getElementById('current-number').textContent = numeroActual;
    document.getElementById('score').textContent = puntuacion;
    document.getElementById('defense-level').textContent = defensaActual + '/' + totalDefensas;
    if (preguntaActual) document.getElementById('enunciado').textContent = preguntaActual.enunciado;
    document.getElementById('timer').textContent = tiempo;
    guardarCookies("tiempo", tiempo, 1);
}

// Mostrar defensas
function mostrarDefensa() {
    const container = document.getElementById('defense-container');
    const stack = document.createElement('div');
    stack.id = 'defense-stack';
    stack.className = 'absolute top-1/2 transform -translate-y-1/2 transition-all duration-700 ease-out flex flex-col gap-4 items-center';
    
    const progreso = totalDefensas > 1 ? (defensaActual - 1) / (totalDefensas - 1) : 1;
    stack.style.left = (10 + progreso * 88) + '%';
    
    if (defensaActual < totalDefensas) {
        generarOpcionesAleatorias(numeroActual, obtenerDivisorMasPequeno(numeroActual))
            .forEach(opt => stack.appendChild(crearTarjetaDefensa(opt)));
    } else {
        [64, numeroActual, 64].forEach((item, i) => {
            const div = i === 1 ? crearTarjetaDefensa(item) : document.createElement('div');
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

// Contar factores primos (número de pasos necesarios)
function contarFactoresPrimos(num) {
    let count = 0;
    let n = num;
    for (let i = 2; i <= n && n > 1; i++) {
        while (n % i === 0) {
            count++;
            n /= i;
        }
    }
    return count;
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
        let dist;
        if (rand < 0.4) {
            dist = primos[Math.floor(Math.random() * primos.length)];
        } else if (rand < 0.7 && divisores.length) {
            const validos = divisores.filter(d => d !== correcta && d > 1);
            dist = validos[Math.floor(Math.random() * validos.length)];
        } else {
            dist = correcta + (Math.random() < 0.5 ? 1 : -1) * (Math.floor(Math.random() * 5) + 1);
        }
        
        if (dist > 1 && dist <= num) opciones.add(dist);
    }
    
    return Array.from(opciones).sort(() => Math.random() - 0.5);
}

// Crear carta de defensa
function crearTarjetaDefensa(numero) {
    const div = document.createElement('div');
    div.className = 'relative cursor-pointer transform transition-all duration-300 hover:scale-110';
    div.innerHTML = '<div class="relative flex items-center justify-center"><img src="/img/Defensa_MathMatch.png" alt="Defensa" class="w-32 h-auto drop-shadow-2xl"><div class="absolute inset-0 flex items-center justify-center"><span class="text-5xl font-bold text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">' + numero + '</span></div></div>';
    div.onclick = () => seleccionarOpcion(numero);
    return div;
}

// Seleccionar opción
function seleccionarOpcion(numero) {
    document.querySelectorAll('#defense-stack [onclick]').forEach(opt => opt.style.pointerEvents = 'none');

    if (numero !== obtenerDivisorMasPequeno(numeroActual)) {
        finalizarJuego('wrong');
        return;
    }
    
    pasosUsuario.push(numero);
    numeroActual /= numero;
    puntuacion++;
    guardarCookies("puntos", puntuacion, 1);
    defensaActual++;
    actualizarPantalla();
    mostrarAnimacionExito();
    
    // Verificar si ya completó todos los pasos necesarios
    if (pasosUsuario.length >= totalDefensas) {
        setTimeout(() => {
            cambiarFondo('porteria');
            setTimeout(mostrarPantallaPenalti, 300);
        }, 500);
    } else {
        setTimeout(mostrarDefensa, 500);
    }
}

// Cambiar fondo del juego
function cambiarFondo(tipo) {
    const img = tipo === 'porteria' ? 'porteria_mathmatch.png' : 'Campo_MathMatch.png';
    document.querySelector('#gameScreen > div').style.backgroundImage = "url('/img/" + img + "')";
}

// Verificar solución completa
function verificarSolucionCompleta() {
    const producto = pasosUsuario.reduce((a, v) => a * v, 1);
    if (producto === numeroInicial && numeroActual === 1) {
        cambiarFondo('porteria');
        setTimeout(mostrarPantallaPenalti, 300);
    } else {
        finalizarJuego('wrong');
    }
}

// Mostrar pantalla de penalti
function mostrarPantallaPenalti() {
    document.getElementById('penalty-screen').classList.remove('hidden');
    const gk = document.getElementById('goalkeeper');
    gk.style.bottom = '25%';
    gk.style.left = '50%';
    gk.style.transform = 'translateX(-50%)';
}

// Tirar penalti
function tirarPenalti(eleccion) {
    const botones = document.querySelectorAll('#penalty-screen button');
    botones.forEach(btn => btn.disabled = true);
    
    const posiciones = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
    const eleccionPortero = posiciones[Math.floor(Math.random() * 4)];
    moverPortero(eleccionPortero);
    
    setTimeout(() => {
        document.getElementById('penalty-screen').classList.add('hidden');
        cambiarFondo('campo');
        
        if (eleccion === eleccionPortero) {
            finalizarJuego('goalkeeper');
        } else {
            puntuacion += 5;
            numerosCompletados++;
            guardarCookies("puntos", puntuacion, 1);
            actualizarPantalla();
            mostrarModalGol();
        }
        
        botones.forEach(btn => btn.disabled = false);
    }, 800);
}

// Mover portero
function moverPortero(posicion) {
    const portero = document.getElementById('goalkeeper');
    const posiciones = {
        'top-left': { bottom: '45%', left: '15%' },
        'top-right': { bottom: '45%', left: '70%' },
        'bottom-left': { bottom: '15%', left: '15%' },
        'bottom-right': { bottom: '15%', left: '70%' }
    };
    const p = posiciones[posicion];
    portero.style.bottom = p.bottom;
    portero.style.left = p.left;
    portero.style.transform = 'translateX(0)';
}

// Animación de éxito
function mostrarAnimacionExito() {
    const div = document.createElement('div');
    div.className = 'absolute inset-0 flex items-center justify-center pointer-events-none';
    div.innerHTML = '<div class="text-6xl font-bold text-green-500 animate-bounce">✓ +10</div>';
    document.getElementById('defense-container').appendChild(div);
    setTimeout(() => div.remove(), 500);
}

// Finalizar juego
function finalizarJuego(razon = 'wrong') {
    clearInterval(intervaloTemporizador);
    fallos = 1;
    guardarCookies("final", true, 1);
    
    document.getElementById('penalty-screen').classList.add('hidden');
    cambiarFondo('campo');
    enviarDatosAlServidor();
    
    document.getElementById('final-score').textContent = puntuacion;
    document.getElementById('final-time').textContent = tiempo;
    document.getElementById('game-over-reason').textContent = razon === 'goalkeeper' ? '¡El portero paró tu penalti!' : 'Respuesta incorrecta';
    
    const modal = document.getElementById('game-over-modal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

// Mostrar modal de gol
function mostrarModalGol() {
    document.getElementById('goal-score').textContent = puntuacion;
    document.getElementById('goal-modal').classList.remove('hidden');
    enviarDatosAlServidor();
    
    // Verificar si completó 4 números
    if (numerosCompletados >= 4) {
        setTimeout(() => {
            document.getElementById('goal-modal').classList.add('hidden');
            mostrarModalVictoria();
        }, 2000);
    } else {
        setTimeout(() => {
            document.getElementById('goal-modal').classList.add('hidden');
            siguienteRonda();
        }, 2000);
    }
}

function mostrarModalVictoria() {
    clearInterval(intervaloTemporizador);
    enviarDatosAlServidor();
    
    document.getElementById('final-score').textContent = puntuacion;
    document.getElementById('final-time').textContent = tiempo;
    document.getElementById('game-over-reason').textContent = '¡Completaste 4 números!';
    
    const modal = document.getElementById('game-over-modal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

// Reiniciar juego
function reiniciarJuego() {
    const modal = document.getElementById('game-over-modal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    preguntasDisponibles = [...preguntas];
    inicializarJuego(true);
}

// Siguiente ronda
function siguienteRonda() {
    document.getElementById('goal-modal').classList.add('hidden');
    inicializarJuego(false);
}

function enviarDatosAlServidor() {
    const csrfToken = document.querySelector('meta[name="csrf-token"')?.getAttribute('content');
    
    const datosJuego = {
        tiempo: tiempo,
        puntos: puntuacion,
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
        puntos: puntuacion,
        fallos: fallos,
        intentos: intentos,
        numerosCompletados: numerosCompletados
    };
    const fecha = new Date();
    fecha.setTime(fecha.getTime() + 1 * 24 * 60 * 60 * 1000); // 1 día
    document.cookie = "mathmatch=" + JSON.stringify(estado) + ";expires=" + fecha.toUTCString() + ";path=/";
    
    // Actualizar cookie de sesión completa
    actualizarSesionCompleta();
}

function actualizarSesionCompleta() {
    let sesionCompleta = leerCookieSesionCompleta() || {
        tiempo_inicio: Date.now(),
        tiempo_total: 0,
        puntos_total: 0,
        errores_total: 0,
        ayuda_total: 0,
        intentos_total: 0,
        juegos_completados: 0,
        mathbus_guardado: false,
        cortacesped_guardado: false,
        mathmatch_guardado: false
    };

    // Actualizar tiempo total desde el inicio de la sesión
    sesionCompleta.tiempo_total = Math.floor((Date.now() - sesionCompleta.tiempo_inicio) / 1000);

    // Solo acumular datos si este juego no ha sido guardado aún
    if (!sesionCompleta.mathmatch_guardado) {
        sesionCompleta.puntos_total += puntuacion;
        sesionCompleta.errores_total += fallos;
        sesionCompleta.intentos_total += intentos;
        sesionCompleta.mathmatch_guardado = true;
        
        // Marcar MathMatch como completado si cumple la condición
        if (numerosCompletados >= 4) {
            sesionCompleta.juegos_completados = Math.max(sesionCompleta.juegos_completados, 3);
            
            // Verificar si completó los 3 juegos (mathbus, cortacesped y mathmatch)
            if (sesionCompleta.mathbus_guardado && sesionCompleta.cortacesped_guardado && sesionCompleta.mathmatch_guardado) {
                enviarSesionCompletaAlServidor(sesionCompleta);
            }
        }
    }

    const fecha = new Date();
    fecha.setTime(fecha.getTime() + 7 * 24 * 60 * 60 * 1000); // 7 días
    document.cookie = "sesionCompleta=" + JSON.stringify(sesionCompleta) + ";expires=" + fecha.toUTCString() + ";path=/";
}

function leerCookieSesionCompleta() {
    const nombreCookie = "sesionCompleta=";
    const contenido = document.cookie.split(';');
    for (let i = 0; i < contenido.length; i++) {
        let cookieCompleta = contenido[i].trim();
        if (cookieCompleta.indexOf(nombreCookie) === 0) {
            const estadoStr = cookieCompleta.substring(nombreCookie.length);
            return JSON.parse(estadoStr);
        }
    }
    return null;
}

function enviarSesionCompletaAlServidor(sesionCompleta) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    const datosSesion = {
        tiempo_total: sesionCompleta.tiempo_total,
        puntos_total: sesionCompleta.puntos_total,
        errores_total: sesionCompleta.errores_total,
        ayuda_total: sesionCompleta.ayuda_total,
        intentos_total: sesionCompleta.intentos_total,
        juegos_completados: sesionCompleta.juegos_completados
    };

    fetch('/guardar-sesion-completa', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken || ''
        },
        body: JSON.stringify(datosSesion)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Sesión completa guardada:', data);
    })
    .catch(error => {
        console.error('Error al guardar la sesión completa:', error);
    });
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
