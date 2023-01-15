<?php

use function PHPSTORM_META\type;

 Utils::isIdentify(); ?>
<h1>Carrito de la compra</h1>
<?php if(isset($_SESSION['carrito'])): ?>
  <table style="border: 3px solid black; padding: .5rem;">
  <tr>
    <th>Imagen</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Unidades</th>
    <th>Eliminar</th>
  </tr>
  <?php foreach ($carrito as $indice => $elemento): 
    $producto = $elemento['producto']; 
  ?>
  <tr>  
    <?php if($producto->imagen != null): ?>
    <td>
      <img class="img_carrito" src="<?=BASE_URL?>uploads/images/<?=$producto->imagen?>" alt="<?=$producto->nombre?>" />
    </td>
    <?php else: ?>
    <td>
      <img class="img_carrito" src="<?=$producto->imagen?>" alt="<?=$producto->nombre?>" />
    </td>
    <?php endif; ?>
    <td>
      <a href="<?=BASE_URL?>producto/ver&id=<?=$producto->id?>">
        <?=$producto->nombre?>
      </a>
    </td> 
    <td><?=$producto->precio?></td> 
    <td>
      <?=$elemento['unidades'];?>
      <div class="updown-unidades">
        <a class="button" href="<?=BASE_URL?>carrito/up&index=<?=$indice?>">+</a>
        <a class="button" href="<?=BASE_URL?>carrito/down&index=<?=$indice?>">-</a>
      </div>
    </td> 
    <td>
      <a class="button button-carrito button-red" href="<?=BASE_URL?>carrito/remove&index=<?=$indice?>">Quitar producto</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<br />
<div style="display: flex; justify-content: space-between;">
  <div>
    <a class="button button-small button-red" href="<?=BASE_URL?>carrito/deleteAll">Vaciar Carrito</a>
  </div>
  <div class="total-carrito">
    <?php $stats = Utils::statsCarrito()?>
    <h3>Precio total: <?=$stats['total']?>$</h3>
    <a class="button button-pedido" href="<?=BASE_URL?>pedido/hacer">Hacer pedido</a>
  </div>
</div>
<?php else: ?>
<div style="text-align: center;">  
  <h3>
    Actualmente el carrito se encuentra vacío.
  </h3>
</div>
<?php endif; ?>