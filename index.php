<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta del restaurante</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<?php
// Importación del archivo XML, igual que en el ejemplo de la cartelera
if (file_exists('./datos/carta.xml')){
    $menu = simplexml_load_file('./datos/carta.xml');
} else {
    exit('Error abriendo el archivo de datos de la carta. Revisa la ruta bro.');
}
?>

<div class="container mt-4">
    <h1>Carta del restaurante</h1>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 rounded">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-utensils"></i> Todo el menú</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
          <?php
          $aux = []; 

          // Recorremos el XML para sacar las categorías sin repetirlas
          foreach($menu->plato as $plato){
            $tipoPlato = (string)$plato['tipo']; 

            if(!in_array($tipoPlato, $aux)){
              echo '<li class="nav-item">';
              
              if(isset($_GET['tipo']) && $_GET['tipo'] == $tipoPlato){
                  echo '<a class="nav-link active" href="?tipo='.$tipoPlato.'">'.$tipoPlato.'</a>';
              } else {
                  echo '<a class="nav-link" href="?tipo='.$tipoPlato.'">'.$tipoPlato.'</a>';
              }
              echo '</li>';
              array_push($aux, $tipoPlato);
            }
          }
          ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="table-responsive tabla-menu">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Plato</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Kcal</th>
                    <th>Características</th>
                </tr>
            </thead>
            <tbody>
              
                <?php
                  /* El mismo bucle optimizado de la profe Alexandra */
                  foreach($menu->plato as $plato){
                    
                    // Comprobamos el filtro por GET
                    if(!isset($_GET['tipo']) || $_GET['tipo'] == (string)$plato['tipo']){
                        echo '<tr>';
                        echo '<td><strong>' . $plato->nombre . '</strong></td>';
                        echo '<td>' . $plato->precio . ' €</td>';
                        echo '<td>' . $plato->descripcion . '</td>';
                        echo '<td>' . $plato->calorias . '</td>';
                        
                        // Iconos de FontAwesome según las etiquetas <item>
                        echo '<td>';
                        foreach($plato->caracteristicas->item as $caracteristica) {
                            $caractStr = (string)$caracteristica;
                            
                            if ($caractStr == 'Picante') echo '<i class="fa-solid fa-pepper-hot icono-caracteristica" title="Picante"></i> ';
                            if ($caractStr == 'Vegano' || $caractStr == 'Vegetariano') echo '<i class="fa-solid fa-leaf icono-caracteristica" title="Vegano/Vegetariano"></i> ';
                            if ($caractStr == 'Sin gluten') echo '<i class="fa-solid fa-wheat-awn-slash icono-caracteristica" title="Sin gluten"></i> ';
                            if ($caractStr == 'Lácteo') echo '<i class="fa-solid fa-cheese icono-caracteristica" title="Contiene lácteos"></i> ';
                            if ($caractStr == 'Carne') echo '<i class="fa-solid fa-drumstick-bite icono-caracteristica" title="Contiene carne"></i> ';
                            if ($caractStr == 'Pescado') echo '<i class="fa-solid fa-fish icono-caracteristica" title="Contiene pescado"></i> ';
                            if ($caractStr == 'Alcohol') echo '<i class="fa-solid fa-wine-glass icono-caracteristica" title="Contiene alcohol"></i> ';
                        }
                        echo '</td>';
                        
                        echo '</tr>';
                    }
                  }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>