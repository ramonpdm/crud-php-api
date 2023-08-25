<?php

class APIController
{
    private $controller = '';

    /** 
     * Constructor. Identifica cual es exactamente el 
     * controlador al que se está accesando.
     */
    public function __construct()
    {
        // Verificar si existe el parámetro del controlador
        if (isset($_GET['controller'])) {

            // Primera letra mayúscula
            $controller =  ucfirst($_GET['controller']);
            // Convertir de plural a singular
            $controller =  (substr($controller, -1) === 's' ? substr($controller, 0, -1) : $controller) . 'Controller';

            // Establecer el controlador, si existe
            if (class_exists($controller))
                $this->controller = $controller;
        }
    }

    /** 
     * Método mágico __call 
     * 
     * Invocado automáticamente cuando se llama 
     * un método inexistente o inaccesible.
     */
    public function __call($method, $args)
    {
        return $this->sendOutput(404, 404, array('HTTP/1.1 404 Not Found'));
    }

    /** 
     * Inicializa la API.
     * 
     * @return string JSON  
     */
    public function init()
    {
        // Si el controlador no existe, terminar la ejecución
        if (!class_exists($this->controller))
            return $this->sendOutput(404, 404, array('HTTP/1.1 404 Not Found'));

        $controller = new $this->controller();

        try {
            $data = $controller->{$this->method()}();
        } catch (Exception $e) {
            return $this->sendOutput(array('message' => $e->getMessage()), 500);
        }

        return $data;
    }

    /** 
     * Envía la salida de la API. 
     * 
     * @param mixed $data               Los datos que serán devueltos.
     * @param int   $http_response_code El código HTTP de la respuesta.
     * @param array $http_headers       Los encabezados que serán establecidos.
     * 
     * @return string codificado en JSON.
     */
    protected function sendOutput($data, $http_response_code = 200, $http_headers = array())
    {
        // Establecer los headers recibidos
        if (is_array($http_headers) && count($http_headers)) {
            foreach ($http_headers as $httpHeader) {
                header($httpHeader);
            }
        }

        // Evitar retornar JSON y establecer un código
        if ($data === 404)
            return;

        header('Content-Type: application/json; charset=UTF-8');

        if ($http_response_code)
            http_response_code($http_response_code);

        return json_encode($data);
    }

    /** 
     * Obtener el método exacto que ejecutara
     * el controlador, según la solicitud
     * HTTP y los parámetros pasados. 
     * 
     * @return string   El método identificado, o
     *                  'findAll' por default.
     */
    protected function method()
    {
        $request_method = strtoupper($_SERVER["REQUEST_METHOD"]);

        switch ($request_method) {
            case 'POST':
                return 'insert';
            case 'PUT':
                return 'update';
            case 'DELETE':
                if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']))
                    return 'delete';
            case 'GET':
                if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']))
                    return 'find';
            default:
                return 'findAll';
        }
    }

    /** 
     * Obtiene el contenido en RAW pasado en la 
     * solicitud HTTP, descodifica el JSON y 
     * por referencia, ingresa este array a la
     * variable pasada. Por lo regular $_POST.
     * 
     * @return array 
     */
    protected function php_input(&$var)
    {
        return $var = (array) json_decode(file_get_contents("php://input"), TRUE);
    }
}
