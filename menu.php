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