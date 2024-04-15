# Sistema de Gestión de Restaurante

## Requisitos Previos

Antes de comenzar, asegúrate de cumplir con los siguientes requisitos:
- PHP instalado y configurado en el PATH del sistema.
- Driver PDO para PostgreSQL habilitado en tu configuración de PHP.

### Verificar PHP y el Driver PDO

#Ejecuta los siguientes comandos para verificar que PHP y el driver PDO para PostgreSQL están correctamente instalados:

php -v

php -m | findstr pdo_pgsql

## Instalación
Sigue estos pasos para instalar y ejecutar el proyecto:

Descarga el código fuente del proyecto.

Descomprime el archivo ZIP en la carpeta de tu elección.

Navega a la carpeta del proyecto usando la terminal o línea de comandos.

Ejecuta el servidor integrado de PHP:

php -S localhost:5000

Asegurate de cambiar los datos de tu base de datos de PostgreSQL en el archivo de database.php
