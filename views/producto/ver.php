<?php if(isset($prod)): ?>
  <h1><?=$prod->nombre?></h1>
  <div id="detail-product">
    <div class="image">
    <?php if($prod->imagen != null): ?>
      <img src="<?=BASE_URL?>uploads/images/<?=$prod->imagen?>" alt="<?=$prod->nombre?>"/>
    <?php else: ?>
      <img src="assets/img/camiseta.png" alt="Producto destacado" />
    <?php endif; ?>
    </div>
    <div class="data">  
      <p class="description"><?=$prod->descripcion?></p>
      <p class="price"><?=$prod->precio?></p>
      <a class="button" href="<?=BASE_URL?>carrito/add&id=<?=$prod->id?>">Comprar</a>
    </div>
  </div>
<?php else: ?>
  <h1>El producto no existe</h1>
<?php endif; ?>