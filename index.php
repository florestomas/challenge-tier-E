<?php include 'connect.php'; ?>

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

    <?php include 'menu.php'; ?>

    <style>
        img {
            width: 200px;
            height: 200px;
        }
    </style>
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
                    echo "      <img class='card-img-top' alt='{$row['name']}' src='{$row['category']}' />";
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