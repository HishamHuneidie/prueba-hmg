# Entorno de pruebas

El entorno está construído únicamente con el propósito de mostrar como se puede generar una app que gestione usuarios. Con este entorno se pueden crear, borrar, modificar y listar usuarios. Estos a su vez tienen la posibilidad de iniciar sesión.
Todas las vistas están protegidas con usuario y contraseña.
Creado en Symfony 4.4 y como base de datos se está utilizando la versión 10 de MariaDB.

# Los bundles instalados
  - security-bundle
  - maker-bundle

Nota: se tenía pensado utilizar el FOSUserBundle pero en su lugar se ha utilizado el maker-bundle por recomendación directa de la documentación de symfony y tomando en cuenta que el proyecto FOSUserBundle lleva varios años desatendido.

# Rutas

| Nombre | Ruta | Verbo HTTP |
| ------ | ------ | ------ |
| Dashboard | / | GET |
| Iniciar Sesión | /login | GET |
| Registrar Usuario | /registrar | GET |
| Listar Usuarios | /usuarios | GET |
| Eliminar usuario | /confirma-borrar-usuario/id-usuario | GET |
| Ver Usuario | /ver-usuario/id-usuario | GET |
| Ver Usuario | /user/id-usuario | GET |
| Modificar Usuario | /user/id-usuario | POST |


# Créditos

Hisham Huneidie
hhuneidie@gmail.com 