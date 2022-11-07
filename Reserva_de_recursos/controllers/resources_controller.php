<?php

// CONTROLADOR DE LIBROS
include_once("models/resources.php");
include_once("models/time_slots.php");  // Modelos
include_once("view.php");

class Resources_controller
{
    private $db;             // Conexión con la base de datos
    private $resources;  // Modelos

    public function __construct()
    {
        $this->resources = new resources();
        $this->time_slots = new time_slots();
    }

    // --------------------------------- MOSTRAR LISTA DE LIBROS ----------------------------------------
    public function mostrarListaResources()
    {
       if (Seguridad::haySesion()) {
            $data["listaResources"] = $this->resources->getAll();
            View::render("resources/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formularioInsertarResources()
    {
        if (Seguridad::haySesion()) {
            View::render("resources/form");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertarResources()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $name = Seguridad::limpiar($_REQUEST["name"]);
            $description = Seguridad::limpiar($_REQUEST["description"]);
            $location = Seguridad::limpiar($_REQUEST["location"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], "images/".$_FILES["image"]["name"]);
            $result = $this->resources->insert($name, $description, $location, $_FILES["image"]["name"]);
            $data["info"] = "Recurso insertado con éxito";
            

        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
        $data["listaResources"] = $this->resources->getAll();
        View::render("resources/all", $data);
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function borrarResources()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el id del recurso que hay que borrar
            $id = Seguridad::limpiar($_REQUEST["id"]);
            // Pedimos al modelo que intente borrar el recurso
            $result = $this->resources->delete($id);
            // Comprobamos si el borrado ha tenido éxito
            if ($result == 0) {
                $data["error"] = "Ha ocurrido un error al borrar el recurso. Por favor, inténtelo de nuevo";
            } else {
                $data["info"] = "Recurso borrado con éxito";
            }
            $data["listaResources"] = $this->resources->getAll();
            View::render("resources/all", $data);
        } else {
            
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function formularioModificarResources()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos los datos del libro a modificar
            $data["resources"] = $this->resources->get(Seguridad::limpiar($_REQUEST["id"]));
            View::render("resources/form", $data);
            // Renderizamos la vista de inserción de libros, pero enviándole los datos del libro recuperado.
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modificarResources()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Seguridad::limpiar($_REQUEST["id"]);
            $name = Seguridad::limpiar($_REQUEST["name"]);
            $description = Seguridad::limpiar($_REQUEST["description"]);
            $location = Seguridad::limpiar($_REQUEST["location"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], "images/".$_FILES["image"]["name"]);

            // Pedimos al modelo que haga el update
            $result = $this->resources->update($id, $name, $description, $location, $_FILES["image"]["name"]);
            if ($result == 1) {
                $data["info"] = "Recurso actualizado con éxito";
            } else {
                // Si la modificación del libro ha fallado, mostramos mensaje de error
                $data["error"] = "Ha ocurrido un error al modificar el Recurso. Por favor, inténtelo más tarde";
            }
            $data["listaResources"] = $this->resources->getAll();
            header("Location:index.php?action=mostrarListaResources&controller=resources_controller");
            View::render("resources/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }


    // --------------------------------- Recuperar datos reservas ----------------------------------------

    public function reservas(){
        if (Seguridad::haySesion()) {
            $data["listatime_slots"] = $this->time_slots->getAll();
            $data["resource"] = $this->resources->get(Seguridad::limpiar($_REQUEST["id"]));
            View::render("resources/reservations", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }
    


    // --------------------------------- BUSCAR LIBROS ----------------------------------------

    
    public function buscarResources()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el texto de búsqueda de la variable de formulario
            $textoBusqueda = Seguridad::limpiar($_REQUEST["textoBusqueda"]);
            // Buscamos los libros que coinciden con la búsqueda
            $data["listaResources"] = $this->resources->search($textoBusqueda);
            $data["info"] = "Resultados de la búsqueda: <i>$textoBusqueda</i>";
            // Mostramos el resultado en la misma vista que la lista completa de libros
            View::render("resources/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }
}