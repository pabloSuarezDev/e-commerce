<?php if(isset($edit) && isset($prod) && is_object($prod)): ?>
<h1>Editar producto <?=$prod->nombre?></h1>
<?php $url_action = BASE_URL."producto/save&id=".$prod->id; ?>
<?php else: ?>
<h1>Crear nuevo producto</h1>
<?php $url_action = BASE_URL."producto/save"; ?>
<?php endif;?>
<div style="display: flex; flex-direction: column; align-items: center;">
  <?php $categorias = Utils::showCategorias(); ?>
  <form class="form_container" action="<?=$url_action?>" method="post" enctype="multipart/form-data">
    <label for="pname">Nombre</label>
    <input type="text" name="pname" value="<?=isset($prod) && is_object($prod) ? $prod->nombre: ''?>" style="padding: .5rem;" required />
    <label for="desc">Descripción</label>
    <textarea name="desc" cols="15" rows="2" style="padding: .5rem;">
      <?=isset($prod) && is_object($prod) ? $prod->descripcion: ''?>
    </textarea>
    <label for="price">Precio</label>
    <input type="number" name="price" value="<?=isset($prod) && is_object($prod) ? $prod->precio: ''?>" style="padding: .5rem;" required />
    <label for="stock">Stock</label>
    <input type="number" name="stock" value="<?=isset($prod) && is_object($prod) ? $prod->stock: ''?>" style="padding: .5rem;" required />
    <!-- <label for="offer">Oferta</label>
    <input type="text" name="offer" style="padding: .5rem;" /> -->
    <label for="category">Categoría</label>
    <select name="category" style="width: 25%; padding: .5rem; font-size: 1rem;">
    <?php while($categoria = $categorias->fetch_object()): ?>
      <option value="<?=$categoria->id?>" <?=isset($prod) && is_object($prod) && $categoria->id == $prod->categoria_id ? 'selected' : ''?> style="font-size: 1rem;"><?=$categoria->nombre;?></option>
    <?php endwhile; ?>
    </select>
    <label for="image">Imagen del producto</label>
    <?php if(isset($prod) && is_object($prod) && !empty($prod->imagen)): ?>
      <img class="thumb" src="<?=BASE_URL?>uploads/images/<?=$prod->imagen?>" alt="<?=$prod->nombre?>" />
      <br />
    <?php endif; ?>
    <input type="file" name="image" style="padding: .5rem;" required />
    <input type="submit" value="Guardar" style="padding: .5rem;" />
  </form>
</div>