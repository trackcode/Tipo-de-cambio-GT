# Tipo de Cambio GT

Este proyecto proporciona una solución para obtener el tipo de cambio en Guatemala a través de diferentes proveedores. El código fuente está disponible como código abierto para que otros desarrolladores puedan utilizarlo, modificarlo y contribuir a su mejora.

## Funcionalidad

El objetivo principal de esta aplicación es obtener el tipo de cambio desde distintos proveedores y presentarlo de forma unificada. Actualmente, se incluyen dos proveedores: Banco Industrial y BanRural. Sin embargo, el diseño permite agregar fácilmente nuevos proveedores en el futuro.

La clase principal, `TipoCambioObtainer`, utiliza el patrón de diseño Strategy y la interfaz `TipoCambioProvider` para permitir la adición de nuevos proveedores de manera flexible. Esto facilita la extensibilidad y mantenimiento del código.

## Configuración

Antes de utilizar esta aplicación, es necesario realizar algunas configuraciones:

1. Clona o descarga este repositorio en tu entorno de desarrollo.
2. Asegúrate de tener PHP instalado en tu sistema.
3. Verifica y ajusta las configuraciones necesarias dentro de los proveedores existentes o agrega nuevos proveedores según tus necesidades.

## Uso

### Uso básico

Para utilizar la aplicación y obtener el tipo de cambio, sigue los pasos a continuación:

1. Instancia la clase `TipoCambioObtainer` en tu código.
2. Llama al método `obtenerTipoCambio()` en la instancia creada.
3. El resultado se mostrará en formato JSON.

```php
<?php
require_once('class.tipoCambioGT.php');

// Instanciar el obtentor de tipo de cambio
$obtainer = new TipoCambioObtainer();

// Obtener el tipo de cambio
$tipoCambio = $obtainer->obtenerTipoCambio();

// Mostrar el resultado
echo $tipoCambio;
?>
```

## Contribución

Si deseas contribuir a este proyecto, puedes seguir los pasos a continuación:

1. Realiza un fork de este repositorio.
2. Crea una rama nueva para tu contribución.
3. Realiza los cambios y mejoras en tu rama.
4. Envía un pull request con tus cambios.

Agradecemos todas las contribuciones para mejorar este proyecto y hacerlo más útil para la comunidad.
