<?php
header('Content-Type: application/json');
$response = ['success' => false, 'error' => ''];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (empty($data['images'])) {
        throw new Exception('No se recibieron imágenes');
    }

    foreach ($data['images'] as $index => $imageData) {
        // Remueve el prefijo del data URL
        $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        
        // Decodifica y guarda
        $decodedData = base64_decode($base64Data);
        $filename = './photos/foto_' . time() . "_$index.jpg";
		$filename = './photos/foto.jpg';
        
        if (!file_put_contents($filename, $decodedData)) {
            throw new Exception("Error guardando $filename");
        }
    }

    $response['success'] = true;
    
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>