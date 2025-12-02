// ====================================
// JUEGO CORTACÉSPED MATEMÁTICO
// Alumno: [Tu Nombre]
// Fecha: Diciembre 2025
// ====================================

class CortacespedGame {
    constructor() {
        // ===== CONFIGURACIÓN DEL CANVAS =====
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        document.body.appendChild(this.canvas);

        // ===== VARIABLES DEL JUEGO =====
        this.gameTime = 120; // Tiempo total: 2 minutos
        this.fuelTime = 20; // Gasolina inicial: 20 segundos
        this.fuelCount = 2; // Bidones de gasolina
        this.score = 0; // Puntuación
        this.gameRunning = false; // ¿El juego está corriendo?
        this.gameStarted = false; // ¿El juego ya empezó?

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
            if (e.code === 'Space' && !this.gameStarted) {
                this.startGame();
            }
        });
        window.addEventListener('keyup', (e) => this.keys[e.code] = false);

        // ===== TEMPORIZADORES =====
        this.lastFuelSpawn = 0;
        this.lastTimeUpdate = Date.now();

        // Mostrar pantalla de inicio
        this.showStartScreen();
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
                    this.score += 1; // Sumar punto
                }
            }
        }
    }

    // ===== CARGAR IMÁGENES =====
    loadImages() {
        const imageNames = ['Campo_MathMatch', 'pacoderecho', 'bidongasolina'];
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

    // ===== PANTALLA DE INICIO =====
    showStartScreen() {
        // Fondo negro semitransparente
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';
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

        // Botón de inicio
        this.ctx.fillStyle = '#00FF00';
        this.ctx.font = 'bold 32px Arial';
        this.ctx.fillText('Presiona ESPACIO para empezar', this.canvas.width / 2, 500);

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
        if (!this.gameRunning) return;

        const now = Date.now();
        const deltaTime = (now - this.lastTimeUpdate) / 1000;
        this.lastTimeUpdate = now;

        // Actualizar tiempo de juego
        this.gameTime -= deltaTime;
        this.fuelTime -= deltaTime;

        // Si se acaba el tiempo de un bidón, restar bidón
        if (this.fuelTime <= 0) {
            this.fuelCount--;
            this.fuelTime = 10; // Resetear a 10 segundos
        }

        // Fin del juego
        if (this.gameTime <= 0 || this.fuelCount <= 0) {
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

            // Detectar colisión con Paco
            if (this.checkCollision(this.paco, fuel)) {
                if (fuel.isCorrect) {
                    // Respuesta correcta
                    this.fuelCount = Math.min(5, this.fuelCount + 1);
                    this.score += 10;
                    this.currentOperation = this.generateOperation();
                } else {
                    // Respuesta incorrecta
                    this.fuelTime = Math.max(3, this.fuelTime - 5);
                    this.score = Math.max(0, this.score - 5);
                }
                return false; // Eliminar bidón
            }

            // Mantener bidón si no salió de la pantalla
            return fuel.y < this.canvas.height;
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

        // Bidones de gasolina arriba derecha
        const fuelSize = 50;
        const startX = this.canvas.width - 280;
        for (let i = 0; i < 5; i++) {
            if (i < this.fuelCount) {
                // Bidón lleno
                const blink = this.fuelCount === 1 && Math.floor(Date.now() / 500) % 2 === 0;
                if (!blink) {
                    this.ctx.drawImage(this.images['bidongasolina'], startX + i * 55, 15, fuelSize, fuelSize);
                }
            } else {
                // Bidón vacío (gris)
                this.ctx.globalAlpha = 0.3;
                this.ctx.drawImage(this.images['bidongasolina'], startX + i * 55, 15, fuelSize, fuelSize);
                this.ctx.globalAlpha = 1;
            }
        }

        // Información arriba izquierda
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(10, 10, 200, 80);
        this.ctx.fillStyle = 'white';
        this.ctx.font = '20px Arial';
        this.ctx.textAlign = 'left';
        this.ctx.fillText(`Tiempo: ${Math.ceil(this.gameTime)}s`, 20, 35);
        this.ctx.fillText(`Puntos: ${this.score}`, 20, 65);
    }

    // ===== PANTALLA DE GAME OVER =====
    showGameOver() {
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.8)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        this.ctx.fillStyle = '#FFD700';
        this.ctx.font = 'bold 60px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText('¡JUEGO TERMINADO!', this.canvas.width / 2, 200);

        this.ctx.fillStyle = 'white';
        this.ctx.font = '32px Arial';
        this.ctx.fillText(`Puntuación Final: ${this.score}`, this.canvas.width / 2, 280);

        this.ctx.fillStyle = '#00FF00';
        this.ctx.font = 'bold 28px Arial';
        this.ctx.fillText('Presiona F5 para jugar de nuevo', this.canvas.width / 2, 350);
    }

    // ===== BUCLE PRINCIPAL =====
    gameLoop() {
        this.update();
        this.draw();

        if (this.gameRunning) {
            requestAnimationFrame(() => this.gameLoop());
        }
    }
}

// ===== INICIAR JUEGO AL CARGAR LA PÁGINA =====
window.addEventListener('load', () => {
    new CortacespedGame();
});
