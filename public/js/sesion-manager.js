// ====================================
// GESTOR SIMPLE DE SESIONES
// Sin APIs - Solo JavaScript y localStorage
// ====================================

(function() {
    'use strict';

    // Función para leer una cookie específica
    function leerCookie(nombre) {
        const nombreCookie = nombre + "=";
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].trim();
            if (cookie.indexOf(nombreCookie) === 0) {
                try {
                    return JSON.parse(cookie.substring(nombreCookie.length));
                } catch(e) {
                    return null;
                }
            }
        }
        return null;
    }

    // Función para combinar todas las cookies en sesionCompleta
    function combinarCookies() {
        const mathbus = leerCookie('mathbus');
        const cortacesped = leerCookie('cortacesped');
        const mathmatch = leerCookie('mathmatch');

        // Calcular totales
        let tiempo_total = 0;
        let puntos_total = 0;
        let errores_total = 0;
        let ayuda_total = 0;
        let juegos_completados = 0;

        if (mathbus) {
            tiempo_total += mathbus.tiempo || 0;
            puntos_total += mathbus.puntos || 0;
            errores_total += mathbus.fallos || 0;
            ayuda_total += mathbus.ayuda || 0;
            juegos_completados++;
        }

        if (cortacesped) {
            tiempo_total += cortacesped.tiempo || 0;
            puntos_total += cortacesped.puntos || 0;
            errores_total += cortacesped.errores || 0;
            ayuda_total += cortacesped.ayuda || 0;
            juegos_completados++;
        }

        if (mathmatch) {
            tiempo_total += mathmatch.tiempo || 0;
            puntos_total += mathmatch.puntos || 0;
            errores_total += mathmatch.errores || mathmatch.fallos || 0;
            ayuda_total += mathmatch.ayuda || 0;
            juegos_completados++;
        }

        // Crear objeto sesionCompleta
        const sesionCompleta = {
            tiempo_total: tiempo_total,
            duracion_sesion: tiempo_total,
            intentos: juegos_completados,
            errores: errores_total,
            puntos: puntos_total,
            ayuda: ayuda_total,
            juegos: {
                mathbus: mathbus,
                cortacesped: cortacesped,
                mathmatch: mathmatch
            },
            fecha: new Date().toISOString()
        };

        // Guardar en localStorage
        localStorage.setItem('sesionCompleta', JSON.stringify(sesionCompleta));

        return sesionCompleta;
    }

    // Función para obtener sesionCompleta
    window.obtenerSesionCompleta = function() {
        return combinarCookies();
    };

    // Función para limpiar todo
    window.limpiarSesion = function() {
        // Limpiar localStorage
        localStorage.removeItem('sesionCompleta');
        
        // Limpiar cookies
        document.cookie = "mathbus=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "cortacesped=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "mathmatch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        
        console.log('Sesión limpiada');
    };

    // Actualizar automáticamente cada 2 segundos
    setInterval(function() {
        combinarCookies();
    }, 2000);

    // Combinar al cargar la página
    combinarCookies();

})();
