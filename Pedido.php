<?php
class Pedido {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $sql = "SELECT p.id, p.fecha, p.total, c.nombre AS cliente
                FROM pedidos p
                INNER JOIN clientes c ON p.id_cliente = c.id
                ORDER BY p.id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener($id) {
        $sql = "SELECT p.id, p.fecha, p.total, c.nombre AS cliente
                FROM pedidos p
                INNER JOIN clientes c ON p.id_cliente = c.id
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function detalle($id_pedido) {
        $sql = "SELECT pr.nombre, d.cantidad, d.precio, (d.cantidad * d.precio) AS subtotal
                FROM detalle_pedido d
                INNER JOIN productos pr ON d.id_producto = pr.id
                WHERE d.id_pedido = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_pedido]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($id_cliente, $cantidades) {
        $id_cliente = (int)$id_cliente;
        if (!is_array($cantidades)) {
            return false;
        }

        // Blindaje: Validar existencia del cliente, si no existe asigna el primer ID válido de la tabla
        $stmtCli = $this->db->prepare("SELECT id FROM clientes WHERE id = ?");
        $stmtCli->execute([$id_cliente]);
        if (!$stmtCli->fetch()) {
            $stmtAlt = $this->db->query("SELECT id FROM clientes ORDER BY id ASC LIMIT 1");
            $alt = $stmtAlt->fetch(PDO::FETCH_ASSOC);
            if ($alt) {
                $id_cliente = $alt['id'];
            } else {
                return false; 
            }
        }

        $this->db->beginTransaction();
        try {
            $sql = "INSERT INTO pedidos (id_cliente, total) VALUES (?, 0)";
            $this->db->prepare($sql)->execute([$id_cliente]);
            $id_pedido = $this->db->lastInsertId();

            $buscar = $this->db->prepare("SELECT precio FROM productos WHERE id = ?");
            $insertar = $this->db->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");

            $total = 0;
            foreach ($cantidades as $id_producto => $cantidad) {
                $cantidad = (int) $cantidad;
                if ($cantidad <= 0) continue;

                $buscar->execute([$id_producto]);
                $precio = $buscar->fetchColumn();
                if ($precio === false) continue;

                $insertar->execute([$id_pedido, $id_producto, $cantidad, $precio]);
                $total += ($precio * $cantidad);
            }

            if ($total <= 0) {
                $this->db->rollBack();
                return false;
            }

            $sqlU = "UPDATE pedidos SET total = ? WHERE id = ?";
            $this->db->prepare($sqlU)->execute([round($total, 2), $id_pedido]);

            $this->db->commit();
            return $id_pedido;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function eliminar($id) {
        $sql = "DELETE FROM pedidos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }
}
