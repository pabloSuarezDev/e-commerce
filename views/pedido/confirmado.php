<?php Utils::isIdentify(); ?>
<?php if(isset($_SESSION['pedido']) && $_SESSION['pedido'] == "completed"): ?>
<h1>Pedido realizado exitosamente</h1>
<p>
  <strong class="alert_green">
    Tu pedido ha sido confirmado, una vez que realices la transferencia
    bancaria a la cuenta 7382947289239ADD con el coste del pedido será precesado y enviado.
  </strong>
</p>
<br />
<?php Utils::productsDetails($pedido, $productos); ?>
<?php endif; ?>