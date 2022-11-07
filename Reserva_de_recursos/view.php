<?php

// PLANTILLA DE LAS VISTAS

class View {
    public static function render($nombreVista, $data = null) {
        include("view/header.php");
        include("view/nav.php");
        include("view/$nombreVista.php");
        include("view/footer.php");
    }

    public static function render2($nombreVista, $data = null) {
        include("view/$nombreVista.php");
    }
}