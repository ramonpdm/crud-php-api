<?php

class PhoneController extends APIController implements iCRUD
{
    /** 
     * Devuelve todos los registros.
     * 
     * @return string Array codificado en JSON.  
     */
    public function findAll()
    {
        $model = new PhoneModel();
        $data = $model->findAll();

        // Validar si devolvió registros
        if (!is_array($data) || empty($data))
            return $this->sendOutput(array('message' => 'No se encontraron registros'), 404);

        // Si fue establecido el parámetro, obtener
        // el contacto de este teléfono
        if (isset($_GET['id']) && $_GET['id'] === 'contacts') {

            // Iterar entre cada teléfono por referencia
            // para poder agregar a $data el contacto
            foreach ($data as &$phone)
                $phone['contact'] = (new ContactModel())->find($phone['id_contact']);
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
        $model = new PhoneModel();
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
        // Transferir los datos en JSON obtenidos
        // de solicitudes Http a la varible POST
        $this->php_input($_POST);

        // Validar que se hayan decodificado los datos
        if (empty($_POST)) {
            return $this->sendOutput(array('message' => 'Los datos suministrados deben estar correctamente codificados en JSON. Favor validar la entrada.'), 400);
        }

        $model = new PhoneModel();
        $contactModel = new ContactModel();

        if (!isset($_POST['id_contact']) || empty($_POST['id_contact'])) {
            return $this->sendOutput(array('message' => 'El ID del contacto al que pertenece el teléfono no puede estar vacío.'), 400);
        }

        $model->id_contact = $_POST['id_contact'];

        // Validar si existe el ID del contacto
        $exist = $contactModel->find($model->id_contact);

        if (!is_array($exist) || empty($exist)) {
            return $this->sendOutput(array('message' => 'El ID del contacto no existe.'), 404);
        }

        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            return $this->sendOutput(array('message' => 'El teléfono no puede estar vacío.'), 400);
        }

        $model->phone = $_POST['phone'];
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

        $model = new PhoneModel();

        // Validar si existe el ID
        $exist = $model->find($id);

        if (!is_array($exist) || empty($exist)) {
            return $this->sendOutput(array('message' => 'El ID del teléfono no existe.'), 404);
        }

        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            return $this->sendOutput(array('message' => 'El teléfono no puede estar vacío.'), 400);
        }

        $model->id = $id;
        $model->phone = $_POST['phone'];
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
        $model = new PhoneModel();
        $model->delete($id);

        return $this->sendOutput('', 200);
    }
}
