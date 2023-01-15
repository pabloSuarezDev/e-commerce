<h1>Registarse</h1>
<?php if(isset($_SESSION['register']) && $_SESSION['register'] == "completed"): ?>
  <strong class="alert_green">Registro completado correctamente</strong>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == "failed"): ?>
  <strong class="alert_red">Registro fallido, introduce bien los datos</strong>
<?php endif;?>
<?php Utils::deleteSession('register'); ?>
<form action="<?=BASE_URL?>usuario/save" method="post">
  <label for="fname">Nombre:</label>
  <input type="text" name="fname" autocomplete="off" required />
  <label for="surnames">Apellidos:</label>
  <input type="text" name="surnames" autocomplete="off" required />
  <label for="email">Email:</label>
  <input type="email" name="email" autocomplete="off" required />
  <label for="password">Contraseña:</label>
  <input type="password" name="password" autocomplete="off" required />
  <input type="submit" value="Registrarse" />
</form>