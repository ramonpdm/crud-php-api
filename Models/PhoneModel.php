<?php

class PhoneModel extends DB
{
    private $db_table = "phones";

    public $id;
    public $id_contact;
    public $phone;
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
     * Devuelve un solo registro por su ID.
     * 
     * @return array     
     */
    public function findAllByContact($id_contact)
    {
        return $this->select("SELECT id, phone FROM $this->db_table WHERE id_contact = :id_contact", [[":id_contact", htmlspecialchars(strip_tags($id_contact))]]);
    }

    /** 
     * Inserta un registro.
     * 
     * @return PDOStatement
     */
    public function insert()
    {
        // Evitar XSS
        $this->id_contact = htmlspecialchars(strip_tags($this->id_contact));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        $bindings = [
            [":id_contact", $this->id_contact],
            [":phone", $this->phone],
        ];

        return $this->sql_exec("INSERT INTO $this->db_table SET id_contact = :id_contact, phone = :phone", $bindings);
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
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        $bindings = [
            [":id", $this->id],
            [":phone", $this->phone],
        ];

        return $this->sql_exec("UPDATE $this->db_table SET phone = :phone WHERE id = :id", $bindings);
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
