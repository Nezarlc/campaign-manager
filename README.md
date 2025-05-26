# Gestor de Campañas (Symfony Console App)

Proyecto Symfony orientado a consola para gestionar campañas publicitarias y asignar influencers.

---

## Requisitos

- PHP 8.1 o superior  
- Composer  
- Symfony CLI (opcional, pero recomendado)  
- MySQL o MariaDB  
- Extensión PHP: `pdo_mysql`  

---

## Instalación

git clone git@github.com:Nezarlc/campaign-manager.git  

cd gestor-campanas-consola  

composer install  

Configurar .env con los datos de la db (mysql)  

##  Comandos disponibles

### `app:create-campaign`

Crea una nueva campaña solicitando los datos por consola.

### `app:list-campaign`

Muestra todas las campañas en una tabla, incluyendo los nombres de los influencers asociados.

### `app:list-campaign <id_influencer> <id_campala>`

Asocia un influencer a una campaña mediante sus IDs. 

### `app:list-campaign`

Crea automáticamente 10 influencers de prueba en la base de datos, útiles para testear.