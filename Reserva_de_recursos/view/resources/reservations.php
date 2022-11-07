<?php

if($data != null){
    extract($data); 
 }
 
echo "<h1>Reserva de recursos</h1>";

//recursos
$id = $resource[0]->id ?? ""; 
$name = $resource[0]->name ?? "";
$description = $resource[0]->description ?? "";
$location = $resource[0]->location ?? "";
$image = $resource[0]->image ?? "";



echo "El recurso que está siendo reservado es: <br> <br>";
echo "$name <br>";
echo " Anotaciones: $description <br>";
echo " Localización: $location <br>";
echo "<img src='images/$image' width='100px'>";
echo "<br> <br> <br>";


echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='id' value='".$id."'>
        Fecha de la reserva:<input type='date' name='fecha' ><br>
        Tramo horario: <select name='timeslot'>";
        foreach ($listatime_slots as $fila) {
            echo "<option value='$fila->id'>".  $fila->dayOfWeek ." - ". $fila->startTime . " - " . $fila->endTime. "</option>";
        }

echo "</select>";
echo "</form>";

// Finalizamos el formulario
if (isset($users)) {
    echo "  <input type='hidden'  name='action' value=''>";
} else {
    echo "  <input type='hidden' name='action' value=''>";
}
echo "	<input type='submit'></form>";
echo "<p><a href='index.php'>Volver</a></p>";