# MANUAL DE IDENTIDAD VISUAL Y LÍNEA GRÁFICA OFICIAL
## GOBIERNO AUTÓNOMO DEPARTAMENTAL DE ORURO (GADOR)
### SISTEMA DE CORRESPONDENCIA OFICIAL (SIGAPO 2026)

---

## 1. PRINCIPIOS DE IDENTIDAD INSTITUCIONAL

La línea gráfica oficial del **Gobierno Autónomo Departamental de Oruro (GADOR)** para el sistema **SIGAPO** se fundamenta en los colores históricos, cívicos y heráldicos del Departamento de Oruro, proyectando sobriedad, elegancia, prestigio administrativo y solemnidad institucional.

> [!IMPORTANT]
> **POLÍTICA DE NEUTRALIDAD Y EXCLUSIÓN PARTIDARIA:**
> Queda terminantemente prohibido el uso de tonos azules cobalto, azules zafiro, azul eléctrico o gradientes policromáticos/arcoíris asociados a agrupaciones políticas (particularmente la paleta partidaria MAS-IPSP). Toda la plataforma se rige exclusivamente por el **Rojo Carmesí Departamental**, el **Dorado Institucional**, el **Blanco Puro** y los **Neutros de Alto Contraste** (Carbono/Platino).

---

## 2. PALETA CROMÁTICA MAESTRA

### A. Rojo Carmesí Departamental (Oruro)
El Rojo Carmesí es el color emblema de la bandera departamental de Oruro. En el sistema se utiliza en tonalidades nobles y oscurecidas para brindar profundidad y jerarquía.

| Rol | Token / Variable | Valor HEX | Valor RGB | Uso Principal |
| :--- | :--- | :--- | :--- | :--- |
| **Carmesí Oscurecido Noble** | `--primary-dark` | `#4d000d` | `rgb(77, 0, 13)` | Fondos de paneles en Login (Modo Claro y Oscuro), tarjetas principales. |
| **Carmesí Institucional Base** | `--primary` | `#50000e` | `rgb(80, 0, 14)` | Encabezados de tablas, barras de navegación, botones primarios. |
| **Carmesí Medio** | `--primary-medium` | `#680014` | `rgb(104, 0, 20)` | Punto central de gradientes institucionales y bordes activos. |
| **Carmesí de Acción / Hover** | `--primary-hover` | `#881337` | `rgb(136, 19, 55)` | Estado `:hover` en botones, pestañas seleccionadas y destacados. |
| **Carmesí Claro (Acento)** | `--primary-light` | `#fff1f2` | `rgb(255, 241, 242)` | Fondos de alerta suave y selección en Modo Claro. |

### B. Dorado Institucional (Oruro Gold)
El dorado simboliza la riqueza histórica, minera y el prestigio cívico del departamento. Se aplica como vivo o acento visual para realzar textos, bordes de relieve y elementos interactivos.

| Rol | Token / Variable | Valor HEX | Valor RGB | Uso Principal |
| :--- | :--- | :--- | :--- | :--- |
| **Oro Profundo / Viejo** | `--accent-gold-dark` | `#b45309` | `rgb(180, 83, 9)` | Textos secundarios en modo claro, bordes sutiles. |
| **Oro Noble / Primario** | `--accent` | `#f59e0b` | `rgb(245, 158, 11)` | Bordes activos, títulos de gestión, halos de enfoque e iconos. |
| **Oro Radiante / Resaltado** | `--accent-gold` | `#fde047` | `rgb(253, 224, 71)` | Subtítulos de cabecera, hover de píldoras, distintivos de notificación. |

### C. Fondos y Superficies Neutras (0% Azul)

#### Modo Claro (Platino & Blanco Puro)
* **Fondo de Ventana:** `#f1f5f9` (Platino suave y limpio).
* **Superficies / Tarjetas:** `#ffffff` (Blanco puro con sombra sutil).
* **Bordes Generales:** `#cbd5e1` / `#e2e8f0`.
* **Texto Principal:** `#18181b` (Negro carbón puro de alta legibilidad, 0% azul).
* **Texto Secundario:** `#27272a` / `#475569` (Grafito neutro).

