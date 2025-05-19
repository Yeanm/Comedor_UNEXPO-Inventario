# Comedor_UNEXPO-Inventario
CRUB para inventario para la comunidad UNEXPO.  

# Pasos para que funcione el CRUB
1. Crear base de datos en phpMyAdmin
2. importar inventario_db.sql en la ruta assets\components\bd\inventario_db.sql
3. Ingresar contraseña en DB_PASS del archivo config.php en caso de tener una contraseña en el phpMyAdmin  
# 📂 Estructura del Proyecto  
```bash
ComedorUNEXPO-Yancarlos Camacaro/  
├── assets/  
│   ├── components/
|   |     ├── bd/          # Base de datos
|   |     └── sidebar.php  # Barra lateral (solo estetico)  
│   ├── css/               # Estilos utilizados  
│   └── js/                # Codigo JavaScript
├── controlador/           # Controlador del CRUB  
├── modelo/                # Logica del CRUB  
├── vista/                 # Formulartio del inventario
├── config.php             # Datos para ingreso a la Base de datos
└── index.php              # Punto de entrada
```   
