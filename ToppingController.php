<?php
require_once __DIR__ . '/../models/Topping.php';

class ToppingController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Topping();
    }

    public function listar() {
        $toppings = $this->modelo->listar();
        require __DIR__ . '/../views/toppings/listar.php';
    }

    public function nuevo() {
        $topping = null;
        require __DIR__ . '/../views/toppings/form.php';
    }

    public function guardar() {
        $this->modelo->crear(trim($_POST['nombre']), $_POST['precio_adicional']);
        header('Location: index.php?c=topping&a=listar&msg=ok');
        exit;
    }

    public function editar() {
        $topping = $this->modelo->obtener($_GET['id']);
        require __DIR__ . '/../views/toppings/form.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST['id'], trim($_POST['nombre']), $_POST['precio_adicional']);
        header('Location: index.php?c=topping&a=listar&msg=ok');
        exit;
    }

    public function eliminar() {
        try {
            $this->modelo->eliminar($_POST['id']);
            $msg = 'ok';
        } catch (PDOException $e) {
            $msg = 'error_fk';
        }
        header('Location: index.php?c=topping&a=listar&msg=' . $msg);
        exit;
    }
}
