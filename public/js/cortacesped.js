// ====================================
// JUEGO CORTACÉSPED MATEMÁTICO
// Alumno: [Tu Nombre]
// ====================================

class CortacespedGame {
    constructor() {
        // ===== CONFIGURACIÓN DEL CANVAS =====
        this.canvas = document.getElementById('gameCanvas');
        if (!this.canvas) {
            this.canvas = document.createElement('canvas');
            const container = document.getElementById('canvasContainer');
            if (container) {
                container.appendChild(this.canvas);
            } else {
                document.body.appendChild(this.canvas);
            }
        }
        this.ctx = this.canvas.getContext('2d');
        // Ajustar el canvas al tamaño del contenedor
        const container = document.getElementById('canvasContainer');
        if (container) {
            this.canvas.width = container.clientWidth;
            this.canvas.height = container.clientHeight;
        } else {
            this.canvas.width = 1200;
            this.canvas.height = 700;
        }

        // ===== VARIABLES DEL JUEGO =====
        this.gameTime = 0; // Tiempo transcurrido en segundos
        this.maxTime = 60; // Tiempo máximo: 1 minuto
        this.aciertos = 0; // Aciertos (máximo 6)
        this.errores = 0; // Errores (máximo 3)
        this.maxAciertos = 6; // Aciertos necesarios para ganar
        this.maxErrores = 3; // Errores máximos permitidos
        this.score = 0; // Puntuación
        this.gameRunning = false; // ¿El juego está corriendo?
        this.gameStarted = false; // ¿El juego ya empezó?
        this.isPaused = false; // ¿El juego está en pausa?
        this.ayuda = 0; // Contador de ayudas usadas
        this.totalGrass = 0; // Total de células de césped
        this.grassCut = 0; // Células de césped cortadas

        // ===== PERSONAJE (PACO) =====
        this.paco = {
            x: this.canvas.width / 2 - 100,
            y: this.canvas.height - 200,
            width: 200,
            height: 150,
            speed: 8
        };

        // ===== CÉSPED =====
        this.grassGridSize = 30; // Tamaño de cada celda
        this.grassGrid = []; // Matriz del césped
        this.initGrassGrid(); // Inicializar césped

        // ===== OPERACIÓN MATEMÁTICA =====
        this.currentOperation = this.generateOperation();

        // ===== BIDONES QUE CAEN =====
        this.fallingFuel = [];

        // ===== IMÁGENES =====
        this.images = {};
        this.loadImages();

        // ===== CONTROLES DEL TECLADO =====
        this.keys = {};
        window.addEventListener('keydown', (e) => {
            this.keys[e.code] = true;
            if (e.code === 'Escape' && this.gameStarted && this.gameRunning) {
                this.togglePause();
            }
        });
        window.addEventListener('keyup', (e) => this.keys[e.code] = false);

        // ===== TEMPORIZADORES =====
        this.lastFuelSpawn = 0;
        this.lastTimeUpdate = Date.now();

        // No mostrar pantalla de inicio automáticamente
        // El menú de la página se encargará de iniciar el juego
    }

    // ===== INICIALIZAR CÉSPED =====
    initGrassGrid() {
        const cols = Math.ceil(this.canvas.width / this.grassGridSize);
        const rows = Math.ceil(this.canvas.height / this.grassGridSize);
        
        // Crear matriz: 1 = césped largo, 0 = césped cortado
        for (let y = 0; y < rows; y++) {
            this.grassGrid[y] = [];
            for (let x = 0; x < cols; x++) {
                this.grassGrid[y][x] = 1; // Todo empieza con césped largo
                this.totalGrass++; // Contar total de celdas
            }
        }
    }

