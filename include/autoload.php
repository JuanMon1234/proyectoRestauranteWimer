<?php

/**
 * Autoload universal para clases con namespaces.
 */
spl_autoload_register(function ($clase) {
    // Convierte el namespace en ruta real
    $ruta = __DIR__ . '/../' . str_replace('\\', '/', $clase) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
    }
});
