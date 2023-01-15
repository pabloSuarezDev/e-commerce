<h1>Gestión de productos</h1>
<a class="button button-small" href="<?=BASE_URL?>producto/crear">Añadir producto</a>
<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == "completed"): ?>
<strong class="alert_green">Inserción completada correctamente</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] == "failed"): ?>
<strong class="alert_red">Inserción fallida, introduce bien los datos</strong>
<?php endif;?>
<?php Utils::deleteSession('producto'); ?>
<?php if(isset($_SESSION['delete']) && $_SESSION['delete'] == "completed"): ?>
<strong class="alert_green">Producto eliminado correctamente</strong>
<?php elseif(isset($_SESSION['delete']) && $_SESSION['delete'] == "failed"): ?>
<strong class="alert_red">Eliminación fallida, introduce bien los datos</strong>
<?php endif;?>
<?php Utils::deleteSession('delete'); ?>
<table style="border: 3px solid black;">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Stock</th>
    <th>Acciones</th>
  </tr>
  <?php while($producto = $productos->fetch_object()): ?>
  <tr>  
    <td><?=$producto->id;?></td>   
    <td><?=$producto->nombre;?></td>   
    <td><?=$producto->stock;?></td>  
    <td>
      <a href="<?=BASE_URL?>producto/editar&id=<?=$producto->id?>" class="button button-gestion button-action">Editar</a>
      <a href="<?=BASE_URL?>producto/eliminar&id=<?=$producto->id?>" class="button button-gestion button-red button-action">Eliminar</a>
    </td>
  </tr>  
  <?php endwhile;?>
</table>