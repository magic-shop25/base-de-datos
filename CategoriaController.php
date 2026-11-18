<?php
require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Categoria();
    }

    public function listar() {
        $categorias = $this->modelo->listar();
        require __DIR__ . '/../views/categorias/listar.php';
    }

    public function nuevo() {
        $categoria = null;
        require __DIR__ . '/../views/categorias/form.php';
    }

    public function guardar() {
        $this->modelo->crear(trim($_POST['nombre']), trim($_POST['descripcion']));
        header('Location: index.php?c=categoria&a=listar&msg=ok');
        exit;
    }

    public function editar() {
        $categoria = $this->modelo->obtener($_GET['id']);
        require __DIR__ . '/../views/categorias/form.php';
    }

    public function actualizar() {
        $this->modelo->actualizar($_POST['id'], trim($_POST['nombre']), trim($_POST['descripcion']));
        header('Location: index.php?c=categoria&a=listar&msg=ok');
        exit;
    }

    public function eliminar() {
        try {
            $this->modelo->eliminar($_POST['id']);
            $msg = 'ok';
        } catch (PDOException $e) {
            $msg = 'error_fk';
        }
        header('Location: index.php?c=categoria&a=listar&msg=' . $msg);
        exit;
    }
}
