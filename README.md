# Reciclapp

Plataforma web construida con Laravel y Vite para gestionar las solicitudes de recolección selectiva de residuos en Bogotá. Las y los ciudadanos pueden programar sus recogidas según el tipo de residuo y las reglas del servicio, mientras que el personal administrativo dispone de tableros y exportaciones en CSV para coordinar las rutas.

## Características principales

### Módulo ciudadano
- **Programación guiada de recolecciones** con pasos para elegir el tipo de residuo, dirección y localidad.
- **Validaciones automáticas según el residuo**:
  - Orgánicos: la fecha se calcula automáticamente en función de la localidad asignada por el distrito y siempre quedan como modalidad programada.
  - Inorgánicos: requiere seleccionar modalidad (programada o a demanda) y permite máximo dos solicitudes por semana.
  - Peligrosos: exige fecha y hora y limita a una solicitud al mes.
- **Tablero personal con filtros avanzados** por fecha, tipo, estado y exportación propia a CSV.

### Módulo administrativo
- **Gestión de usuarios** con edición de datos de contacto y rol (admin/usuario).
- **Panel de recolecciones global** con filtros por usuario, localidad, modalidad, estado y rango de fechas, además de descarga masiva en CSV.
- **Catálogo de localidades** precargado (Usaquén, Chapinero, Suba, etc.) mediante seeders.

## Stack tecnológico
- [Laravel 12](https://laravel.com/) con autenticación Breeze y componentes Blade.
- PHP 8.2+, Composer y migraciones con Eloquent.
- Vite + Tailwind CSS + Alpine.js para la capa interactiva del frontend.
- Base de datos relacional (MySQL, PostgreSQL o SQLite) gestionada mediante migraciones y seeders.

## Requisitos
- PHP 8.2 o superior con extensiones `pdo` y `mbstring`.
- Composer 2.x.
- Node.js 18+ y npm.
- Motor de base de datos compatible con Laravel (MySQL/MariaDB, PostgreSQL o SQLite).

## Puesta en marcha local
1. **Clonar e instalar dependencias**
   ```bash
   git clone <url-del-repo>
   cd reciclapp
   composer install
   npm install
   ```
2. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Ajusta las variables `APP_URL`, `APP_NAME` y las credenciales de la base de datos (`DB_*`). Para un arranque rápido puedes usar SQLite:
   ```bash
   touch database/database.sqlite
   # En .env define DB_CONNECTION=sqlite y comenta el resto de variables DB_
   ```
3. **Migrar y poblar datos base**
   ```bash
   php artisan migrate --seed
   ```
   Esto creará las tablas de usuarios y recolecciones, además de cargar las 20 localidades de Bogotá.
4. **Levantar los servicios de desarrollo**
   ```bash
   # En una terminal
   php artisan serve

   # En otra terminal
   npm run dev
   ```
   La aplicación quedará disponible en `http://localhost:8000` con los assets servidos por Vite.

## Scripts útiles
- `php artisan test`: ejecuta la suite de pruebas.
- `php artisan migrate:fresh --seed`: reconstruye la base de datos desde cero.
- `npm run build`: genera los assets compilados para producción.

## Despliegue
- Incluye `Procfile` y configuración para plataformas como Heroku y Vercel. Ajusta las variables de entorno de producción y ejecuta `php artisan migrate --force` durante el despliegue.

## Licencia
Este proyecto se distribuye bajo la licencia MIT.