#### Modo Oscuro (Carbono & Obsidiana Institucional)
* **Fondo de Ventana:** `#121316` (Carbono neutro puro, sin tinte azulado).
* **Superficies / Tarjetas / Modales:** `#1a181c` y `#1c1a1e` (Obsidiana oscura).
* **Bordes Generales:** `rgba(255, 255, 255, 0.08)` y filetes dorados `rgba(245, 158, 11, 0.25)`.
* **Texto Principal:** `#f8fafc` (Blanco platino).
* **Texto Secundario:** `#cbd5e1` y `#94a3b8`.

---

## 3. ESPECIFICACIÓN DE COMPONENTES

### 3.1. Pantalla de Acceso (Login - `index.php`)
* **Contenedor:**
  - Modo Claro: Marco blanco con borde `#cbd5e1` y sombra profunda.
  - Modo Oscuro: Marco `#141214` con ribete perimetral dorado `rgba(245, 158, 11, 0.25)`.
* **Panel Derecho (Heráldica e Identidad):**
  - **Fondo:** Gradiente noble `linear-gradient(150deg, #4d000d 0%, #680014 50%, #4d000d 100%)`.
  - **Escudo Departamental:** Sombra con halo dorado `filter: drop-shadow(0 4px 10px rgba(0,0,0,0.35)) drop-shadow(0 0 12px rgba(245, 158, 11, 0.3))`.
  - **Franja Institucional:** Línea horizontal de Carmesí a Dorado puro `linear-gradient(90deg, #780016 0%, #d97706 35%, #fde047 50%, #d97706 65%, #780016 100%)`.
  - **Título:** Blanco puro (`#ffffff`) en caja alta con interlineado formal.
  - **Subtítulo:** Dorado radiante (`#fde047`).
* **Píldoras de «Consultas de Gestión»:**
  - Estructura: Formato botón interactivo (grid de 2 columnas).
  - Reposo: Fondo semitransparente con borde dorado `rgba(245, 158, 11, 0.45)`, texto blanco e icono de calendario `📅`.
  - Hover: Fondo blanco (modo claro) o carmesí vibrante (modo oscuro), borde `#f59e0b`, elevación `-2px` y sombra dorada radiante.
* **Panel Izquierdo (Formulario de Ingreso):**
  - Avatar: Doble anillo concéntrico con Carmesí (`#580010`) y halo dorado (`rgba(245, 158, 11, 0.45)`).
  - Campos de Texto: Foco con borde carmesí y anillo exterior oro (`box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.3)`).
  - Botón «Iniciar Sesión»: Gradiente noble Carmesí (`#50000e` &rarr; `#6e0015`) con borde oro sutil y elevación activa.

### 3.2. Cabecera Institucional (`content/header.php`)
* **Modo Claro:**
  - Fondo: Gradiente carmesí noble `linear-gradient(135deg, #4d000d 0%, #680014 100%)`.
  - Filete Inferior: Línea dorada de 2px (`border-bottom: 2px solid #f59e0b`).
  - Badges / Botones de barra: Blanco traslúcido con borde dorado suave y hover a blanco sólido con texto carmesí.
* **Modo Oscuro:**
  - Fondo: Carbono neutro `#141316`.
  - Filete Inferior: Carmesí departamental de 2px (`border-bottom: 2px solid #780016`).
  - Badges: Superficie `#1c1a1e` con bordes sutiles y acentos en oro y verde esmeralda.

