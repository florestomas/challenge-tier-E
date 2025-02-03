<?php
// Parámetros de conexión a la base de datos
$host = "localhost"; // Dirección del servidor MySQL (por lo general localhost)
$usuario = "root";   // Usuario (por defecto "root" en MySQL)
$password = "";      // Contraseña (déjala vacía si no tiene)
$baseDeDatos = "blog_db"; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $password, $baseDeDatos);

// Verificar si hubo un error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    /*echo "Conexión exitosa a la base de datos '<b>$baseDeDatos</b>'";*/
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <!-- shrink-to-fit: permite que el contendio de la pagina se achike-->

    <meta name="description" content="Challenge E" />
    <meta name="author" content="Tomas Flores | Dragodev Trainee" />
    <meta charset="UTF-8" />

    <link rel="icon" href="images/dragodevs_logo.jpeg" />

    <title>Challenge Tier E | FLORES Tomas</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <!--  NavBar  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        Categorías
                    </a>
                    <div class="dropdown-menu">
                        <?php
                        $sql = "SELECT * FROM categories";
                        $result = $conexion->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<a class='dropdown-item' href='category.php?id={$row['id']}'>{$row['name']}</a>";
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create_blog.php">Crear Blog</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="py-4">Bienvenido</h1>
        <h2>Blogs recientes</h2>
        <div class="row">
            <?php
            $sql = "SELECT blogs.id, blogs.title, blogs.description, blogs.updated_at, categories.name, categories.image AS category 
                    FROM blogs 
                    JOIN categories ON blogs.category_id = categories.id 
                    ORDER BY blogs.updated_at DESC LIMIT 5";
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "  <div class='card'>";
                    echo "      <img class='card-img-top img-fluid img-thumbnail' alt='{$row['name']}' src='{$row['category']}' />";
                    echo "      <div class='card-body'>";
                    echo "          <h5 class='card-title'>{$row['title']}</h5>";
                    echo "          <h6 class='card-subtitle mb-2 text-muted'>{$row['name']}</h6>";
                    echo "          <p class='card-text'>{$row['description']}</p>";
                    echo "          <a href='view_blog.php?id={$row['id']}' class='btn btn-primary'>Leer más</a>";
                    echo "      </div>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay blogs recientes.</p>";
            }
            ?>
        </div>
    </div>


    <div class="container py-4">
        <h1>Crear un nuevo blog</h1>
        <form action="create_blog_process.php" method="POST">
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="category">Categoría</label>
                <select name="category_id" id="category" class="form-control" required>
                    <?php
                    $sql = "SELECT * FROM categories";
                    $result = $conexion->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Crear Blog</button>
        </form>
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