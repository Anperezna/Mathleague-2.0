const game = {
    bus: null,
    gameArea: null,
    operationDisplay: null,
    puntosEl: null,
    fallosEl: null,

    busY: 150,
    velocidad: 4,
    puntos: 0,
    fallos: 0,
    maxfallos: 3,

    activeAnswers: [],
    gameInterval: null,
    spawnInterval: null,

    currentOperation: null,
    correctAnswer: null,

    start() {
        document.getElementById("menuScreen").classList.add("hidden");
        document.getElementById("gameScreen").classList.remove("hidden");

        this.bus = document.getElementById("bus");
        this.gameArea = document.getElementById("gameArea");
        this.operationDisplay = document.getElementById("operationDisplay");
        this.puntosEl = document.getElementById("puntos");
        this.fallosEl = document.getElementById("fallos");

        this.valoresReset();
        this.generarOperacion();
        this.controles();

        this.gameInterval = setInterval(() => this.actualizarJuego(), 20);
        this.spawnInterval = setInterval(() => this.crearRespuesta(), 1500);
    },

    reset() {
        location.reload();
    },

    valoresReset() {
        this.busY = 150;
        this.puntos = 0;
        this.fallos = 0;
        this.activeAnswers = [];
        this.puntosEl.textContent = "0";
        this.fallosEl.textContent = "0";
    },

    controles() {
        document.onkeydown = (e) => {
            if (e.key === "ArrowUp") this.busY -= this.velocidad * 6;
            if (e.key === "ArrowDown") this.busY += this.velocidad * 6;
            this.busY = Math.max(0, Math.min(this.busY, this.gameArea.clientHeight - 80));
            this.bus.style.top = this.busY + "px";
        };
    },

    generarOperacion() {
        let a = Math.floor(Math.random() * 10) + 1;
        let b = Math.floor(Math.random() * 10) + 1;

        this.correctAnswer = a + b;
        this.currentOperation = `${a} + ${b}`;
        this.operationDisplay.textContent = this.currentOperation;
    },

    crearRespuesta() {
        const isCorrect = Math.random() < 0.4; // 40% probabilidad de ser la correcta
        const value = isCorrect
            ? this.correctAnswer
            : Math.floor(Math.random() * 19) + 2;

        let answer = document.createElement("div");
        answer.className =
            "absolute right-0 text-white font-bold text-xl bg-blue-600 rounded-xl px-4 py-2 shadow-lg";
        answer.style.top = Math.floor(Math.random() * (this.gameArea.clientHeight - 50)) + "px";
        answer.style.right = "-80px";
        answer.dataset.value = value;

        answer.textContent = value;

        this.gameArea.appendChild(answer);
        this.activeAnswers.push(answer);
    },

    actualizarJuego() {
        let busRect = this.bus.getBoundingClientRect();

        this.activeAnswers.forEach((ans, index) => {
            let x = parseInt(ans.style.right);
            ans.style.right = x + 3 + "px";

            // Si sale por la izquierda
            if (x > window.innerWidth) {
                if (parseInt(ans.dataset.value) === this.correctAnswer) this.registerMiss();
                ans.remove();
                this.activeAnswers.splice(index, 1);
                return;
            }

            // Colisión
            let ansRect = ans.getBoundingClientRect();
            if (this.siColisiona(busRect, ansRect)) {
                this.colisiones(ans, index);
            }
        });
    },

    siColisiona(a, b) {
        return !(
            a.right < b.left ||
            a.left > b.right ||
            a.bottom < b.top ||
            a.top > b.bottom
        );
    },

    colisiones(ans, index) {
        let value = parseInt(ans.dataset.value);

        if (value === this.correctAnswer) {
            this.puntos++;
            this.puntosEl.textContent = this.puntos;
            this.generarOperacion();
        } else {
            this.registerMiss();
        }

        ans.remove();
        this.activeAnswers.splice(index, 1);
    },

    registerMiss() {
        this.fallos++;
        this.fallosEl.textContent = this.fallos;

        if (this.fallos >= this.maxfallos) {
            this.endGame();
        }
    },

    endGame() {
        clearInterval(this.gameInterval);
        clearInterval(this.spawnInterval);

        document.getElementById("finalpuntos").textContent = this.puntos;
        document.getElementById("gameOverModal").style.display = "flex";
    }
};
