# Plan: Agregar Imagenes a Productos y Presupuesto PDF

## Pasos:
1. Crear migracion para agregar campo `imagen` a tabla `productos`
2. Actualizar modelo Productos con accessor de URL
3. Verificar storage:link
4. Actualizar StoreProductoRequest con validacion de imagen
5. Actualizar ProductoController (store, update, destroy) con manejo de imagen
6. Actualizar vista productos/index.blade.php (tabla, modales crear/editar, enctype)
7. Actualizar JS rulesMantenimientoProductos.js (columna, preview, edit handler)
8. Actualizar PresupuestoController::mostrarPDF() para cargar imagenes de productos
9. Actualizar vista presupuesto/pdf.blade.php para mostrar imagen del producto