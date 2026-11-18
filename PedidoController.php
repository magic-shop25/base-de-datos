<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Producto.php';

class PedidoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Pedido();
    }

    public function listar() {
        $pedidos = $this->modelo->listar();
        require __DIR__ . '/../views/pedidos/listar.php';
    }

    public function nuevo() {
        $cli = new Cliente();
        $clientes = $cli->listar();
        $pro = new Producto();
        $productos = $pro->listar();
        require __DIR__ . '/../views/pedidos/nuevo.php';
    }

    public function guardar() {
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : 0;
        $cantidades = isset($_POST['cantidad']) ? $_POST['cantidad'] : [];

        $id_pedido = $this->modelo->crear($id_cliente, $cantidades);

        if ($id_pedido) {
            header('Location: index.php?c=pedido&a=ver&id=' . $id_pedido);
        } else {
            header('Location: index.php?c=pedido&a=nuevo&msg=error');
        }
        exit;
    }

    public function ver() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pedido = $this->modelo->obtener($id);
        $detalles = $this->modelo->detalle($id);
        require __DIR__ . '/../views/pedidos/ver.php';
    }

    public function eliminar() {
        if (!empty($_POST['id'])) {
            $this->modelo->eliminar($_POST['id']);
        }
        header('Location: index.php?c=pedido&a=listar');
        exit;
    }
}

