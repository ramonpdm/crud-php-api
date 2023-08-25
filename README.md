# crud-php-api

PHP 8.2.4 MySQL CRUD (Create, Read, Update, Delete) RESTful API.

## PHP CRUD API
* `GET -    http://localhost/api/contacts`          Obtener todos los contactos.
* `GET -    http://localhost/api/contacts/phones`   Obtener todos los contactos y todos los teléfonos de cada contacto.
* `GET -    http://localhost/api/contacts/2`        Obtener el contacto con ID 2.
* `POST -   http://localhost/api/contacts`          Ingresar un nuevo contacto.
* `PUT -    http://localhost/api/contacts/2`        Actualizar el contacto con ID 2.
* `DELETE - http://localhost/api/contacts/2`        Eliminar el contacto con ID 2.
------------------------------------------
* `GET -    http://localhost/api/phones`            Obtener todos los teléfonos.
* `GET -    http://localhost/api/phones/contacts`   Obtener todos los teléfonos y la información del contacto al que pertenece cada teléfono
* `GET -    http://localhost/api/phones/2`          Obtener el teléfono con ID 2.
* `POST -   http://localhost/api/phones`            Ingresar un nuevo teléfono.
* `PUT -    http://localhost/api/phones/2`          Actualizar el teléfono con ID 2.
* `DELETE - http://localhost/api/phones/2`          Eliminar el teléfono con ID 2.