// Función para leer cookies
function getCookie(name) {
    const nombreCookie = name + "=";
    const contenido = document.cookie.split(';');
    for (let i = 0; i < contenido.length; i++) {
        let cookieCompleta = contenido[i].trim();
        if (cookieCompleta.indexOf(nombreCookie) === 0) {
            const estadoStr = cookieCompleta.substring(nombreCookie.length);
            try {
                return JSON.parse(estadoStr);
            } catch(e) {
                return null;
            }
        }
    }
    return null;
}

// Función para formatear tiempo en MM:SS
function formatTime(seconds) {
    if (!seconds) return '--:--';
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

// Actualizar estadísticas de los juegos
document.addEventListener('DOMContentLoaded', function() {
    const juegos = [
        { nombre: 'mathbus', index: 0 },
        { nombre: 'cortacesped', index: 1 },
        { nombre: 'mathmatch', index: 2 },
        { nombre: 'entrevista', index: 3 }
    ];

    juegos.forEach(juego => {
        const cookieData = getCookie(juego.nombre);
        if (cookieData) {
            // Obtener la tarjeta correspondiente
            const cards = document.querySelectorAll('.bg-white.shadow-2xl.rounded-2xl');
            const card = cards[juego.index];
            
            if (card) {
                const statsGrid = card.querySelectorAll('.grid.grid-cols-2 > div');
                
                // Obtener y actualizar contador de partidas desde localStorage
                const partidasKey = `${juego.nombre}_partidas`;
                let partidas = parseInt(localStorage.getItem(partidasKey)) || 0;
                
                // Si hay una cookie activa, significa que se jugó una partida
                if (cookieData.tiempo || cookieData.puntos) {
                    partidas++;
                    localStorage.setItem(partidasKey, partidas);
                }
                
                // Actualizar cada estadística
                if (statsGrid[0]) { // Partidas
                    const partidasSpan = statsGrid[0].querySelector('span:last-child');
                    partidasSpan.textContent = partidas;
                }
                
                if (statsGrid[1]) { // Mejor tiempo
                    const tiempoSpan = statsGrid[1].querySelector('span:last-child');
                    const mejorTiempoKey = `${juego.nombre}_mejor_tiempo`;
                    let mejorTiempo = parseInt(localStorage.getItem(mejorTiempoKey)) || Infinity;
                    
                    if (cookieData.tiempo && cookieData.tiempo < mejorTiempo) {
                        mejorTiempo = cookieData.tiempo;
                        localStorage.setItem(mejorTiempoKey, mejorTiempo);
                    }
                    
                    tiempoSpan.textContent = mejorTiempo !== Infinity ? formatTime(mejorTiempo) : '--:--';
                }
                
                if (statsGrid[2]) { // Aciertos (última partida)
                    const aciertosSpan = statsGrid[2].querySelector('span:last-child');
                    aciertosSpan.textContent = cookieData.aciertos || cookieData.puntos || 0;
                }
                
                if (statsGrid[3]) { // Errores (última partida)
                    const erroresSpan = statsGrid[3].querySelector('span:last-child');
                    erroresSpan.textContent = cookieData.errores || cookieData.fallos || 0;
                }
            }
        }
    });
});
