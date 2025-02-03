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

// Obtener el ID de la categoría desde la URL
if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']); // Convertir a entero por seguridad

    // Consultar información de la categoría
    $sqlCategory = "SELECT * FROM categories WHERE id = ?";
    $stmtCategory = $conexion->prepare($sqlCategory);
    $stmtCategory->bind_param("i", $categoryId);
    $stmtCategory->execute();
    $resultCategory = $stmtCategory->get_result();

    if ($resultCategory->num_rows > 0) {
        $category = $resultCategory->fetch_assoc();
    } else {
        die("Categoría no encontrada.");
    }
    $stmtCategory->close();

    // Consultar los blogs relacionados con la categoría
    $sqlBlogs = "SELECT * FROM blogs WHERE category_id = ? ORDER BY updated_at DESC";
    $stmtBlogs = $conexion->prepare($sqlBlogs);
    $stmtBlogs->bind_param("i", $categoryId);
    $stmtBlogs->execute();
    $resultBlogs = $stmtBlogs->get_result();
} else {
    die("ID de categoría no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoría: <?php echo htmlspecialchars($category['name']); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<style>
        img {
            width: 600px;
            height: 600px;
        }
    </style>
    <div class="container mt-5">
        <h1>Categoría: <?php echo htmlspecialchars($category['name']); ?></h1>
        <img src="<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="img-fluid mb-4">
        <hr>

        <div class="row">
            <?php
            if ($resultBlogs->num_rows > 0) {
                while ($blog = $resultBlogs->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-3'>";
                    echo "  <div class='card'>";
                    echo "      <div class='card-body'>";
                    echo "          <h5 class='card-title'>{$blog['title']}</h5>";
                    echo "          <p class='card-text'>" . substr($blog['description'], 0, 100) . "...</p>";
                    echo "          <p class='text-muted'><small>Última actualización: {$blog['updated_at']}</small></p>";
                    echo "          <a href='view_blog.php?id={$blog['id']}' class='btn btn-primary'>Leer más</a>";
                    echo "      </div>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-muted'>No hay blogs en esta categoría.</p>";
            }
            ?>
        </div>

        <a href="index.php" class="btn btn-secondary mt-4">Volver al inicio</a>
    </div>
</body>

</html>