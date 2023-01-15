<?php Utils::isIdentify(); ?>
<h1>Hacer pedido</h1>
<form action="<?=BASE_URL?>pedido/add" method="post">
  <h3>Dirección de envío</h3>
  <label for="provincia">Provincia</label>
  <input type="text" name="provincia" required />
  <label for="localidad">Ciudad</label>
  <input type="text" name="localidad" required />
  <label for="direccion">Dirección</label>
  <input type="text" name="direccion" required />
  <input type="submit" value="Confirmar pedido" />
</form>
<br />
<a class="button button-small" href="<?=BASE_URL?>carrito/index">Volver al carrito</a>