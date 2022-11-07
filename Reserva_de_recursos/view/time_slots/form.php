<?php
// VISTA PARA INSERCIÓN/EDICIÓN DE LIBROS
if($data != null){
   extract($data); 
}
// Extrae el contenido de $data y lo convierte en variables individuales ($libro, $todosLosAutores y $autoresLibro)


// Vamos a usar la misma vista para insertar y modificar. Para saber si hacemos una cosa u otra,
// usaremos la variable $libro: si existe, es porque estamos modificando un libro. Si no, estamos insertando uno nuevo.
if (isset($time_slots)) {   
    echo "<h1>Modificación de Tabla de tiempos</h1>";
} else {
    echo "<h1>Inserción de Tabla de tiempos</h1>";
}
// Sacamos los datos del libro (si existe) a variables individuales para mostrarlo en los inputs del formulario.
// (Si no hay libro, dejamos los campos en blanco y el formulario servirá para inserción).
$id = $time_slots[0]->id ?? ""; 
$dayOfWeek = $time_slots[0]->dayOfWeek ?? "";
$startTime = $time_slots[0]->startTime ?? "";
$endTime = $time_slots[0]->endTime ?? "";

// Creamos el formulario con los campos del libro
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='id' value='".$id."'>
        Día de la semana:<input type='text' name='dayOfWeek' value='".$dayOfWeek."'><br>
        Tiempo de inicio:<input type='text' name='startTime' value='".$startTime."'><br>
        Tiempo de fin:<input type='text' name='endTime' value='".$endTime."'><br>
        <input type='hidden' name='controller' value='time_slots_controller'>";
        

echo "</select>";

// Finalizamos el formulario
if (isset($time_slots)) {
    echo "  <input type='hidden'  name='action' value='modificarTime_slots'>";
    echo "  <input type='hidden' name='controller' value='time_slots_controller'>";
} else {
    echo "  <input type='hidden' name='action' value='insertarTime_slots'>";
    echo "  <input type='hidden' name='controller' value='time_slots_controller'>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";
