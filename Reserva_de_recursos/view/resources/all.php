<?php
// VISTA PARA LA LISTA DE LIBROS

// Recuperamos la lista de libros
$listaResources = $data["listaResources"];

// Si hay algún mensaje de feedback, lo mostramos
if (isset($data["info"])) {
  echo "<div style='color:blue'>".$data["info"]."</div>";
}

if (isset($data["error"])) {
  echo "<div style='color:red'>".$data["error"]."</div>";
}

echo "<form action='index.php'>
        <input type='hidden' name='action' value='buscarResources'>
        <input type='hidden' name='controller' value='resources_controller'>
        <input type='text' name='textoBusqueda'>
        <input type='submit' value='Buscar'>
      </form><br>";


// Ahora, la tabla con los datos de los libros
if (count($listaResources) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  foreach ($listaResources as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->id . "</td>";
    echo "<td>" . $fila->name . "</td>";
    echo "<td>" . $fila->description . "</td>";
    echo "<td>" . $fila->location . "</td>";
    echo "<td><img width='100px' src='images/" . $fila->image . "'></td>";
    echo "<td><a href='index.php?action=formularioModificarResources&controller=resources_controller&id=" . $fila->id . "'>Modificar</a></td>";
    echo "<td><a href='index.php?action=borrarResources&controller=resources_controller&id=" . $fila->id . "'>Borrar</a></td>";
    echo "<td><a href='index.php?action=reservas&controller=resources_controller&id=" . $fila->id . "'>Reservar</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?action=formularioInsertarResources&controller=resources_controller'>Nuevo</a></p>";