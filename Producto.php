<?php
class Producto {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $sql = "SELECT p.*, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN categorias c ON p.id_categoria = c.id 
                ORDER BY p.id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $tamano, $precio, $id_categoria) {
        $sql = "INSERT INTO productos (nombre, tamano, precio, id_categoria) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $tamano, $precio, $id_categoria]);
    }

    public function actualizar($id, $nombre, $tamano, $precio, $id_categoria) {
        $sql = "UPDATE productos SET nombre = ?, tamano = ?, precio = ?, id_categoria = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $tamano, $precio, $id_categoria, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }
}
