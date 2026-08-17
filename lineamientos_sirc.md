# Lineamientos y Restricciones de Desarrollo: SIGAPO 2026

Este documento sirve como base técnica y visual para la modernización estética de la interfaz de usuario de **SIGAPO 2026** (Sistema de Correspondencia de la Gobernación).

---

## 1. Restricciones Técnicas Críticas

### 🚫 Cero Modificaciones de Backend
* **Lógica Intacta:** No alterar consultas SQL, nombres de variables, flujo de sesiones (`session_start`), o lógica PHP en general. 
* **Acción:** Toda mejora debe limitarse exclusivamente a la capa de diseño (HTML, CSS inline/envolvente y JavaScript de comportamiento visual).

### 📴 Entorno Fuera de Línea (Intranet Local)
* **Sin Consumo de Internet:** El servidor de producción está completamente aislado por seguridad.
* **Acción:** No utilizar CDNs externas para CSS, JS, fuentes (Google Fonts) o iconos (FontAwesome, Bootstrap Icons remotos).
* **Solución para Gráficos:** Utilizar elementos vectoriales **SVG inline** directamente en el HTML. Son ligeros, se renderizan al instante de forma local y no dependen de la red.

### 🦊 Compatibilidad Estricta con Firefox 56.0 (2017)
* **Motor de Renderizado Fijo:** El sistema corre localmente sobre Firefox versión 56.0.
* **Acción:** Utilizar propiedades y selectores CSS estándar de ese periodo (Flexbox, CSS Grid, variables CSS y transiciones estándar).
* **Evitar:** Sintaxis modernas como anidamiento nativo de CSS (Nesting) o selectores experimentales modernos que el motor antiguo de Firefox no pueda procesar.

### 🔠 Codificación ISO-8859-1 (Latin-1)
* **Codificación de Archivos:** Las páginas utilizan codificación clásica con caracteres especiales en español (á, é, í, ó, ú, ñ).
* **Acción:** Al modificar archivos, se debe respetar el encoding original para evitar que el navegador muestre símbolos extraños de decodificación.

---

## 2. Paleta de Colores Corporativa (Diseño Oscuro)

* **Fondo Principal de Ventana (Body/Wrapper):** `#0f172a` (azul pizarra muy oscuro).
* **Fondo de Tarjetas o Bloques de Detalle (Fieldsets/Panels):** `#1e293b` (azul pizarra oscuro).
* **Fondo de Cabeceras de Tabla / Títulos Principales:** `#1e3a8a` (azul marino intenso).
* **Texto de Contenido y Datos:** `#ffffff` (blanco puro) para máximo contraste.
* **Texto Secundario o Etiquetas Informativas:** `#cbd5e1` o `#94a3b8` (gris azulado suave).
* **Botón Principal de Confirmación (Aceptar/Guardar):** Degradado verde esmeralda (`linear-gradient(135deg, #10b981 0%, #059669 100%)`).
* **Botón de Cierre o Cancelación (Salir/Cancelar):** Degradado rojo/carmesí (`linear-gradient(135deg, #ef4444 0%, #dc2626 100%)`).
* **Botones Secundarios o de Acción General:**
  * **Buscar:** Degradado gris oscuro/pizarra (`linear-gradient(135deg, #4b5563 0%, #374151 100%)`).
  * **Foliador / Otros:** Degradado azul brillante (`linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)`).

---

## 3. Reglas de Usabilidad y Experiencia de Usuario (UX)

### 📏 Eliminación del Scroll Anidado (Doble Scroll)
* **Mala Práctica:** No debe haber barras de desplazamiento internas dentro de un popup que ya tiene su propio scroll.
* **Acción:** Forzar que la ventana principal tenga scroll vertical nativo (`overflow-y: auto !important`) y el `<iframe>` interno tenga la altura completa del contenido (`height: calc(100vh - 65px)`) con `scrolling="no"`.

### 🚨 Diseño Limpio de Validaciones (Sin "X" rojas)
* **Ocultar Advertencias de Texto:** Ocultar por completo las etiquetas de error de texto nativas de Spry (`display: none !important` en `.textfieldRequiredMsg`).
* **Acción:** Al fallar una validación, el indicador de error se mostrará **pintando el borde del input vacío en rojo brillante (`#ef4444`) con un fondo rosa suave (`#fff5f5`)**. Al rellenar el campo, vuelve a su estado normal.

### 📐 Espacio Dinámico en Modales
* **Acción:** Las ventanas emergentes deben dimensionarse con espacio suficiente (mínimo `650px` de ancho) y la columna de valores dinámicos debe ocupar al menos el 70% del ancho del modal para evitar que los nombres largos de funcionarios o textos de proveídos se corten o dividan en múltiples líneas.
