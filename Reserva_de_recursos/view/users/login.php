<h1>Control de acceso</h1>

<style type="text/css">
    .form {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }
</style>

<?php


if (isset($data["error"])) {
    echo "<div style='color: red'>".$data["error"]."</div>";
}
if (isset($data["info"])) {
    echo "<div style='color: blue'>".$data["info"]."</div>";
}
?>

<form action="index.php" method="post">
    Username:&nbsp<input type='text' name='username'><br/>
    Password: &nbsp<input type='password' name='password'><br/>
    <input type='hidden' name='action' value='procesarFormLogin'>
    <input type='hidden' name='controller' value='users_controller'>
    <button type='submit'>Enviar</button>
</form>