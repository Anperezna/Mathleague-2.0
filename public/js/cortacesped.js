// Juego Cortacésped - Paco en el Campo de Fútbol
class CortacespedGame {
    constructor() {
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
        document.body.appendChild(this.canvas);

        // Estado del juego
        this.gameTime = 120; // 2 minutos en segundos
        this.fuelTime = 20; // 2 bidones * 10 segundos
        this.fuelCount = 2;
        this.score = 0;
        this.gameRunning = true;

        // Posición de Paco
        this.paco = {
            x: this.canvas.width / 2,
            y: this.canvas.height - 120,
            width: 200,
            height: 150,
            speed: 10
        };

        // Operación actual
        this.currentOperation = this.generateOperation();

        // Bidones cayendo
        this.fallingFuel = [];

        // Imágenes
        this.images = {};
        this.loadImages();

        // Controles
        this.keys = {};
        window.addEventListener('keydown', (e) => this.keys[e.code] = true);
        window.addEventListener('keyup', (e) => this.keys[e.code] = false);

        // Timers
        this.lastFuelSpawn = 0;
        this.lastTimeUpdate = Date.now();

        // Iniciar juego
        this.gameLoop();
    }

    loadImages() {
        const imageNames = ['Campo_MathMatch', 'pacoderecho', 'bidongasolina'];
        let loaded = 0;

        imageNames.forEach(name => {
            this.images[name] = new Image();
            this.images[name].onload = () => {
                loaded++;
                if (loaded === imageNames.length) {
                    this.startGame();
                }
            };
            this.images[name].src = `/img/${name}.png`;
        });
    }

    startGame() {
        this.gameLoop();
    }

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

    spawnFuel() {
        const isCorrect = Math.random() > 0.5;
        const answer = isCorrect ? this.currentOperation.answer : Math.floor(Math.random() * 40);

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

    update() {
        if (!this.gameRunning) return;

        const now = Date.now();
        const deltaTime = (now - this.lastTimeUpdate) / 1000;
        this.lastTimeUpdate = now;

        // Actualizar tiempo
        this.gameTime -= deltaTime;
        this.fuelTime -= deltaTime;

        if (this.fuelTime <= 0) {
            this.fuelCount = Math.max(0, this.fuelCount - 1);
            this.fuelTime = 10; // Reiniciar timer por bidón
        }

        if (this.gameTime <= 0 || this.fuelCount <= 0) {
            this.gameRunning = false;
            this.showGameOver();
            return;
        }

        // Movimiento de Paco
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

        // Generar bidones
        if (now - this.lastFuelSpawn > 2000) { // Cada 2 segundos
            this.spawnFuel();
            this.lastFuelSpawn = now;
        }

        // Actualizar bidones cayendo
        this.fallingFuel = this.fallingFuel.filter(fuel => {
            fuel.y += fuel.speed;

            // Colisión con Paco
            if (this.checkCollision(this.paco, fuel)) {
                if (fuel.isCorrect) {
                    this.fuelCount = Math.min(5, this.fuelCount + 1); // Máximo 5 bidones
                    this.score += 10;
                    this.currentOperation = this.generateOperation(); // Nueva operación
                } else {
                    this.fuelTime = Math.max(5, this.fuelTime - 5); // Reducir tiempo
                    this.score -= 5;
                }
                return false; // Remover bidón
            }

            return fuel.y < this.canvas.height;
        });
    }

    checkCollision(rect1, rect2) {
        return rect1.x < rect2.x + rect2.width &&
               rect1.x + rect1.width > rect2.x &&
               rect1.y < rect2.y + rect2.height &&
               rect1.y + rect1.height > rect2.y;
    }

    draw() {
        // Limpiar canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Dibujar campo
        this.ctx.drawImage(this.images['Campo_MathMatch'], 0, 0, this.canvas.width, this.canvas.height);

        // Dibujar Paco
        this.ctx.drawImage(this.images['pacoderecho'], this.paco.x, this.paco.y, this.paco.width, this.paco.height);

        // Dibujar bidones cayendo
        this.fallingFuel.forEach(fuel => {
            this.ctx.drawImage(this.images['bidongasolina'], fuel.x, fuel.y, fuel.width, fuel.height);

            // Dibujar respuesta
            this.ctx.fillStyle = 'white';
            this.ctx.font = '28px Arial';
            this.ctx.textAlign = 'center';
            this.ctx.fillText(fuel.answer.toString(), fuel.x + fuel.width/2, fuel.y + fuel.height/2 + 12);
        });

        // Dibujar UI
        this.drawUI();
    }

    drawUI() {
        // Operación arriba centro
        this.ctx.fillStyle = 'white';
        this.ctx.font = '40px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText(this.currentOperation.text, this.canvas.width / 2, 60);

        // Bidones arriba derecha
        const fuelIconSize = 75;
        const startX = this.canvas.width - 400;
        const startY = 20;

        for (let i = 0; i < Math.min(5, this.fuelCount); i++) {
            const blink = this.fuelCount === 1 && Math.floor(Date.now() / 500) % 2 === 0;
            if (!blink) {
                this.ctx.drawImage(this.images['bidongasolina'], startX + i * 80, startY, fuelIconSize, fuelIconSize);
            }
        }

        // Tiempo restante
        this.ctx.fillStyle = 'white';
        this.ctx.font = '28px Arial';
        this.ctx.textAlign = 'left';
        this.ctx.fillText(`Tiempo: ${Math.ceil(this.gameTime)}s`, 20, 50);
        this.ctx.fillText(`Puntuación: ${this.score}`, 20, 90);
    }

    showGameOver() {
        this.ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

        this.ctx.fillStyle = 'white';
        this.ctx.font = '80px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.fillText('¡Juego Terminado!', this.canvas.width / 2, this.canvas.height / 2 - 60);

        this.ctx.font = '40px Arial';
        this.ctx.fillText(`Puntuación Final: ${this.score}`, this.canvas.width / 2, this.canvas.height / 2);
        this.ctx.fillText('Presiona F5 para jugar de nuevo', this.canvas.width / 2, this.canvas.height / 2 + 60);
    }

    gameLoop() {
        this.update();
        this.draw();

        if (this.gameRunning) {
            requestAnimationFrame(() => this.gameLoop());
        }
    }
}

// Iniciar juego cuando se carga la página
window.addEventListener('load', () => {
    new CortacespedGame();
});
