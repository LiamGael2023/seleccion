# Sistema de Selección de Personal V2 - Guía de Actualización

## 🎯 Nuevas Características

El sistema ahora soporta **múltiples perfiles por convocatoria**. Cada perfil puede tener:
- Su propia área
- Sus propios requisitos
- Sus propias carreras aceptadas
- Su propio número de vacantes
- Descripción independiente

### Ejemplo Práctico:
```
Convocatoria: "Prácticas Profesionales Periodo 1 - 2025"
├── Perfil 1: "Practicante Ing. Civil"
│   ├── Área: Operación y Mantenimiento
│   ├── Carreras: Ingeniería Civil
│   └── Vacantes: 1
├── Perfil 2: "Practicante Ing. Agrícola"
│   ├── Área: Producción
│   ├── Carreras: Ing. Agrícola, Ing. Agronómica
│   └── Vacantes: 1
└── Perfil 3: "Practicante Ing. Industrial"
    ├── Área: Calidad
    ├── Carreras: Ing. Industrial
    └── Vacantes: 2
```

---

## 📦 Instalación para Nuevos Usuarios

### 1. Importar la Base de Datos V2

**Opción A - Instalación Limpia (Recomendado):**
```bash
# Desde phpMyAdmin:
1. Crea la base de datos 'seleccion_personal'
2. Importa el archivo 'database_v2.sql'
```

**Opción B - Línea de Comandos:**
```bash
C:\xampp\mysql\bin\mysql -u root -p --port=3307 < database_v2.sql
```

Esta base de datos incluye:
- Usuario admin: `admin@seleccion.com` / `admin123`
- Áreas de ejemplo
- Carreras de ejemplo
- Una convocatoria de ejemplo con 3 perfiles

---

## 🔄 Actualización desde V1

Si ya tienes el sistema instalado con la versión anterior:

### 1. Respaldar tu Base de Datos

```bash
C:\xampp\mysql\bin\mysqldump -u root -p --port=3307 seleccion_personal > backup.sql
```

### 2. Ejecutar el Script de Migración

**Desde phpMyAdmin:**
1. Abre la base de datos `seleccion_personal`
2. Ve a la pestaña "SQL"
3. Abre el archivo `database_migration_perfiles.sql`
4. Copia todo el contenido y pégalo
5. Haz clic en "Continuar"

**Desde Línea de Comandos:**
```bash
C:\xampp\mysql\bin\mysql -u root -p --port=3307 seleccion_personal < database_migration_perfiles.sql
```

### 3. Migrar Convocatorias Antiguas (IMPORTANTE)

Las convocatorias antiguas **NO se migran automáticamente** a perfiles. Tienes dos opciones:

**Opción A - Manual (Recomendado):**
1. Ingresa al sistema como admin
2. Crea nuevas convocatorias y sus perfiles desde cero

**Opción B - Mantener Datos:**
Si necesitas mantener las convocatorias antiguas, contacta soporte para un script de migración personalizado.

---

## 🚀 Cómo Usar el Nuevo Sistema

### Para Administradores

#### 1. Crear una Convocatoria

1. Ve a **Admin → Convocatorias → Nueva Convocatoria**
2. Completa el formulario:
   - **Título**: Nombre general (ej: "Prácticas Profesionales Periodo 1")
   - **Descripción**: Descripción general (opcional)
   - **Tipo de Contrato**: Prácticas, Tiempo Completo, etc.
   - **Fechas**: Inicio y cierre
   - **Estado**: Borrador o Publicada
3. Haz clic en **"Guardar y Agregar Perfiles"**

#### 2. Agregar Perfiles a la Convocatoria

Después de crear la convocatoria, serás redirigido a la página de perfiles:

1. Haz clic en **"Nuevo Perfil"**
2. Completa el formulario:
   - **Título del Perfil**: Nombre específico (ej: "Practicante Ing. Civil")
   - **Área**: Selecciona el departamento
   - **Descripción**: Funciones del puesto
   - **Requisitos**: Requisitos específicos
   - **Responsabilidades**: Actividades a realizar
   - **Carreras**: Marca las carreras afines
   - **Experiencia**: Años requeridos
   - **Vacantes**: Número de plazas
   - **Orden**: Para ordenar la visualización (0 = primero)
3. Haz clic en **"Guardar Perfil"**
4. Repite para agregar más perfiles

#### 3. Gestionar Perfiles

Desde **Convocatorias → Perfiles**:
- ✅ Ver todos los perfiles de una convocatoria
- ✏️ Editar perfiles existentes
- 🗑️ Eliminar perfiles
- 👥 Ver postulaciones por perfil

#### 4. Revisar Postulaciones

Dos formas de ver postulaciones:

**Por Convocatoria General:**
- **Convocatorias → Ver Postulaciones** (todas las postulaciones)

**Por Perfil Específico:**
- **Convocatorias → Perfiles → Ver Postulaciones** (solo de ese perfil)

