<?php
class Cliente {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM clientes ORDER BY id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM clientes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $telefono, $email) {
        $sql = "INSERT INTO clientes (nombre, telefono, email) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $telefono, $email]);
    }

    public function actualizar($id, $nombre, $telefono, $email) {
        $sql = "UPDATE clientes SET nombre = ?, telefono = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $telefono, $email, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM clientes WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }
}