    // ===== CORTAR CÉSPED =====
    cutGrass() {
        // Calcular posición de Paco en el grid
        const gridX = Math.floor(this.paco.x / this.grassGridSize);
        const gridY = Math.floor(this.paco.y / this.grassGridSize);
        const gridW = Math.ceil(this.paco.width / this.grassGridSize);
        const gridH = Math.ceil(this.paco.height / this.grassGridSize);

        // Recorrer las celdas donde está Paco
        for (let y = gridY; y < gridY + gridH + 1; y++) {
            for (let x = gridX; x < gridX + gridW + 1; x++) {
                // Si existe la celda y tiene césped largo
                if (this.grassGrid[y] && this.grassGrid[y][x] === 1) {
                    this.grassGrid[y][x] = 0; // Marcar como cortado
                    this.grassCut++; // Incrementar contador
                    this.score += 1; // Sumar punto
                }
            }
        }
    }

    // ===== CARGAR IMÁGENES =====
    loadImages() {
        const imageNames = ['Campo_MathMatch', 'pacoderecho', 'bidongasolina', 'fondo'];
        let loaded = 0;

        imageNames.forEach(name => {
            this.images[name] = new Image();
            this.images[name].onload = () => {
                loaded++;
                if (loaded === imageNames.length) {
                    console.log('Imágenes cargadas');
                }
            };
            this.images[name].src = `/img/${name}.png`;
        });
    }

    // ===== INICIAR JUEGO =====
    startGame() {
        this.gameRunning = true;
        this.gameStarted = true;
        this.lastTimeUpdate = Date.now();
        this.gameLoop();
    }

    // ===== PAUSAR/REANUDAR JUEGO =====
    togglePause() {
        this.isPaused = !this.isPaused;
        if (!this.isPaused) {
            // Reanudar: actualizar el tiempo para evitar saltos
            this.lastTimeUpdate = Date.now();
            this.gameLoop();
        }
    }

    // ===== PANTALLA DE PAUSA =====
    showPauseScreen() {
        // Oscurecer la pantalla
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        // Título de pausa
        this.ctx.fillStyle = '#FFD700';
        this.ctx.font = 'bold 80px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText('PAUSA', this.canvas.width / 2, this.canvas.height / 2 - 50);

        // Instrucción
        this.ctx.fillStyle = 'white';
        this.ctx.font = '32px Arial';
        this.ctx.fillText('Presiona ESC para continuar', this.canvas.width / 2, this.canvas.height / 2 + 50);
    }

    // ===== PANTALLA DE INICIO =====
    showStartScreen() {
        // Dibujar imagen de fondo
        if (this.images['fondo'] && this.images['fondo'].complete) {
            this.ctx.drawImage(this.images['fondo'], 0, 0, this.canvas.width, this.canvas.height);
        }
        
        // Fondo negro semitransparente
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        // Título
        this.ctx.fillStyle = '#FFD700';
        this.ctx.font = 'bold 60px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText('CORTACÉSPED MATEMÁTICO', this.canvas.width / 2, 200);

        // Instrucciones
        this.ctx.fillStyle = 'white';
        this.ctx.font = '24px Arial';
        this.ctx.fillText('Instrucciones:', this.canvas.width / 2, 300);
        this.ctx.fillText('• Mueve a Paco con las FLECHAS', this.canvas.width / 2, 340);
        this.ctx.fillText('• Corta el césped pasando por encima', this.canvas.width / 2, 380);
        this.ctx.fillText('• Recoge los bidones con la respuesta correcta', this.canvas.width / 2, 420);
        this.ctx.fillText('• Consigue 6 aciertos o corta el 80% del campo', this.canvas.width / 2, 460);
        this.ctx.fillText('• Tienes 1 minuto y 3 errores máximos', this.canvas.width / 2, 500);

        // Botón de inicio
        this.ctx.fillStyle = '#00FF00';
        this.ctx.font = 'bold 32px Arial';
        this.ctx.fillText('Presiona ESPACIO para empezar', this.canvas.width / 2, 570);

        // Repetir animación si no ha empezado
        if (!this.gameStarted) {
            requestAnimationFrame(() => this.showStartScreen());
        }
    }

