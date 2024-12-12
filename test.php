<?php
require_once 'cedula.php';

try {
    // Ejemplo de uso
    $resultados = DatosPersonales::buscarCedula("LUIS EHECATL", "TELLEZ", "ALONZO");
    
    if (empty($resultados)) {
        echo "No se encontraron resultados.\n";
    } else {
        echo "\nSe encontraron " . count($resultados) . " cédulas profesionales:\n";
        foreach ($resultados as $index => $resultado) {
            echo "\n========== Resultado #" . ($index + 1) . " ==========\n";
            echo "Nombre completo: " . $resultado['nombre'] . " " . $resultado['paterno'] . " " . $resultado['materno'] . "\n";
            echo "Número de Cédula: " . $resultado['idCedula'] . "\n";
            echo "Título: " . $resultado['titulo'] . "\n";
            echo "Institución: " . $resultado['desins'] . "\n";
            echo "Año de registro: " . $resultado['anioreg'] . "\n";
            if (isset($resultado['tipo'])) {
                echo "Tipo de Cédula: " . $resultado['tipo'] . "\n";
            }
            echo "================================\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 