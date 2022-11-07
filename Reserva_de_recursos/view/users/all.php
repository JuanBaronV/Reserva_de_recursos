<?php
// VISTA PARA LA LISTA DE LIBROS

// Recuperamos la lista de libros
$listaUsers = $data["listaUsers"];

// Si hay algún mensaje de feedback, lo mostramos
if (isset($data["info"])) {
  echo "<div style='color:blue'>".$data["info"]."</div>";
}

if (isset($data["error"])) {
  echo "<div style='color:red'>".$data["error"]."</div>";
}

echo "<form action='index.php'>
        <input type='hidden' name='controller' value='users_controller'>
        <input type='hidden' name='action' value='buscarUsers'>
        <input type='text' name='textoBusqueda'>
        <input type='submit' value='Buscar'>
      </form><br>";


// Ahora, la tabla con los datos de los libros
if (count($listaUsers) == 0) {
  echo "No hay datos";
} else {
  echo "<table border ='1'>";
  foreach ($listaUsers as $fila) {
    echo "<tr>";
    echo "<td>" . $fila->id . "</td>";
    echo "<td>" . $fila->username . "</td>";
    echo "<td>" . $fila->password . "</td>";
    echo "<td>" . $fila->realname . "</td>";
    echo "<td>" . $fila->type . "</td>";
    echo "<td><a href='index.php?controller=users_controller&action=formularioModificarUsers&id=" . $fila->id . "'>Modificar</a></td>";
    echo "<td><a href='index.php?controller=users_controller&action=borrarUsers&id=" . $fila->id . "'>Borrar</a></td>";
    echo "</tr>";
  }
  echo "</table>";
}
echo "<p><a href='index.php?controller=users_controller&action=formularioInsertarUsers'>Nuevo</a></p>";