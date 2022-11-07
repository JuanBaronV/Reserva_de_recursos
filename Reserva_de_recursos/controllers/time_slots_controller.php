<?php

// CONTROLADOR DE LIBROS
include_once("models/time_slots.php");  // Modelos
include_once("view.php");

class time_slots_controller
{
    private $db;             // Conexión con la base de datos
    private $time_slots;  // Modelos

    public function __construct()
    {
        $this->time_slots = new time_slots();
    }

    // --------------------------------- MOSTRAR LISTA DE LIBROS ----------------------------------------
    public function mostrarTime_slots()
    {
       if (Seguridad::haySesion()) {
            $data["listatime_slots"] = $this->time_slots->getAll();
            View::render("time_slots/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formularioInsertarTime_slots()
    {
        if (Seguridad::haySesion()) {
            View::render("time_slots/form");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertarTime_slots()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario

            $dayOfWeek = Seguridad::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Seguridad::limpiar($_REQUEST["startTime"]);
            $endTime = Seguridad::limpiar($_REQUEST["endTime"]);

            $result = $this->time_slots->insert($dayOfWeek, $startTime, $endTime);
            $data["info"] = "Tabla de tiempos insertado con éxito";
            

        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
        $data["listatime_slots"] = $this->time_slots->getAll();
        View::render("time_slots/all", $data);
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function borrarTime_slots()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el id del recurso que hay que borrar
            $id = Seguridad::limpiar($_REQUEST["id"]);
            // Pedimos al modelo que intente borrar el recurso
            $result = $this->time_slots->delete($id);
            // Comprobamos si el borrado ha tenido éxito
            if ($result == 0) {
                $data["error"] = "Ha ocurrido un error al borrar la tabla de tiempos Por favor, inténtelo de nuevo";
            } else {
                $data["info"] = "Recurso borrado con éxito";
            }
            $data["listatime_slots"] = $this->time_slots->getAll();
            View::render("time_slots/all", $data);
        } else {
            
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function formularioModificarTime_slots()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos los datos del libro a modificar
            $data["time_slots"] = $this->time_slots->get(Seguridad::limpiar($_REQUEST["id"]));
            View::render("time_slots/form", $data);
            // Renderizamos la vista de inserción de libros, pero enviándole los datos del libro recuperado.
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modificarTime_slots()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Seguridad::limpiar($_REQUEST["id"]);
            $dayOfWeek = Seguridad::limpiar($_REQUEST["dayOfWeek"]);
            $startTime = Seguridad::limpiar($_REQUEST["startTime"]);
            $endTime = Seguridad::limpiar($_REQUEST["endTime"]);

            // Pedimos al modelo que haga el update
            $result = $this->time_slots->update($id, $dayOfWeek, $startTime, $endTime);
            if ($result == 1) {
                $data["info"] = "Tabla de tiempos actualizado con éxito";
            } else {
                // Si la modificación del libro ha fallado, mostramos mensaje de error
                $data["error"] = "Ha ocurrido un error al modificar la tabla de tiempos. Por favor, inténtelo más tarde";
            }
            $data["listatime_slots"] = $this->time_slots->getAll();
            header("Location:index.php?action=mostrarTime_slots&controller=time_slots_controller");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- BUSCAR LIBROS ----------------------------------------

    
    
    public function buscarTime_slots()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el texto de búsqueda de la variable de formulario
            $textoBusqueda = Seguridad::limpiar($_REQUEST["textoBusqueda"]);
            // Buscamos los libros que coinciden con la búsqueda
            $data["listatime_slots"] = $this->time_slots->search($textoBusqueda);
            $data["info"] = "Resultados de la búsqueda: <i>$textoBusqueda</i>";
            // Mostramos el resultado en la misma vista que la lista completa de libros
            View::render("time_slots/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }
}