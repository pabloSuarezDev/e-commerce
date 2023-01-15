<?php if(isset($categoria)): ?>
  <h1><?=$categoria->nombre?></h1>
<?php if($productos->num_rows == 0): ?>
  <h3 style="text-align: center;">No hay productos para mostrar</h3>
<?php else: ?>
  <?=Utils::listAllProducts($productos)?>
<?php endif; ?>
<?php else :?>
  <h1>La categoria no existe</h1>
<?php endif;?>