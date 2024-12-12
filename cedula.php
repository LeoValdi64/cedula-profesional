<?php

class DatosPersonales {
    private static $url = 'https://www.cedulaprofesional.sep.gob.mx/cedula/buscaCedulaJson.action';

    private static function normalizarTexto($texto) {
        $texto = trim(strtoupper($texto));
        $unwanted_array = array(
            'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
            'Ä'=>'A', 'Ë'=>'E', 'Ï'=>'I', 'Ö'=>'O', 'Ü'=>'U',
            'Ñ'=>'N', 'ñ'=>'n'
        );
        return strtr($texto, $unwanted_array);
    }

    public static function buscarCedula($nombres, $primerApellido, $segundoApellido) {
        // Normalizar parámetros (mayúsculas, sin acentos y sin espacios extras)
        $nombresNorm = self::normalizarTexto($nombres);
        $primerApellidoNorm = self::normalizarTexto($primerApellido);
        $segundoApellidoNorm = self::normalizarTexto($segundoApellido);

        // Preparar los datos para la petición
        $datos = [
            'maxResult' => '1000',
            'nombre' => $nombresNorm,
            'paterno' => $primerApellidoNorm,
            'materno' => $segundoApellidoNorm,
            'idCedula' => ''
        ];

        // Crear el JSON y codificarlo para la petición
        $jsonData = 'json=' . urlencode(json_encode($datos));

        // Configurar la petición cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With: XMLHttpRequest',
            'Accept: */*',
            'Origin: https://www.cedulaprofesional.sep.gob.mx',
            'Referer: https://www.cedulaprofesional.sep.gob.mx/cedula/presidencia/indexAvanzada.action',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
        ]);

        // Ejecutar la petición
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new Exception('Error en la petición cURL: ' . curl_error($ch));
        }

        // Obtener información de la respuesta
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        curl_close($ch);

        // Convertir de ISO-8859-1 a UTF-8
        $body = utf8_encode($body);

        // Decodificar la respuesta JSON
        $responseData = json_decode($body, true);

        // Verificar si la decodificación fue exitosa y si existe el array items
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar la respuesta JSON. Error: ' . json_last_error_msg());
        }

        // Debug: Mostrar todos los resultados antes del filtrado
        echo "\nResultados antes del filtrado:\n";
        foreach ($responseData['items'] ?? [] as $index => $item) {
            echo "\nResultado #" . ($index + 1) . ":\n";
            echo "Nombre: [" . $item['nombre'] . "]\n";
            echo "Paterno: [" . $item['paterno'] . "]\n";
            echo "Materno: [" . $item['materno'] . "]\n";
            echo "Cédula: " . $item['idCedula'] . "\n";
        }

        // Filtrar resultados que coincidan exactamente
        $resultadosFiltrados = array_filter($responseData['items'] ?? [], function($item) use ($nombresNorm, $primerApellidoNorm, $segundoApellidoNorm) {
            // Normalizar strings removiendo acentos y espacios extras
            $nombreItem = self::normalizarTexto($item['nombre']);
            $paternoItem = self::normalizarTexto($item['paterno']);
            $maternoItem = self::normalizarTexto($item['materno']);
            
            // Debug: Mostrar comparaciones
            echo "\nComparando:\n";
            echo "Nombre buscado: [$nombresNorm] vs Item: [$nombreItem]\n";
            echo "Paterno buscado: [$primerApellidoNorm] vs Item: [$paternoItem]\n";
            echo "Materno buscado: [$segundoApellidoNorm] vs Item: [$maternoItem]\n";
            
            $coincideNombre = $nombreItem === $nombresNorm;
            $coincidePaterno = $paternoItem === $primerApellidoNorm;
            $coincideMaterno = $maternoItem === $segundoApellidoNorm;
            
            echo "Coincide nombre: " . ($coincideNombre ? "SÍ" : "NO") . "\n";
            echo "Coincide paterno: " . ($coincidePaterno ? "SÍ" : "NO") . "\n";
            echo "Coincide materno: " . ($coincideMaterno ? "SÍ" : "NO") . "\n";
            
            return $coincideNombre && $coincidePaterno && $coincideMaterno;
        });

        // Reindexar el array
        $resultadosFiltrados = array_values($resultadosFiltrados);

        // Mostrar información de la búsqueda
        echo "\nInformación de la búsqueda:\n";
        echo "Total de resultados encontrados: " . count($responseData['items'] ?? []) . "\n";
        echo "Resultados que coinciden exactamente: " . count($resultadosFiltrados) . "\n";

        return $resultadosFiltrados;
    }
}

