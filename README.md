# Sistema Incendios 🔥

Proyecto Laravel para registrar y gestionar reportes de incendios.

---

## ⚙️ Requisitos del sistema

Antes de ejecutar el proyecto necesitas instalar:

### 🔧 Entorno backend
- XAMPP 8.2.12 / PHP 8.2.12 (incluye PHP y Apache)
  👉 https://www.apachefriends.org/download.html

### 📦 Dependencias de PHP
- Composer
  👉 https://getcomposer.org/

### 🌐 Dependencias frontend
- Node.js (incluye npm)
  👉 https://nodejs.org/
(O obtiene una versión pre compilada de Node.js® para 'Windows' usando la arquitectura 'x64', descargar '.msi')

---

## 🧠 Importante

- PHP viene incluido en XAMPP
- No necesitas instalar PHP por separado
- Node.js es obligatorio para ejecutar `npm install`

---

## 🚀 Instalación

### 1. Clonar el proyecto
```bash
git clone https://github.com/AnthonyConti2203/sistema-incendios.git
cd sistema-incendios
````

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias frontend
```bash
npm install
```

### 4. Crear archivo .env

```bash
cp .env.example .env
```
### Si estás en Windows y falla el comando, copiar manualmente:
```bash
.env.example → .env
```

### 5. Generar clave

```bash
php artisan key:generate
```

### 6. Crear manualmente la base de datos SQLite

```bash
database/database.sqlite
```
### Luego verificar que en .env exista (si no es asi modificar):
```bash
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 7. Instalar Laravel Breeze (autenticación)
```bash
composer require laravel/breeze --dev
```
```bash
php artisan breeze:install blade
```

### 8. Compilar frontend
```bash
npm run dev
```

### 9. Ejecutar migraciones

```bash
php artisan migrate
```

### 10. Iniciar servidor
```bash
php artisan serve
```
### Abrir en navegador:
```bash
http://127.0.0.1:8000
```

---

## 👥 Trabajo en equipo

* Todo se trabaja en la rama `main`

### Antes de empezar:

```bash
git pull origin main
```

### Después de cambios:

```bash
git add .
git commit -m "título del cambio" -m "Descripción del cambio."
git push origin main
```

---

## ⚠️ Importante

* ❌ NO subir `.env`
* ❌ NO subir `database/database.sqlite`
* ❌ NO subir `vendor`
* ❌ NO subir node_modules