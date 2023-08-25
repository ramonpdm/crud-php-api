<?php

class ContactController extends APIController implements iCRUD
{
    /** 
     * Devuelve todos los registros.
     * 
     * @return string Array codificado en JSON.  
     */
    public function findAll()
    {
        $model = new ContactModel();
        $data = $model->findAll();

        // Validar si devolvió registros
        if (!is_array($data) || empty($data))
            return $this->sendOutput(array('message' => 'No se encontraron registros'), 404);

        // Si fue establecido el parámetro, obtener
        // todos los teléfonos de este contacto
        if (isset($_GET['id']) && $_GET['id'] === 'phones') {

            // Iterar entre cada contacto por referencia
            // para poder agregar a $data los teléfonos
            // de cada contacto
            foreach ($data as &$contact)
                $contact['phones'] = (new PhoneModel())->findAllByContact($contact['id']);
        }

        return $this->sendOutput($data, 200);
    }

    /** 
     * Devuelve un solo registro por su ID.
     * 
     * @return string Array codificado en JSON.  
     */
    public function find()
    {
        $id = $_GET['id'];
        $model = new ContactModel();
        $data = $model->find($id);

        // Validar si devolvió registros
        if (!is_array($data) || empty($data))
            return $this->sendOutput(array('message' => 'No se encontraron registros'), 404);

        return $this->sendOutput($data, 200);
    }

    /** 
     * Inserta un registro.
     * 
     * @return string Array codificado en JSON.  
     */
    public function insert()
    {
        $model = new ContactModel();

        if (!isset($_POST['name']) || empty($_POST['name'])) {
            return $this->sendOutput(array('message' => 'El nombre del contacto no puede estar vacío.'), 400);
        }

        if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
            return $this->sendOutput(array('message' => 'El apellido del contacto no puede estar vacío.'), 400);
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return $this->sendOutput(array('message' => 'El email del contacto no puede estar vacío.'), 400);
        }

        $model->name = $_POST['name'];
        $model->last_name = $_POST['last_name'];
        $model->email = $_POST['email'];
        $model->insert();

        return $this->sendOutput('', 200);
    }

    /** 
     * Actualiza un registro por su ID.
     * 
     * @return string Array codificado en JSON.  
     */
    public function update()
    {
        // Transferir los datos en JSON pasados
        // a través del método PUT a la varible POST
        $this->php_input($_POST);

        // Validar que se hayan decodificado los datos
        if (empty($_POST)) {
            return $this->sendOutput(array('message' => 'Los datos suministrados deben estar correctamente codificados en JSON. Favor validar la entrada.'), 400);
        }

        // Obtener el ID pasado vía PUT y si no existe, obtener el de $_GET
        $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null);

        // Validar que exista un ID
        if (is_null($id)) {
            return $this->sendOutput(array('message' => 'El ID no existe.'), 404);
        }

        $model = new ContactModel();

        // Validar si existe el ID
        $exist = $model->find($id);

        if (!is_array($exist) || empty($exist)) {
            return $this->sendOutput(array('message' => 'El ID del contacto no existe.'), 404);
        }

        if (!isset($_POST['name']) || empty($_POST['name'])) {
            return $this->sendOutput(array('message' => 'El nombre del contacto no puede estar vacío.'), 400);
        }

        if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
            return $this->sendOutput(array('message' => 'El apellido del contacto no puede estar vacío.'), 400);
        }

        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return $this->sendOutput(array('message' => 'El email del contacto no puede estar vacío.'), 400);
        }

        $model->id = $id;
        $model->name = $_POST['name'];
        $model->last_name = $_POST['last_name'];
        $model->email = $_POST['email'];
        $model->update();

        return $this->sendOutput('', 200);
    }

    /** 
     * Elimina un registro por su ID.
     * 
     * @return string Array codificado en JSON.  
     */
    public function delete()
    {
        $id = $_GET['id'];
        $model = new ContactModel();
        $model->delete($id);

        return $this->sendOutput('', 200);
    }
}
