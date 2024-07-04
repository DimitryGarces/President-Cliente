<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../includes/db.php');

    // Get the 'folio' from POST data
    $folio = $_POST['folio'];
    
    // Ensure folio is provided
    if (!$folio) {
        echo json_encode(array('success' => false, 'message' => 'Folio no proporcionado'));
        exit;
    }

    $fechaActual = date('Y-m-d');
    $sql = "UPDATE Situacion SET Fecha_Finalizacion = ? WHERE Folio = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('si', $fechaActual, $folio);

    if ($stmt->execute()) {
        $resultado = array('success' => true, 'message' => 'Actualización exitosa');
    } else {
        $resultado = array('success' => false, 'message' => 'Error en la actualización');
    }

    $stmt->close();
    $con->close();

    header('Content-Type: application/json');
    echo json_encode($resultado);
} else {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'message' => 'No se recibieron datos POST'));
}
?>
