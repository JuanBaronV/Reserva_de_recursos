<?php
// VISTA PARA LA LISTA DE LIBROS

// Recuperamos la lista de libros
$listatime_slots = $data["listatime_slots"];

// Si hay algún mensaje de feedback, lo mostramos
if (isset($data["info"])) {
  echo "<div style='color:blue'>".$data["info"]."</div>";
}

if (isset($data["error"])) {
  echo "<div style='color:red'>".$data["error"]."</div>";
}

echo "<form action='index.php'>
        <input type='hidden' name='controller' value='time_slots_controller'>
        <input type='hidden' name='action' value='buscarTime_slots'>
        <input type='text' name='textoBusqueda'>
        <input type='submit' value='Buscar'>
      </form><br>";


// Ahora, la tabla con los datos de los libros
if (count($listatime_slots) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  foreach ($listatime_slots as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->id . "</td>";
    echo "<td>" . $fila->dayOfWeek . "</td>";
    echo "<td>" . $fila->startTime . "</td>";
    echo "<td>" . $fila->endTime . "</td>";
    echo "<td><a href='index.php?controller=time_slots_controller&action=formularioModificarTime_slots&id=" . $fila->id . "'>Modificar</a></td>";
    echo "<td><a href='index.php?controller=time_slots_controller&action=borrarTime_slots&id=" . $fila->id . "'>Borrar</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?controller=time_slots_controller&action=formularioInsertarTime_slots'>Nuevo</a></p>";