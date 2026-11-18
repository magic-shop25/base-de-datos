
<?php
class Topping {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM toppings_agregados ORDER BY id";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT * FROM toppings_agregados WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $precio_adicional) {
        $sql = "INSERT INTO toppings_agregados (nombre, precio_adicional) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $precio_adicional]);
    }

    public function actualizar($id, $nombre, $precio_adicional) {
        $sql = "UPDATE toppings_agregados SET nombre = ?, precio_adicional = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $precio_adicional, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM toppings_agregados WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    // Método para obtener los toppings que lleva un producto de un pedido
    public function obtenerPorDetalle($id_detalle_pedido) {
        $sql = "SELECT t.nombre, t.precio_adicional 
                FROM detalle_pedido_toppings dt
                INNER JOIN toppings_agregados t ON dt.id_topping = t.id
                WHERE dt.id_detalle_pedido = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_detalle_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
