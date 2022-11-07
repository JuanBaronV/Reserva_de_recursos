<?php
// VISTA PARA INSERCIÓN/EDICIÓN DE LIBROS
if($data != null){
   extract($data); 
}
// Extrae el contenido de $data y lo convierte en variables individuales ($libro, $todosLosAutores y $autoresLibro)


// Vamos a usar la misma vista para insertar y modificar. Para saber si hacemos una cosa u otra,
// usaremos la variable $libro: si existe, es porque estamos modificando un libro. Si no, estamos insertando uno nuevo.
if (isset($users)) {   
    echo "<h1>Modificación de Usuarios</h1>";
} else {
    echo "<h1>Inserción de Usuarios</h1>";
}
// Sacamos los datos del libro (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay libro, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $users[0]->id ?? ""; 
$username = $users[0]->username ?? "";
$password = $users[0]->password ?? "";
$realname = $users[0]->realname ?? "";
$type = $users[0]->type ?? "";

// Creamos el formulario con los campos del libro
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='id' value='".$id."'>
        Nombre de usuario:<input type='text' name='username' value='".$username."'><br>
        contraseña:<input type='text' name='password' value='".$password."'><br>
        nombre real:<input type='text' name='realname' value='".$realname."'><br>
        Seleccione un tipo de usuario<select name='type'>
        <option value='0' selected>Admin</option>
        <option value='1'>usuario</option>
        </select><br>
        <input type='hidden' name='controller' value='users_controller'>";
        

echo "</select>";


// Finalizamos el formulario
if (isset($users)) {
    echo "  <input type='hidden'  name='action' value='modificarUsers'>";
} else {
    echo "  <input type='hidden' name='action' value='insertarUsers'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";

