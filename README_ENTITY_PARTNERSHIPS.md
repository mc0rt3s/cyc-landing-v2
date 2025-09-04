# Sistema de Socios por Empresa - Entity Partnerships

## 🎯 **Descripción del Sistema**

El sistema de **Entity Partnerships** permite gestionar las relaciones societarias entre empresas y sus socios, donde una empresa puede tener múltiples socios (personas u otras empresas) con diferentes porcentajes de participación.

## 🏗️ **Arquitectura Técnica**

### **Base de Datos**

-   **Tabla**: `entity_partnerships`
-   **Relación**: Many-to-Many entre empresas y socios
-   **Campos principales**:
    -   `entity_dni`: DNI de la empresa
    -   `partner_dni`: DNI del socio (persona u otra empresa)
    -   `participation_percentage`: Porcentaje de participación (0.00 - 100.00)
    -   `partnership_type`: Tipo de participación (socio, accionista, participe, otro)
    -   `start_date`: Fecha de inicio de la participación
    -   `end_date`: Fecha de fin (opcional)
    -   `is_active`: Estado de la participación
    -   `notes`: Notas adicionales

### **Modelos**

-   **EntityPartnership**: Modelo principal para gestionar partnerships
-   **Entity**: Modelo extendido con relaciones de socios
-   **Relaciones**:
    -   `Entity::partners()`: Socios de la empresa
    -   `Entity::partnerships()`: Empresas donde es socio
    -   `Entity::activePartners()`: Socios activos

## 🎨 **Interfaz de Usuario**

### **Relation Manager**

-   **Ubicación**: Pestaña "Socios de la Empresa" en la vista de empresas
-   **Funcionalidades**:
    -   ✅ **Agregar socios** con porcentaje de participación
    -   ✅ **Editar participaciones** existentes
    -   ✅ **Eliminar socios** de la empresa
    -   ✅ **Filtros avanzados** por tipo, estado, etc.
    -   ✅ **Búsqueda** por RUT o nombre del socio
    -   ✅ **Paginación** configurable

### **Características de la Interfaz**

-   **Vista condicional**: Solo visible para empresas
-   **Validaciones en tiempo real**: Porcentajes que no excedan 100%
-   **Tipos de participación**: Socio, Accionista, Participe, Otro
-   **Estados visuales**: Activo/Inactivo con iconos
-   **Información completa**: RUT, nombre, tipo, porcentaje, fechas

## 🔧 **Funcionalidades Implementadas**

### **Gestión de Socios**

1. **Agregar Socio**:

    - Selección de entidad (persona o empresa)
    - Definición de porcentaje de participación
    - Tipo de participación
    - Fechas de inicio y fin
    - Notas adicionales

2. **Editar Participación**:

    - Modificar porcentaje de participación
    - Cambiar tipo de participación
    - Actualizar fechas
    - Modificar estado activo/inactivo

3. **Eliminar Socio**:
    - Confirmación de eliminación
    - Eliminación en lote
    - Soft delete para auditoría

### **Validaciones de Negocio**

-   **Porcentajes**: Validación que no excedan 100% total
-   **Tipos válidos**: Solo tipos de participación definidos
-   **Fechas**: Fecha de fin posterior a fecha de inicio
-   **Unicidad**: Evitar duplicados en la misma fecha

### **Filtros y Búsqueda**

-   **Por tipo de participación**: Socio, Accionista, etc.
-   **Por estado**: Activo, Inactivo, Todos
-   **Por tipo de socio**: Persona, Empresa
-   **Búsqueda general**: Por RUT o nombre

## 📊 **Datos de Prueba**

### **Seeder Implementado**

-   **EntityPartnershipSeeder**: Crea partnerships de prueba
-   **Empresas con socios**: 5 empresas con 2-4 socios cada una
-   **Partnerships entre empresas**: Participaciones cruzadas
-   **Porcentajes realistas**: Suman 100% por empresa
-   **Fechas variadas**: Diferentes períodos de participación

### **Ejemplos de Datos**

```
Empresa: C y C Isla y Cia. Limitada
├── Socio 1: Juan Pérez (34%)
├── Socio 2: María González (24%)
├── Socio 3: Carlos López (29%)
└── Socio 4: Ana Martínez (13%)
Total: 100%
```

## 🚀 **Características Técnicas Destacadas**

### **1. Relaciones Many-to-Many Complejas**

-   Empresas pueden tener múltiples socios
-   Personas pueden ser socios de múltiples empresas
-   Empresas pueden ser socios de otras empresas

### **2. Validaciones Robustas**

-   Porcentajes que sumen 100%
-   Tipos de participación válidos
-   Fechas coherentes
-   Estados consistentes

### **3. Interfaz Intuitiva**

-   Relation Manager integrado
-   Filtros avanzados
-   Búsqueda eficiente
-   Acciones en lote

### **4. Auditoría Completa**

-   Soft deletes para historial
-   Timestamps de creación/modificación
-   Notas para documentación

## 🎯 **Casos de Uso**

### **Para la Reunión de Mañana**

1. **Demostrar gestión de socios**: Agregar/editar/eliminar socios
2. **Mostrar validaciones**: Intentar exceder 100% de participación
3. **Exhibir filtros**: Filtrar por tipo, estado, etc.
4. **Presentar búsqueda**: Buscar socios por RUT o nombre
5. **Mostrar datos reales**: Empresas con socios reales

### **Funcionalidades Clave a Destacar**

-   ✅ **Sistema robusto** de gestión societaria
-   ✅ **Validaciones de negocio** implementadas
-   ✅ **Interfaz profesional** y funcional
-   ✅ **Datos reales** para demostración
-   ✅ **Escalabilidad** para múltiples empresas

## 🔄 **Próximos Pasos**

### **Mejoras Futuras**

1. **Reportes de estructura societaria**
2. **Historial de cambios en participaciones**
3. **Validaciones de porcentajes en tiempo real**
4. **Exportación de datos de socios**
5. **Notificaciones de cambios importantes**

### **Integración con Otros Módulos**

-   **Sistema de usuarios**: Asignar responsables por empresa
-   **Sistema de servicios**: Servicios específicos por tipo de socio
-   **Sistema de circulares**: Notificaciones a socios

## 📝 **Comandos Útiles**

```bash
# Ejecutar migración
php artisan migrate

# Crear datos de prueba
php artisan db:seed --class=EntityPartnershipSeeder

# Limpiar cache
php artisan optimize:clear

# Servidor de desarrollo
php artisan serve
```

## 🎉 **Estado del Proyecto**

**✅ COMPLETADO Y FUNCIONAL**

-   Base de datos implementada
-   Modelos configurados
-   Relation Manager funcional
-   Datos de prueba creados
-   Interfaz operativa
-   Validaciones implementadas

**🚀 LISTO PARA DEMOSTRACIÓN**
El sistema está completamente funcional y listo para ser presentado en la reunión de mañana.