    // ===== GENERAR OPERACIÓN MATEMÁTICA =====
    generateOperation() {
        const num1 = Math.floor(Math.random() * 20) + 1;
        const num2 = Math.floor(Math.random() * 20) + 1;
        const operations = ['+', '-'];
        const op = operations[Math.floor(Math.random() * operations.length)];

        let result;
        if (op === '+') {
            result = num1 + num2;
        } else {
            result = Math.max(0, num1 - num2);
        }

        return {
            text: `${num1} ${op} ${num2} = ?`,
            answer: result
        };
    }

    // ===== CREAR BIDÓN QUE CAE =====
    spawnFuel() {
        // 50% de probabilidad de ser correcto
        const isCorrect = Math.random() > 0.5;
        
        let answer;
        if (isCorrect) {
            answer = this.currentOperation.answer;
        } else {
            // Respuesta incorrecta (número aleatorio)
            answer = Math.floor(Math.random() * 40);
        }

        // Añadir bidón al array
        this.fallingFuel.push({
            x: Math.random() * (this.canvas.width - 120),
            y: -120,
            width: 100,
            height: 100,
            speed: 2 + Math.random() * 2,
            answer: answer,
            isCorrect: isCorrect
        });
    }

    // ===== ACTUALIZAR JUEGO =====
    update() {
        if (!this.gameRunning || this.isPaused) return;

        const now = Date.now();
        const deltaTime = (now - this.lastTimeUpdate) / 1000;
        this.lastTimeUpdate = now;

        // Actualizar tiempo de juego (contar hacia arriba)
        this.gameTime += deltaTime;

        // Calcular porcentaje de césped cortado
        const grassPercentage = (this.grassCut / this.totalGrass) * 100;

        // Fin del juego si:
        // - Alcanza 6 aciertos
        // - Comete 3 errores
        // - Se acaba el tiempo (60 segundos)
        // - Corta el 80% del campo
        if (this.aciertos >= this.maxAciertos || 
            this.errores >= this.maxErrores || 
            this.gameTime >= this.maxTime ||
            grassPercentage >= 80) {
            this.gameRunning = false;
            this.showGameOver();
            return;
        }

        // Movimiento de Paco con las flechas
        if (this.keys['ArrowLeft'] && this.paco.x > 0) {
            this.paco.x -= this.paco.speed;
        }
        if (this.keys['ArrowRight'] && this.paco.x < this.canvas.width - this.paco.width) {
            this.paco.x += this.paco.speed;
        }
        if (this.keys['ArrowUp'] && this.paco.y > 0) {
            this.paco.y -= this.paco.speed;
        }
        if (this.keys['ArrowDown'] && this.paco.y < this.canvas.height - this.paco.height) {
            this.paco.y += this.paco.speed;
        }

        // Cortar césped donde está Paco
        this.cutGrass();

        // Crear bidones cada 2 segundos
        if (now - this.lastFuelSpawn > 2000) {
            this.spawnFuel();
            this.lastFuelSpawn = now;
        }

        // Actualizar bidones que caen
        this.fallingFuel = this.fallingFuel.filter(fuel => {
            fuel.y += fuel.speed; // Mover hacia abajo

            // Si el bidón sale de la pantalla por abajo, simplemente eliminarlo
            if (fuel.y > this.canvas.height) {
                return false; // Eliminar bidón
            }

            // Detectar colisión con Paco
            if (this.checkCollision(this.paco, fuel)) {
                if (fuel.isCorrect) {
                    // Respuesta correcta
                    this.aciertos++;
                    this.score += 10;
                    this.currentOperation = this.generateOperation();
                    this.guardarCookies(); // Guardar progreso
                } else {
                    // Respuesta incorrecta
                    this.errores++;
                    this.score = Math.max(0, this.score - 5);
                    this.guardarCookies(); // Guardar progreso
                }
                return false; // Eliminar bidón
            }

            // Mantener bidón si sigue en pantalla
            return true;
        });
    }

