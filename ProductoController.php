<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Categoria.php';

class ProductoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Producto();
    }

    // Listar todos los productos (frutas encremadas)
    public function listar() {
        $productos = $this->modelo->listar();
        require __DIR__ . '/../views/productos/listar.php';
    }

    // Mostrar formulario para un nuevo producto
    public function nuevo() {
        $cat = new Categoria();
        $categorias = $cat->listar();
        $producto = null;
        require __DIR__ . '/../views/productos/form.php';
    }

    // Guardar el nuevo producto en la base de datos
    public function guardar() {
        $this->modelo->crear(
            trim($_POST['nombre']),
            trim($_POST['tamano']),
            $_POST['precio'],
            $_POST['id_categoria']
        );
        header('Location: index.php?c=producto&a=listar&msg=ok');
        exit;
    }

    // Mostrar formulario de edición con los datos actuales
    public function editar() {
        $producto = $this->modelo->obtener($_GET['id']);
        $cat = new Categoria();
        $categorias = $cat->listar();
        require __DIR__ . '/../views/productos/form.php';
    }

    // Actualizar el producto modificado
    public function actualizar() {
        $this->modelo->actualizar(
            $_POST['id'],
            trim($_POST['nombre']),
            trim($_POST['tamano']),
            $_POST['precio'],
            $_POST['id_categoria']
        );
        header('Location: index.php?c=producto&a=listar&msg=ok');
        exit;
    }

    // Eliminar producto con control de errores si está en uso
    public function eliminar() {
        try {
            $this->modelo->eliminar($_POST['id']);
            $msg = 'ok';
        } catch (PDOException $e) {
            $msg = 'error_fk';
        }
        header('Location: index.php?c=producto&a=listar&msg=' . $msg);
        exit;
    }
}
