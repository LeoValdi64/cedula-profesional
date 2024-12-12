# Consulta de Cédulas Profesionales SEP

Este paquete permite consultar cédulas profesionales de la Secretaría de Educación Pública (SEP) de México.

## Instalación

Puedes instalar este paquete vía Composer:

```bash
composer require leovaldi/cedula-profesional
```

El paquete se registrará automáticamente en Laravel gracias al auto-discovery de paquetes.

## Uso

### En Laravel

```php
use CedulaProfesional\CedulaProfesional;

// Usando la Facade
$resultados = CedulaProfesional::buscarCedula(
    'NOMBRE',
    'APELLIDO_PATERNO',
    'APELLIDO_MATERNO'
);

// O usando el contenedor de servicios
$cedula = app('cedula-profesional');
$resultados = $cedula->buscarCedula(
    'NOMBRE',
    'APELLIDO_PATERNO',
    'APELLIDO_MATERNO'
);

// También puedes usar la clase directamente
use CedulaProfesional\DatosPersonales;

$resultados = DatosPersonales::buscarCedula(
    'NOMBRE',
    'APELLIDO_PATERNO',
    'APELLIDO_MATERNO'
);
```

### Uso Standalone (sin Laravel)

```php
use CedulaProfesional\DatosPersonales;

$resultados = DatosPersonales::buscarCedula(
    'NOMBRE',
    'APELLIDO_PATERNO',
    'APELLIDO_MATERNO'
);

// Los resultados se devuelven en un array con la información de las cédulas encontradas
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
```

## Estructura de los Resultados

Cada resultado contiene la siguiente información:

- `idCedula`: Número de cédula profesional
- `nombre`: Nombre(s)
- `paterno`: Apellido paterno
- `materno`: Apellido materno
- `titulo`: Título profesional
- `desins`: Institución educativa
- `anioreg`: Año de registro
- `tipo`: Tipo de cédula

## Requisitos

- PHP 7.4 o superior
- Extensión cURL
- Extensión JSON
- Laravel 8.0 o superior (si se usa con Laravel)

## Licencia

Este paquete está bajo la licencia MIT. 