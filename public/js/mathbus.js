const game = {
    bus: null,
    gameArea: null,
    operationDisplay: null,
    puntosEl: null,
    fallosEl: null,
    tiempo: 0,
    intervaloTiempo: null,
    ayuda: 0,

    busY: 150,
    velocidad: 6,
    puntos: 0,
    fallos: 0,
    maxfallos: 3,

    activeAnswers: [],
    gameInterval: null,
    spawnInterval: null,

    currentOperation: null,
    opcionesActuales: [],

    inicio() {
        document.getElementById("menuScreen").classList.add("hidden");
        document.getElementById("gameScreen").classList.remove("hidden");

        this.bus = document.getElementById("bus");
        this.gameArea = document.getElementById("gameArea");
        this.operationDisplay = document.getElementById("operationDisplay");
        this.puntosEl = document.getElementById("puntos");
        this.fallosEl = document.getElementById("fallos");
        this.iniciarTemporizador();

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
        if (this.bus) {
            this.bus.style.top = this.busY + "px";
        }
    },

    controles() {
        document.onkeydown = (e) => {
            if (e.key === "ArrowUp") {
                this.busY -= 20;
            }
            if (e.key === "ArrowDown") {
                this.busY += 20;
            }
            this.busY = Math.max(0, Math.min(this.busY, this.gameArea.clientHeight - this.bus.clientHeight));
            this.bus.style.top = this.busY + "px";
        };
    },

    generarOperacion() {
        if (window.preguntas && window.preguntas.length > 0) {
            let idx = Math.floor(Math.random() * window.preguntas.length);
            this.preguntaActual = window.preguntas[idx];
            this.currentOperation = this.preguntaActual.enunciado;
            this.operationDisplay.textContent = this.currentOperation;

            // Opciones de la pregunta actual
            this.opcionesActuales = [];
            let opciones = this.preguntaActual.opciones;
            if (opciones && opciones.length > 0) {
                opciones.forEach(op => {
                    [op.opcion1, op.opcion2, op.opcion3, op.opcion4].forEach(valor => {
                        this.opcionesActuales.push({
                            valor: valor,
                            esCorrecta: valor == op.esCorrecta
                        });
                    });
                });
            }
        } else {
            this.currentOperation = "Sin preguntas";
            this.opcionesActuales = [];
        }
    },

    iniciarTemporizador() {
        this.tiempo = 0;

        this.intervaloTiempo = setInterval(() => {
            this.tiempo++;
            // Si quieres mostrarlo en pantalla puedes hacerlo aquí
        }, 1000);
        this.guardarCookies("tiempo", this.tiempo, 1);
    },

    usarAyuda() {
        this.ayuda++;
        console.log("Ayuda usada", this.ayuda);

        this.guardarCookies("ayuda", this.ayuda, 1);
    },

    crearRespuesta() {
        if (this.opcionesActuales && this.opcionesActuales.length > 0) {
            let idx = Math.floor(Math.random() * this.opcionesActuales.length);
            const opcion = this.opcionesActuales[idx];

            let answer = document.createElement("div");
            answer.className =
                "absolute right-0 font-bold text-xl shadow-lg flex items-center justify-center";
            answer.style.width = "60px";
            answer.style.height = "60px";
            answer.style.backgroundImage = "url('/img/mathbus/pelota.png')";
            answer.style.backgroundSize = "cover";
            answer.style.backgroundPosition = "center";
            answer.style.top = Math.floor(Math.random() * (this.gameArea.clientHeight - 60)) + "px";
            answer.style.right = "-80px";
            answer.dataset.value = opcion.valor;
            answer.dataset.correcta = opcion.esCorrecta;

            answer.textContent = opcion.valor;

            this.gameArea.appendChild(answer);
            this.activeAnswers.push(answer);
        }
    },

    actualizarJuego() {
        let busRect = this.bus.getBoundingClientRect();

        this.activeAnswers.forEach((ans, index) => {
            let x = parseInt(ans.style.right);
            ans.style.right = x + 5 + "px";

            // Si sale por la izquierda
            if (x > window.innerWidth) {
                if (parseInt(ans.dataset.value) === this.correctAnswer) this.registroError();
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
        let esCorrecta = ans.dataset.correcta === "true";

        if (esCorrecta) {
            this.puntos++;
            this.puntosEl.textContent = this.puntos;
            this.generarOperacion();

            // Terminar juego si alcanza 10 puntos
            if (this.puntos >= 10) {
                this.finJuego();
            }
        } else {
            this.registroError();
        }

        // Guardar puntos en cookie **después de actualizar**
        this.guardarCookies("puntos", this.puntos, 1);

        ans.remove();
        this.activeAnswers.splice(index, 1);
    },



    registroError() {
        this.fallos++;
        this.fallosEl.textContent = this.fallos;

        // Guardar fallos en cookie
        this.guardarCookies("fallos", this.fallos, 1);

        if (this.fallos >= this.maxfallos) {
            this.finJuego();
        }
    },


    finJuego() {
        clearInterval(this.gameInterval);
        clearInterval(this.spawnInterval);
        clearInterval(this.intervaloTiempo);

        // Guardar los datos finales en cookies
        this.guardarCookies("final", true, 1);

        // Enviar los datos al servidor
        this.enviarDatosAlServidor();

        // Actualizar el modal con la información final
        document.getElementById("finalPuntos").textContent = this.puntos;
        document.getElementById("finalTiempo").textContent = this.tiempo + "s";
        document.getElementById("finalErrores").textContent = this.fallos;
        
        // Mostrar el modal
        document.getElementById("gameOverModal").classList.remove("hidden");
        document.getElementById("gameOverModal").style.display = "flex";
    },

    enviarDatosAlServidor() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const datosJuego = {
            tiempo: this.tiempo,
            puntos: this.puntos,
            fallos: this.fallos,
            ayuda: this.ayuda,
            id_juego: 1 // ID del juego Mathbus (según tu base de datos)
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
    },

    guardarCookies(nombre, valor, dias) {
        const estado = {
            tiempo: this.tiempo,
            puntos: this.puntos,
            fallos: this.fallos,
            ayuda: this.ayuda
        };
        const fecha = new Date();
        fecha.setTime(fecha.getTime() + 1 * 24 * 60 * 60 * 1000); // 1 día
        document.cookie = "mathbus=" + JSON.stringify(estado) + ";expires=" + fecha.toUTCString() + ";path=/";

    },

    leerCookie() {
        const nombreCookie = "mathbus=";
        const contenido = document.cookie.split(';');
        for (let i = 0; i < contenido.length; i++) {
            let cookieCompleta = contenido[i].trim();
            if (cookieCompleta.indexOf(nombreCookie) === 0) {
                // Tomamos el valor tal cual está en la cookie
                const estadoStr = cookieCompleta.substring(nombreCookie.length);
                // Parseamos el JSON directamente (solo funciona si la cookie se guardó sin encodeURIComponent)
                const valorCookie = JSON.parse(estadoStr);
                return valorCookie;
            }
        }
        return null;
    }

};
