<?php

// CONTROLADOR DE LIBROS
include_once("models/users.php");  // Modelos
include_once("view.php");

class users_controller
{
    private $db;             // Conexión con la base de datos
    private $users;  // Modelos

    public function __construct()
    {
        $this->users = new users();
    }

    // --------------------------------- MOSTRAR LISTA DE LIBROS ----------------------------------------
    public function mostrarListaUsers()
    {
       if (Seguridad::haySesion()) {
            $data["listaUsers"] = $this->users->getAll();
            View::render("users/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO ALTA DE LIBROS ----------------------------------------

    public function formularioInsertarUsers()
    {
        if (Seguridad::haySesion()) {
            View::render("users/form");
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- INSERTAR LIBROS ----------------------------------------

    public function insertarUsers()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $username = Seguridad::limpiar($_REQUEST["username"]);
            $password = Seguridad::limpiar($_REQUEST["password"]);
            $realname = Seguridad::limpiar($_REQUEST["realname"]);
            $type = Seguridad::limpiar($_REQUEST["type"]);

            $result = $this->users->insert($username, $password, $realname, $type);
            $data["info"] = "Usuario insertado con éxito";
            

        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
        $data["listaUsers"] = $this->users->getAll();
        View::render("users/all", $data);
    }

    // --------------------------------- BORRAR LIBROS ----------------------------------------

    public function borrarUsers()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el id del recurso que hay que borrar
            $id = Seguridad::limpiar($_REQUEST["id"]);
            // Pedimos al modelo que intente borrar el recurso
            $result = $this->users->delete($id);
            // Comprobamos si el borrado ha tenido éxito
            if ($result == 0) {
                $data["error"] = "Ha ocurrido un error al borrar el usuario. Por favor, inténtelo de nuevo";
            } else {
                $data["info"] = "Usuario borrado con éxito";
            }
            $data["listaUsers"] = $this->users->getAll();
            View::render("users/all", $data);
        } else {
            
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- FORMULARIO MODIFICAR LIBROS ----------------------------------------

    public function formularioModificarUsers()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos los datos del libro a modificar
            $data["users"] = $this->users->get(Seguridad::limpiar($_REQUEST["id"]));
            View::render("users/form", $data);
            // Renderizamos la vista de inserción de libros, pero enviándole los datos del libro recuperado.
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- MODIFICAR LIBROS ----------------------------------------

    public function modificarUsers()
    {
        if (Seguridad::haySesion()) {
            // Primero, recuperamos todos los datos del formulario
            $id = Seguridad::limpiar($_REQUEST["id"]);
            $username = Seguridad::limpiar($_REQUEST["username"]);
            $password = Seguridad::limpiar($_REQUEST["password"]);
            $realname = Seguridad::limpiar($_REQUEST["realname"]);
            $type = Seguridad::limpiar($_REQUEST["type"]);

            // Pedimos al modelo que haga el update
            $result = $this->users->update($id, $username, $password, $realname, $type);
            if ($result == 1) {
                $data["info"] = "Usuario actualizado con éxito";
            } else {
                // Si la modificación del libro ha fallado, mostramos mensaje de error
                $data["error"] = "Ha ocurrido un error al modificar el usuario. Por favor, inténtelo más tarde";
            }
            $data["listaUsers"] = $this->users->getAll();
            View::render("users/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    // --------------------------------- BUSCAR LIBROS ----------------------------------------

    
    public function buscarUsers()
    {
        if (Seguridad::haySesion()) {
            // Recuperamos el texto de búsqueda de la variable de formulario
            $textoBusqueda = Seguridad::limpiar($_REQUEST["textoBusqueda"]);
            // Buscamos los libros que coinciden con la búsqueda
            $data["listaUsers"] = $this->users->search($textoBusqueda);
            $data["info"] = "Resultados de la búsqueda: <i>$textoBusqueda</i>";
            // Mostramos el resultado en la misma vista que la lista completa de libros
            View::render("users/all", $data);
        } else {
            $data["error"] = "No tienes permiso para eso";
            View::render2("users/login", $data);
        }
    }

    
    // --------------------------------- REUTILIZAMOS EL CONTROLADOR PARA EL LOGIN ----------------------------------------


    public function formLogin() {
        View::render2("users/login");
    }

    // Comprueba los datos de login. Si son correctos, el modelo iniciará la sesión y
    // desde aquí se redirige a otra vista. Si no, nos devuelve al formulario de login.
    public function procesarFormLogin() {
        $username = Seguridad::limpiar($_REQUEST["username"]);
        $password = Seguridad::limpiar($_REQUEST["password"]);
        $result = $this->users->login($username, $password);
        if ($result) { 
            header("Location: index.php?controller=resources_controller&action=mostrarListaResources");
        } else {
            $data["error"] = "Usuario o contraseña incorrectos";
            View::render2("users/login", $data);
        }
    }

    // Cierra la sesión y nos lleva a la vista de login
    public function cerrarSesion() {
        Seguridad::cerrarSesion();
        $data["info"] = "Sesión cerrada con éxito";
        View::render2("users/login", $data);
    }

}