    // ===== DETECTAR COLISIÓN =====
    checkCollision(rect1, rect2) {
        return rect1.x < rect2.x + rect2.width &&
               rect1.x + rect1.width > rect2.x &&
               rect1.y < rect2.y + rect2.height &&
               rect1.y + rect1.height > rect2.y;
    }

    // ===== DIBUJAR JUEGO =====
    draw() {
        // Limpiar pantalla
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Dibujar campo de fútbol
        this.ctx.drawImage(this.images['Campo_MathMatch'], 0, 0, this.canvas.width, this.canvas.height);

        // Dibujar césped
        this.drawGrass();

        // Dibujar Paco
        this.ctx.drawImage(this.images['pacoderecho'], this.paco.x, this.paco.y, this.paco.width, this.paco.height);

        // Dibujar bidones que caen
        this.fallingFuel.forEach(fuel => {
            this.ctx.drawImage(this.images['bidongasolina'], fuel.x, fuel.y, fuel.width, fuel.height);

            // Dibujar número en el bidón
            this.ctx.fillStyle = 'white';
            this.ctx.font = '24px Arial';
            this.ctx.textAlign = 'center';
            this.ctx.fillText(fuel.answer, fuel.x + fuel.width/2, fuel.y + fuel.height/2 + 8);
        });

        // Dibujar interfaz
        this.drawUI();
    }

    // ===== DIBUJAR CÉSPED =====
    drawGrass() {
        for (let y = 0; y < this.grassGrid.length; y++) {
            for (let x = 0; x < this.grassGrid[y].length; x++) {
                if (this.grassGrid[y][x] === 1) {
                    // Césped largo - verde oscuro
                    const pixelX = x * this.grassGridSize;
                    const pixelY = y * this.grassGridSize;
                    this.ctx.fillStyle = 'rgba(34, 139, 34, 0.4)';
                    this.ctx.fillRect(pixelX, pixelY, this.grassGridSize, this.grassGridSize);
                }
            }
        }
    }

    // ===== DIBUJAR INTERFAZ =====
    drawUI() {
        // Operación matemática
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(this.canvas.width / 2 - 150, 10, 300, 50);
        this.ctx.fillStyle = 'white';
        this.ctx.font = 'bold 32px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText(this.currentOperation.text, this.canvas.width / 2, 45);

        // Bidones de aciertos arriba derecha
        const fuelSize = 50;
        const startX = this.canvas.width - 340;
        this.ctx.fillStyle = 'white';
        this.ctx.font = 'bold 20px Arial';
        this.ctx.textAlign = 'left';
        this.ctx.fillText('Aciertos:', startX - 100, 45);
        
        for (let i = 0; i < this.maxAciertos; i++) {
            if (i < this.aciertos) {
                // Bidón lleno (acierto conseguido)
                this.ctx.drawImage(this.images['bidongasolina'], startX + i * 55, 15, fuelSize, fuelSize);
            } else {
                // Bidón vacío (gris)
                this.ctx.globalAlpha = 0.3;
                this.ctx.drawImage(this.images['bidongasolina'], startX + i * 55, 15, fuelSize, fuelSize);
                this.ctx.globalAlpha = 1;
            }
        }

        // Errores a la izquierda
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(10, 10, 220, 150);
        this.ctx.fillStyle = 'white';
        this.ctx.font = '20px Arial';
        this.ctx.textAlign = 'left';
        
        const timeLeft = Math.max(0, this.maxTime - this.gameTime);
        const grassPercentage = ((this.grassCut / this.totalGrass) * 100).toFixed(1);
        
        this.ctx.fillText(`Tiempo: ${Math.floor(timeLeft)}s`, 20, 35);
        this.ctx.fillText(`Puntos: ${this.score}`, 20, 65);
        this.ctx.fillText(`Césped: ${grassPercentage}%`, 20, 95);
        
        // Mostrar errores con X rojas
        this.ctx.fillStyle = 'red';
        this.ctx.font = 'bold 24px Arial';
        this.ctx.fillText('Errores:', 20, 125);
        for (let i = 0; i < this.maxErrores; i++) {
            if (i < this.errores) {
                this.ctx.fillStyle = 'red';
                this.ctx.fillText('X', 130 + i * 25, 125);
            } else {
                this.ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
                this.ctx.fillText('O', 130 + i * 25, 125);
            }
        }
    }

