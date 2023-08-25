<?php

class ContactModel extends DB
{
    private $db_table = "contacts";

    public $id;
    public $name;
    public $last_name;
    public $email;
    public $created_at;
    public $updated_at;

    /** 
     * Devuelve todos los registros.
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->select("SELECT * FROM $this->db_table");
    }

    /** 
     * Devuelve un solo registro por su ID.
     * 
     * @return array     
     */
    public function find($id)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE id = :id LIMIT 0, 1", [[":id", htmlspecialchars(strip_tags($id))]]);
    }

    /** 
     * Inserta un registro.
     * 
     * @return PDOStatement
     */
    public function insert()
    {
        // Evitar XSS
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $bindings = [
            [":name", $this->name],
            [":last_name", $this->last_name],
            [":email", $this->email],
        ];

        return $this->sql_exec("INSERT INTO $this->db_table SET name = :name, last_name = :last_name, email = :email", $bindings);
    }

    /** 
     * Actualiza un registro por su ID.
     * 
     * @return PDOStatement
     */
    public function update()
    {
        // Evitar XSS
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $bindings = [
            [":id", $this->id],
            [":name", $this->name],
            [":last_name", $this->last_name],
            [":email", $this->email],
        ];

        return $this->sql_exec("UPDATE $this->db_table SET name = :name, last_name = :last_name, email = :email WHERE id = :id", $bindings);
    }

    /** 
     * Elimina un registro por su ID.
     * 
     * @return PDOStatement
     */
    public function delete($id)
    {
        return $this->sql_exec("DELETE FROM $this->db_table WHERE id = :id", [[":id", htmlspecialchars(strip_tags($id))]]);
    }
}