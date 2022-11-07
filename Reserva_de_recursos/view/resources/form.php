<?php
// VISTA PARA INSERCIÓN/EDICIÓN DE LIBROS
if($data != null){
   extract($data); 
}
// Extrae el contenido de $data y lo convierte en variables individuales ($libro, $todosLosAutores y $autoresLibro)


// Vamos a usar la misma vista para insertar y modificar. Para saber si hacemos una cosa u otra,
// usaremos la variable $libro: si existe, es porque estamos modificando un libro. Si no, estamos insertando uno nuevo.
if (isset($resources)) {   
    echo "<h1>Modificación de recursos</h1>";
} else {
    echo "<h1>Inserción de recursos</h1>";
}
// Sacamos los datos del libro (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay libro, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $resources[0]->id ?? ""; 
$name = $resources[0]->name ?? "";
$description = $resources[0]->description ?? "";
$location = $resources[0]->location ?? "";
$image = $resources[0]->image ?? "";

// Creamos el formulario con los campos del libro
echo "<form action = 'index.php' method = 'post' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='".$id."'>
        Nombre:<input type='text' name='name' value='".$name."'><br>
        Descripción:<input type='text' name='description' value='".$description."'><br>
        Localización:<input type='text' name='location' value='".$location."'><br>
        Imagen:<input type='file' name='image' value='".$image."'><br>";
        

echo "</select>";

// Finalizamos el formulario
if (isset($resources)) {
    echo "  <input type='hidden' name='action' value='modificarResources'>";
    echo "  <input type='hidden' name='controller' value='resources_controller'>";
} else {
    echo "  <input type='hidden' name='action' value='insertarResources'>";
    echo "  <input type='hidden' name='controller' value='resources_controller'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";