En cada postulación puedes:
- Cambiar el estado (Pendiente, Revisión, Entrevista, Aceptado, Rechazado)
- Asignar puntuación (0-100)
- Agregar comentarios

---

### Para Candidatos

#### 1. Ver Convocatorias

Visita el portal público (`http://localhost/seleccion/`) y verás:
- Convocatorias disponibles
- Número de perfiles en cada una
- Fechas de cierre

#### 2. Ver Perfiles

Haz clic en **"Ver Perfiles Disponibles"** para ver:
- Todos los perfiles dentro de la convocatoria
- Requisitos específicos de cada perfil
- Carreras aceptadas
- Número de vacantes

#### 3. Postularse

1. Selecciona el perfil de tu interés
2. Haz clic en **"Postularme a este Perfil"**
3. Completa el formulario con tus datos
4. Sube tu CV (PDF o Word)
5. Acepta los términos
6. Haz clic en **"Enviar Postulación"**

**IMPORTANTE:** Cada candidato puede postularse a **múltiples perfiles** dentro de la misma convocatoria o en diferentes convocatorias.

---

## 📊 Diferencias entre V1 y V2

| Característica | V1 (Antiguo) | V2 (Nuevo) |
|----------------|--------------|------------|
| **Estructura** | 1 Convocatoria = 1 Puesto | 1 Convocatoria = Múltiples Perfiles |
| **Áreas** | 1 área por convocatoria | 1 área por perfil (flexib) |
| **Carreras** | 1 lista por convocatoria | 1 lista por perfil |
| **Vacantes** | 1 número por convocatoria | 1 número por perfil |
| **Postulaciones** | A la convocatoria | A perfiles específicos |
| **Flexibilidad** | Limitada | Alta |

---

## 🔧 Solución de Problemas

### Error: "Unknown column 'perfil_id'"

**Causa:** No ejecutaste el script de migración.

**Solución:**
```bash
C:\xampp\mysql\bin\mysql -u root -p --port=3307 seleccion_personal < database_migration_perfiles.sql
```

### No aparecen los perfiles en el portal público

**Verifica:**
1. La convocatoria está en estado **"Publicada"**
2. Has creado al menos un perfil
3. El perfil está **Activo** (activo = 1)

### Los candidatos no pueden postularse

**Verifica:**
1. La convocatoria está **"Publicada"**
2. La fecha de cierre no ha pasado
3. El perfil existe y está activo

---

## 📝 Preguntas Frecuentes

### ¿Puedo tener una convocatoria con un solo perfil?

Sí, perfectamente. Una convocatoria puede tener 1 o muchos perfiles.

### ¿Los candidatos pueden postularse a varios perfiles?

Sí, un candidato puede postularse a múltiples perfiles, incluso de la misma convocatoria.

### ¿Puedo eliminar una convocatoria con perfiles?

Sí, al eliminar una convocatoria se eliminarán automáticamente todos sus perfiles y postulaciones.

### ¿Puedo cambiar perfiles de una convocatoria a otra?

No directamente. Debes crear el perfil de nuevo en la otra convocatoria.

### ¿Qué pasa con las postulaciones antiguas?

Si migraste la base de datos, las postulaciones antiguas permanecerán pero **sin relación a perfiles**. Recomendamos cerrar esas convocatorias y crear nuevas.

---

## 💡 Mejores Prácticas

1. **Nomenclatura Clara:**
   - Convocatoria: "Prácticas 2025 - Periodo 1"
   - Perfiles: "Practicante Ing. Civil - Operaciones"

2. **Orden de Perfiles:**
   - Usa el campo "Orden" para controlar cómo aparecen los perfiles

3. **Estados:**
   - Usa "Borrador" mientras configuras perfiles
   - Cambia a "Publicada" cuando esté lista

4. **Carreras:**
   - Sé específico en las carreras aceptadas por perfil
   - Un perfil puede aceptar múltiples carreras afines

5. **Vacantes:**
   - Define vacantes por perfil, no por convocatoria general

---

## 🆘 Soporte

Si tienes problemas:
1. Revisa `TROUBLESHOOTING.md`
2. Verifica los logs de Apache: `C:\xampp\apache\logs\error.log`
3. Verifica que la base de datos esté correctamente migrada

---

## ✅ Checklist de Verificación Post-Instalación

- [ ] Base de datos importada (`database_v2.sql`)
- [ ] Puedes iniciar sesión como admin
- [ ] Áreas están disponibles
- [ ] Carreras están disponibles
- [ ] Puedes crear una convocatoria
- [ ] Puedes agregar perfiles a la convocatoria
- [ ] Los perfiles aparecen en el portal público
- [ ] Puedes postularte a un perfil desde el portal público
- [ ] Las postulaciones aparecen en el panel de administración

---

**¡El sistema está listo para usarse!** 🎉
