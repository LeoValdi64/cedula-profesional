<?php
require_once 'cedula.php';

try {
    $resultados = DatosPersonales::buscarCedula("LEONARDO DE LA CARIDAD", "VALDIVIA", "DE LA YNCERA");
    echo "\nResultados encontrados:\n";
    if (!empty($resultados)) {
        foreach ($resultados as $resultado) {
            echo "\n================================\n";
            echo "Nombre completo: " . $resultado['nombre'] . " " . $resultado['paterno'] . " " . $resultado['materno'] . "\n";
            echo "Cédula: " . $resultado['idCedula'] . "\n";
            echo "Título: " . $resultado['titulo'] . "\n";
            echo "Institución: " . $resultado['desins'] . "\n";
            echo "Año de registro: " . $resultado['anioreg'] . "\n";
            echo "Tipo: " . $resultado['tipo'] . "\n";
            echo "================================\n";
        }
    } else {
        echo "No se encontraron resultados.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Información de debug
echo "\nInformación de debug:\n";
echo "PHP Version: " . phpversion() . "\n";
echo "cURL Version: " . curl_version()['version'] . "\n";
echo "SSL Version: " . curl_version()['ssl_version'] . "\n"; 