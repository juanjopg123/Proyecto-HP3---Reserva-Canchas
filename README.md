## 🛠️ Tecnologías Usadas

- **Versión de Laravel:** 11
- **Base de datos:** PostgreSQL
- **Autenticación:**
  - Laravel Breeze (incluye Tailwind CSS)
- **Gestión de seguridad:**
  - Spatie Laravel-permission
- **Node.js y npm:**
  - Para ejecutar Tailwind CSS

---

## 🧭 Instrucciones de Instalación, Configuración y Arranque del Proyecto

Bienvenidos a una experiencia Laravel!

1. Tener instalado composer
2. Abrir la carpeta: `cd reserva_canchas`
3. Ejecutar: `composer update`
4. Crear el archivo `.env` (puedes copiarlo desde `.env.example`).
5. Configurar la base de datos en el `.env` (nombre: `reservas_canchas`).
6. Crear la base de datos en pgAdmin4 con el nombre `reservas_canchas`.
7. Ejecutar migraciones: `php artisan migrate`
8. Generar clave de la app: `php artisan key:generate`
9. Ejecutar los Seeders: `php artisan migrate:fresh --seed`
10. Abrir 2 terminales en VS Code:
    - Terminal 1: `php artisan serve` → http://localhost:8000
    - Terminal 2: `npm install` y luego `npm run dev`
11. Acceder a la URL [http://localhost:8000](http://localhost:8000)

