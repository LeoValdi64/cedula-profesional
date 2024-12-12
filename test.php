<?php
require __DIR__ . '/vendor/autoload.php';

use CedulaProfesional\CedulaProfesional;

$cedula = new CedulaProfesional();

// Llama algún método para probar
$resultados = $cedula->buscarCedula("Leonardo de la Caridad", "Valdivia", "de la Yncera");

// Mostrar los resultados
echo "Resultados encontrados: " . count($resultados) . "\n\n";

foreach ($resultados as $index => $resultado) {
    echo "Resultado #" . ($index + 1) . ":\n";
    echo "Nombre: " . $resultado['nombre'] . "\n";
    echo "Apellido Paterno: " . $resultado['paterno'] . "\n";
    echo "Apellido Materno: " . $resultado['materno'] . "\n";
    echo "Cédula: " . $resultado['idCedula'] . "\n";
    echo "Institución: " . $resultado['desins'] . "\n";
    echo "Título: " . $resultado['titulo'] . "\n";
    echo "Año de registro: " . $resultado['anioreg'] . "\n";
    echo "Tipo: " . $resultado['tipo'] . "\n";
    echo "------------------------\n";
}
