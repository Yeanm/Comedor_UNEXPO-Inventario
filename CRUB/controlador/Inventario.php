<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../modelo/Inventario.php';

$inventario = new Inventario();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'listar':
        echo json_encode($inventario->listar());
        break;

    case 'obtener':
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $producto = $inventario->obtener($id);
            echo json_encode($producto ?: new stdClass());
        } else {
            echo json_encode(new stdClass());
        }
        break;

    case 'guardar':
        $data = $_POST;
        $resultado = $inventario->guardar($data);
        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al guardar']);
        }
        break;

    case 'eliminar':
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            $resultado = $inventario->eliminar($id);
            if ($resultado) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al eliminar']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'ID inválido']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción no válida']);
        break;
}
