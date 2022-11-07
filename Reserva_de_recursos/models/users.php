<?php

// MODELO DE LIBROS

include_once "models.php";

class users extends Model
{

    // Constructor. Especifica el nombre de la tabla de la base de datos
    public function __construct()
    {
        $this->table = "Users";
        $this->idColumn = "id";
        parent::__construct();
    }

    // Devuelve el último id asignado en la tabla de libros
    public function getMaxId()
    {
        $result = $this->db->dataQuery("SELECT MAX(id) AS ultimoId FROM Users");
        return $result[0]->ultimoId;
    }


    // Inserta un libro. Devuelve 1 si tiene éxito o 0 si falla.
    public function insert($username, $password, $realname, $type)
    {
        return $this->db->dataManipulation("INSERT INTO Users (username,password,realname,type) VALUES ('$username', '$password', '$realname', '$type')");
    }

    // Actualiza un libro (todo menos sus autores). Devuelve 1 si tiene éxito y 0 en caso de fallo.
    public function update($id, $username, $password, $realname, $type)
    {
        $ok = $this->db->dataManipulation("UPDATE Users SET
                                username = '$username',
                                password = '$password',
                                realname = '$realname',
                                type = '$type'
                                WHERE id = '$id'");
        return $ok;
    }

    // Busca un texto en las tablas de libros y autores. Devuelve un array de objetos con todos los libros
    // que cumplen el criterio de búsqueda.
    public function search($textoBusqueda)
    {
        
        // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda
        $result = $this->db->dataQuery("SELECT * FROM Users
					                    WHERE Users.username LIKE '%$textoBusqueda%'
					                    OR Users.password LIKE '%$textoBusqueda%'
					                    OR Users.realname LIKE '%$textoBusqueda%'
                                        OR Users.type LIKE '%$textoBusqueda%'
					                    ORDER BY Users.username");
        return $result;
    }


    public function login($username, $password) {
    $result = $this->db->dataQuery("SELECT * FROM Users WHERE username='$username' AND password='$password'");
        if (count($result) == 1) {
            Seguridad::iniciarSesion($result[0]->id);
            return true;
        } else {
            return false;
        }
    }

    // Cierra una sesión (destruye variables de sesión)
    public function cerrarSesion() {
        Seguridad::cerrarSesion();
    }
}
?>