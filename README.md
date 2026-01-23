# 🎓 NosaNet
**Plataforma de comunicación académica moderada**

## 🧠 Descripción

**NosaNet** es una red social interna desarrollada como proyecto académico para la asignatura **Bases de Computación 5 (BC5)**. La aplicación permite a **alumnos y profesores** compartir mensajes educativos en un entorno controlado y seguro, con un sistema de moderación que garantiza la calidad y adecuación del contenido.

El proyecto implementa una **arquitectura profesional** utilizando Laravel, aplicando **patrones de diseño modernos** y **principios de desarrollo de software** aprendidos durante el curso. La persistencia se maneja mediante archivos **JSON**, preparando el terreno para una futura migración a base de datos relacional en BC6.

**Destinatarios principales:**
- **Estudiantes** que necesitan compartir dudas y recursos
- **Profesores** que desean publicar anuncios y moderar contenido
- **Desarrolladores** que buscan aprender arquitectura MVC con Laravel

## 🚀 Funcionalidades Principales

### 👥 Sistema de Usuarios
- **Registro dual**: Alumnos y profesores con roles diferenciados
- **Autenticación segura**: Hash bcrypt + rotación de ID de sesión
- **Perfiles personalizados**: Tema claro/oscuro persistente

### 💬 Gestión de Mensajes
- **Publicación controlada**: 1-280 caracteres con validación en tiempo real
- **Asignaturas organizadas**: 9 categorías académicas predefinidas
- **Estados de mensaje**: `pendiente` → `aprobado` → `eliminado`

### 🛡️ Sistema de Moderación
- **Panel exclusivo**: Solo accesible para profesores
- **Validación automática**: Detección de contenido peligroso (70+ patrones)
- **Acciones manuales**: Aprobación/eliminación con justificación

### 🎨 Experiencia de Usuario
- **Tema dinámico**: Claro/oscuro con persistencia en cookies (30 días)
- **Interfaz responsive**: Adaptada a móviles, tablets y desktop
- **Feedback inmediato**: Alertas de éxito/error contextuales

### 🔒 Seguridad Avanzada
- **Protección XSS**: Auto-escape en vistas + `htmlspecialchars()`
- **Prevención SQLi**: Validación de patrones peligrosos
- **Control de acceso**: Middleware por rol y autenticación

## 🛠️ Tecnologías Usadas

### Backend
- **PHP 8.2+** - Lenguaje principal del servidor
- **Laravel 12.46.0** - Framework MVC profesional
- **Composer** - Gestor de dependencias PHP

### Frontend
- **HTML5** - Estructura semántica
- **CSS3** - Estilos personalizados con variables CSS
- **Blade Templates** - Sistema de plantillas de Laravel

### Arquitectura
- **Repository Pattern** - Abstracción de persistencia JSON
- **Active Record Pattern** - Modelos con comportamiento
- **Middleware Pattern** - Filtros HTTP reutilizables
- **MVC** - Separación clara de responsabilidades

### Herramientas de Desarrollo
- **XAMPP** - Entorno de desarrollo local
- **VS Code** - Editor principal
- **Git** - Control de versiones



