<?php if(isset($gestion)): ?>
<h1>Gestionar pedidos</h1>
<?php else: ?>
<h1>Mis pedidos</h1>
<?php endif; ?>
<table>
  <tr>
    <th style="padding: .5rem;">Nº Pedido</th>
    <th style="padding: .5rem;">Coste</th>
    <th style="padding: .5rem;">Fecha</th>
    <th style="padding: .5rem;">Estado</th>
  </tr>
  <?php while($pedido = $pedidos->fetch_object()): ?>
  <tr>  
    <td style="padding: .5rem;">
      <a href="<?=BASE_URL?>pedido/detalle&id=<?=$pedido->id?>" style="text-decoration: none;">
        <?=$pedido->id?>
      </a>
    </td> 
    <td><?=$pedido->coste?>$</td> 
    <td><?=$pedido->fecha?></td> 
    <td><?=$pedido->estado?></td>
  </tr>
  <?php endwhile; ?>
</table>