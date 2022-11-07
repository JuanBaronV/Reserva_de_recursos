<?php

// MODELO DE LIBROS

include_once "models.php";

class time_slots extends Model
{

    // Constructor. Especifica el nombre de la tabla de la base de datos
    public function __construct()
    {
        $this->table = "TimeSlots";
        $this->idColumn = "id";
        parent::__construct();
    }

    // Devuelve el último id asignado en la tabla de libros
    public function getMaxId()
    {
        $result = $this->db->dataQuery("SELECT MAX(id) AS ultimoId FROM TimeSlots");
        return $result[0]->ultimoId;
    }


    // Inserta un libro. Devuelve 1 si tiene éxito o 0 si falla.
    public function insert($dayOfWeek, $startTime, $endTime)
    {
        return $this->db->dataManipulation("INSERT INTO TimeSlots (dayOfWeek,startTime,endTime) VALUES ('$dayOfWeek', '$startTime', '$endTime')");
    }

    // Actualiza un libro (todo menos sus autores). Devuelve 1 si tiene éxito y 0 en caso de fallo.
    public function update($id, $dayOfWeek, $startTime, $endTime)
    {
        $ok = $this->db->dataManipulation("UPDATE TimeSlots SET
                                dayOfWeek = '$dayOfWeek',
                                startTime = '$startTime',
                                endTime = '$endTime'
                                WHERE id = '$id'");
        return $ok;
    }

    // Busca un texto en las tablas de libros y autores. Devuelve un array de objetos con todos los libros
    // que cumplen el criterio de búsqueda.
    public function search($textoBusqueda)
    {
        
        // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda
        $result = $this->db->dataQuery("SELECT * FROM TimeSlots
					                    WHERE TimeSlots.dayOfWeek LIKE '%$textoBusqueda%'
					                    OR TimeSlots.startTime LIKE '%$textoBusqueda%'
					                    OR TimeSlots.endTime LIKE '%$textoBusqueda%'
					                    ORDER BY TimeSlots.dayOfWeek");
        return $result;
    }
}
?>