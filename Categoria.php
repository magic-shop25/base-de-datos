<?php
class Categoria {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM categorias ORDER BY id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM categorias WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion) {
        $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $descripcion]);
    }

    public function actualizar($id, $nombre, $descripcion) {
        $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }
}
