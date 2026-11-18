<?php require __DIR__ . '/layout/cabecera.php'; ?>

<h1>Sistema Integral 'Frutas Encremadas' 🍓</h1>

<div class="tarjetas">
  <div class="tarjeta">
    <span class="numero"><?php echo $resumen['cantidad']; ?></span>
    Pedidos Registrados
  </div>
  <div class="tarjeta">
    <span class="numero">
      Bs <?php echo number_format($resumen['vendido'], 2); ?>
    </span>
    Total Vendido
  </div>
</div>

<h2>Módulos del Sistema</h2>
<div class="tarjetas">
  <a class="tarjeta" href="index.php?c=pedido&a=nuevo">Registrar Pedido</a>
  <a class="tarjeta" href="index.php?c=pedido&a=listar">Ver Pedidos</a>
  <a class="tarjeta" href="index.php?c=producto&a=listar">Productos</a>
  <a class="tarjeta" href="index.php?c=categoria&a=listar">Categorías</a>
  <a class="tarjeta" href="index.php?c=cliente&a=listar">Clientes</a>
</div>

<?php require __DIR__ . '/layout/pie.php'; ?>
