<h1>Gestionar categorías</h1>
<a class="button button-small" href="<?=BASE_URL?>categoria/crear">Crear categoría</a>
<table style="border: 3px solid black;">
  <tr>
    <th>ID</th>
    <th>Nombre</th>
  </tr>
  <?php while($categoria = $categorias->fetch_object()): ?>
  <tr>
    <td><?=$categoria->id;?></td>
    <td><?=$categoria->nombre;?></td>
  </tr>
  <?php endwhile; ?>
</table>