<?php
require_once 'Conexion.php';

class Inventario {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function listar() {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function obtener($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function guardar($data) {
        if (empty($data['id'])) {
            $stmt = $this->db->prepare("INSERT INTO productos (nombre, cantidad, unidad, estado, fecha_ingreso, fecha_vencimiento) VALUES (?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $data['nombre'],
                $data['cantidad'],
                $data['unidad'],
                $data['estado'],
                $data['fecha_ingreso'],
                $data['fecha_vencimiento']
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE productos SET nombre=?, cantidad=?, unidad=?, estado=?, fecha_ingreso=?, fecha_vencimiento=? WHERE id=?");
            return $stmt->execute([
                $data['nombre'],
                $data['cantidad'],
                $data['unidad'],
                $data['estado'],
                $data['fecha_ingreso'],
                $data['fecha_vencimiento'],
                $data['id']
            ]);
        }
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
