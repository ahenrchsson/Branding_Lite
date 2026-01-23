# Branding Lite (GLPI 11+)

Plugin minimalista para administrar e inyectar el favicon en GLPI 11+.

## Instalación en Docker

1. Copia este plugin en la ruta del volumen:

   ```bash
   ./storage/glpi/marketplace/branding_lite
   ```

2. Reinicia el contenedor o recarga la lista de plugins en GLPI.
3. Activa el plugin en **Configuración > Plugins**.

## Configuración

1. En **Configurar** del plugin, sube un favicon (cualquier `image/*`).
2. El plugin acepta varios formatos, pero los navegadores suelen manejar mejor `ico`, `png` o `svg`.

## Cache busting

El plugin agrega automáticamente `?v=<timestamp>` a la URL del favicon cuando cambias el archivo para forzar la actualización en caché.

## Cambio de logo interno por entidad (sin plugin)

1. Ir a **Entidades** y seleccionar la entidad.
2. Abrir **Personalización de interfaz de usuario**.
3. En el campo **CSS**, pegar este contenido (reemplaza `url.png` por tu URL real):

```css
.page .glpi-logo {
    /* ... Propiedades de imagen y tamaño (ej. 150px/90px) ... */
    background: url('url.png') no-repeat;
    background-size: contain;
    background-position: center;
    width: 150px;
    height: 98px;

    /* 📌 Márgenes para centrar y separar */
    margin-top: auto;/*20px; /* Separación de 20px de la parte superior */
    margin-left: auto; /* Centrar horizontalmente */
    margin-right: auto; /* Centrar horizontalmente */
}

body.navbar-collapsed .navbar-brand .glpi-logo {
    background: url('url.png') no-repeat;
    background-size: contain !important;
    background-position: center;
    width: 40px;
    height: 40px;
}
```
