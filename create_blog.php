<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$password = "";
$baseDeDatos = "blog_db";

$conexion = new mysqli($host, $usuario, $password, $baseDeDatos);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Comprobar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    // Validar datos (opcional, pero recomendado)
    if (!empty($title) && !empty($category_id) && !empty($description)) {
        // Preparar la consulta SQL para evitar inyecciones
        $sql = "INSERT INTO blogs (title, category_id, description, created_at, updated_at) 
                VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sis", $title, $category_id, $description);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Blog creado con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al crear el blog: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Blog</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <?php include("menu.php"); ?>
    <div class="container mt-5">
        <h1>Crear un nuevo blog</h1>
        <form action="create_blog.php" method="POST">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = $conexion->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No hay categorías disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Crear Blog</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Volver al inicio</a>
    </div>

    <!-- Script JS-->
    <script src="script.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>