<?php
// Conectar a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$baseDeDatos = "blog_db";

$conexion = new mysqli($host, $usuario, $password, $baseDeDatos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el ID del blog desde la URL
if (isset($_GET['id'])) {
    $blogId = intval($_GET['id']); // Convertir el ID a entero para mayor seguridad

    // Consultar la información del blog
    $sql = "SELECT blogs.title, blogs.description, blogs.updated_at, categories.name AS category_name, categories.image AS category_image 
            FROM blogs 
            JOIN categories ON blogs.category_id = categories.id 
            WHERE blogs.id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $blogId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        die("Blog no encontrado.");
    }
    $stmt->close();
} else {
    die("ID de blog no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog: <?php echo htmlspecialchars($blog['title']); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <h6 class="text-muted">Categoría: <?php echo htmlspecialchars($blog['category_name']); ?></h6>
        <p><strong>Última actualización:</strong> <?php echo htmlspecialchars($blog['updated_at']); ?></p>
        <hr>
        <p><?php echo nl2br(htmlspecialchars($blog['description'])); ?></p>
        <hr>
        <img src="<?php echo htmlspecialchars($blog['category_image']); ?>" alt="<?php echo htmlspecialchars($blog['category_name']); ?>" class="img-fluid">
        <br><br>
        <a href="category.php?id=<?php echo $blogId; ?>" class="btn btn-primary">Volver a la categoría</a>
        <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
    </div>
</body>

</html>