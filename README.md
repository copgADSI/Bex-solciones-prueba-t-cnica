# Instrucciones para levantar un Proyecto con Laravel y Vue.js

## Prerrequisitos

Asegúrate de tener instalados los siguientes programas en tu máquina:

- [Composer](https://getcomposer.org/download/) (para gestionar dependencias de PHP)
- [Node.js](https://nodejs.org/) (incluye npm, el gestor de paquetes de JavaScript)
- [Git](https://git-scm.com/downloads) (para clonar el proyecto, si es necesario)
- [PHP](https://www.php.net/manual/en/install.php) (version 7.3 o superior)
- [Laravel](https://laravel.com/docs/8.x/installation) (globalmente instalado)

## 1. Clonar el Repositorio

Clona el repositorio del proyecto en tu máquina local.

```bash
git clone https://github.com/copgADSI/Bex-solciones-prueba-t-cnica.git
cd prueba-laravel-vue


## 2. Instalar dependiencias de proyecto

```bash
composer install

```bash
npm i

## 3. Copiar archivo .env.example a .env
```bash
cp .env.example .env

## 4. Generar la clave de la aplicación
```bash
php artisan key:generate

## 5. Correr migraciones
```bash
php artisan migrate

## 6. Levantar servidor de desarrollo
```bash
php artisan serve
```bash
npm run dev
