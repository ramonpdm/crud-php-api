<?php

class DB
{
    protected $conn;

    /** 
     * Constructor. Intenta realizar la conexión
     * a la base de datos.
     * 
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE,  DB_USERNAME, DB_PASSWORD);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * Ejecuta una consulta y retorna un Array
     * asociativo los datos seleccionados.
     * 
     * @param string $query     Consulta SQL.
     * @param array  $params    Párametros a Bindear
     * 
     * @throws Exception
     * @return array
     */
    protected function select($query = "", $params = [])
    {
        try {
            $stmt = $this->sql_exec($query, $params);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /** 
     * Ejecuta una consulta y retorna un objeto 
     * \PDOStatement.
     * 
     * @param string $query     Consulta SQL.
     * @param array  $params    Párametros a Bindear
     * 
     * @throws Exception
     * @return PDOStatement
     */
    protected function sql_exec($query = "", $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            // Si hay parámetros, bindear cada uno de ellos
            if ($params) {
                foreach ($params as $param) {
                    $stmt->bindParam($param[0], $param[1]);
                }
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
