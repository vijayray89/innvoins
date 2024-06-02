<?php
include '../config/database.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            echo json_encode($result);
            $stmt->close();
        } else {
            $result = $conn->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC);
            echo json_encode($result);
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $data['name'], $data['description'], $data['price']);
        $stmt->execute();
        echo json_encode(["id" => $conn->insert_id]);
        $stmt->close();
        break;

    case 'PUT':
        $id = intval($_GET['id']);
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $data['name'], $data['description'], $data['price'], $id);
        $stmt->execute();
        echo json_encode(["status" => "success"]);
        $stmt->close();
        break;

    case 'DELETE':
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(["status" => "success"]);
        $stmt->close();
        break;

    default:
        echo json_encode(["status" => "invalid request"]);
        break;
}
?>