    // ===== PANTALLA DE GAME OVER =====
    showGameOver() {
        // Guardar datos finales
        this.guardarCookies();
        this.enviarDatosAlServidor();

        const grassPercentage = ((this.grassCut / this.totalGrass) * 100).toFixed(1);
        const ganaste = this.aciertos >= this.maxAciertos || grassPercentage >= 80;
        
        // Actualizar el modal con los datos
        const modal = document.getElementById('game-over-modal');
        const modalTitle = document.getElementById('modal-title');
        const finalTiempo = document.getElementById('final-tiempo');
        const finalAciertos = document.getElementById('final-aciertos');
        const finalErrores = document.getElementById('final-errores');
        const finalCesped = document.getElementById('final-cesped');
        const reasonText = document.getElementById('game-over-reason');

        // Actualizar título
        modalTitle.textContent = ganaste ? '¡Ganaste!' : '¡Perdiste!';
        modalTitle.className = ganaste ? 'text-3xl font-bold mb-4 text-green-600' : 'text-3xl font-bold mb-4 text-red-600';

        // Actualizar estadísticas
        finalTiempo.textContent = `${Math.floor(this.gameTime)}s / ${this.maxTime}s`;
        finalAciertos.textContent = `${this.aciertos}/${this.maxAciertos}`;
        finalErrores.textContent = `${this.errores}/${this.maxErrores}`;
        finalCesped.textContent = `${grassPercentage}%`;

        // Actualizar razón de victoria/derrota
        if (ganaste) {
            if (this.aciertos >= this.maxAciertos) {
                reasonText.textContent = '¡Completaste los 6 aciertos!';
            } else if (grassPercentage >= 80) {
                reasonText.textContent = '¡Cortaste el 80% del campo!';
            }
            reasonText.className = 'text-xl text-green-600 mb-4 font-semibold';
        } else {
            if (this.errores >= this.maxErrores) {
                reasonText.textContent = 'Cometiste 3 errores';
            } else if (this.gameTime >= this.maxTime) {
                reasonText.textContent = 'Se acabó el tiempo';
            }
            reasonText.className = 'text-xl text-red-600 mb-4 font-semibold';
        }

        // Mostrar el modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // ===== GUARDAR COOKIES =====
    guardarCookies() {
        const estado = {
            tiempo: Math.floor(this.gameTime),
            puntos: this.score,
            aciertos: this.aciertos,
            errores: this.errores,
            ayuda: this.ayuda
        };
        const fecha = new Date();
        fecha.setTime(fecha.getTime() + 1 * 24 * 60 * 60 * 1000); // 1 día
        document.cookie = "cortacesped=" + JSON.stringify(estado) + ";expires=" + fecha.toUTCString() + ";path=/";
    }

    // ===== LEER COOKIE =====
    leerCookie() {
        const nombreCookie = "cortacesped=";
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

    // ===== ENVIAR DATOS AL SERVIDOR =====
    enviarDatosAlServidor() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const datosJuego = {
            tiempo: Math.floor(this.gameTime),
            puntos: this.score,
            aciertos: this.aciertos,
            errores: this.errores,
            ayuda: this.ayuda,
            id_juego: 2 // ID del juego Cortacesped (según tu base de datos)
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

    // ===== BUCLE PRINCIPAL =====
    gameLoop() {
        this.update();
        this.draw();

        // Dibujar pantalla de pausa si está pausado
        if (this.isPaused) {
            this.showPauseScreen();
        }

        if (this.gameRunning) {
            requestAnimationFrame(() => this.gameLoop());
        }
    }
}

// ===== INSTANCIA GLOBAL DEL JUEGO =====
let gameInstance = null;