### 3.3. Menú Lateral Acordeón (`content/menu.php`)
* **Encabezados de Región:**
  - Modo Claro: Gradiente Carmesí noble (`#4d000d` &rarr; `#680014`) con borde dorado `rgba(245, 158, 11, 0.4)`.
  - Modo Oscuro: Carbono `#141316` con borde activo en carmesí oscuro `rgba(120, 0, 22, 0.5)`.
  - Flecha Desplegable: Vector SVG Chevron en **Oro Oruro** (`#fde047` / `#f59e0b`), erradicando las imágenes azules antiguas.
* **Ítems del Menú:**
  - Modo Claro: Texto carmesí con viñeta circular carmesí; hover con fondo `#fff1f2` y desplazamiento a la derecha.
  - Modo Oscuro: Texto `#cbd5e1`; hover con fondo `rgba(120, 0, 22, 0.25)` y texto iluminado en carmesí suave.

### 3.4. Tablas y Rejillas de Correspondencia (`default.css`)
* **Encabezados (`<th>`):** Gradiente Carmesí noble (`#4d000d` &rarr; `#680014`) con filete inferior en **Dorado Institucional** (`border-bottom: 2px solid #f59e0b`).
* **Flechas de Ordenamiento:** Triángulos en Dorado Radiante (`#fde047`).
* **Filas:** Alternancia sobria en blanco/platino (modo claro) o carbono `#1c1a1e` / transparente (modo oscuro), con hover carmesí muy suave (`rgba(120, 0, 22, 0.15)`).

### 3.5. Diálogos, Modales y Comunicados (`dialog.css` y `postales/`)
* **Barra de Título del Modal:** Gradiente Carmesí Noble con filete inferior dorado (`border-bottom: 2px solid #f59e0b`).
* **Cuerpo del Modal:** Tarjeta en blanco puro (modo claro) o carbono `#1a181c` con ribete dorado (modo oscuro).
* **Overlay de Fondo:** Carbono neutro `#121316` con opacidad balanceada (sin tonalidades azuladas).
* **Etiquetas de Memorándum:** Dorado Institucional (`#f59e0b`) en modo oscuro y Carmesí noble (`#50000e`) en modo claro.

### 3.6. Pantalla de Cierre de Sesión (`cerrarSession.php`)
* **Dual-Theme Dinámico:** Conmutación automática según el tema guardado en `localStorage`.
* **Tarjeta Central:** Carbono `#141214` (modo oscuro) o blanco puro (modo claro) con doble borde carmesí y oro.
* **Spinner de Espera:** Corona circular de doble tono: arco principal en **Rojo Carmesí** y arco secundario en **Dorado**.

---

## 4. MATRIZ DE APLICABILIDAD DE REGLAS CSS

```css
/* Gradiente Primario Noble GADOR */
--header-gradient: linear-gradient(135deg, #4d000d 0%, #680014 100%);

/* Filete Dorado Oficial */
--border-gold-accent: 2px solid #f59e0b;

/* Píldora Interactiva Estandarizada */
.gad-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 6px;
    border: 1px solid rgba(245, 158, 11, 0.45);
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    transition: all 0.25s ease;
}

/* Enfoque Accesible Universal */
:focus-visible {
    outline: none !important;
    border-color: #6e0015 !important;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.35) !important;
}
```

---

## 5. RECOMENDACIONES DE MANTENIMIENTO FUTURO

1. **Inclusión Centralizada:** Cualquier nueva subvista, reporte imprimible o diálogo que se incorpore al sistema debe enlazar obligatoriamente:
   - `<link href="content/css/theme_variables.css" rel="stylesheet" type="text/css" />`
   - `<script src="content/js/theme_switcher.js" type="text/javascript"></script>`
2. **Uso Exclusivo de Variables:** No escribir colores hexadecimales manuales en los archivos PHP; utilizar siempre las variables CSS definidas en `theme_variables.css` (`var(--primary)`, `var(--accent)`, `var(--bg-app)`, etc.).
3. **Preservación:** No modificar la paleta institucional bajo ninguna circunstancia partidaria para garantizar la vigencia permanente de la imagen oficial del Gobierno Autónomo Departamental de Oruro.

