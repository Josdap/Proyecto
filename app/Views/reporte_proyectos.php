<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Proyectos</title>
    

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2{

            text-align:right;
        }

        .logo {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
        }

          .logo-text {
            text-align: left;
            margin-top: 5px;
            font-size: 16px;        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 15px;
            text-align: left;
        }

        .date-time {
            text-align: right;
            margin-bottom: 20px;
            font-size: 18px;
        }

      .footer {
            text-align: right;
            position: relative;
            bottom: 0; 
            width: 100%; 
            padding: 20px; 
           
        }
    </style>
</head>

<body>
    <div class="logo">
       <img src="<?php echo base_url('resources/img/logo.png'); ?>">
       <div class="logo-text">Grupo D'ealy SRL</div>
        <h2>Fecha : <?php echo date('d/m/Y'); ?> | Hora : <?php echo date('H:i:s'); ?></h2>

    </div>
    <h1>Reporte de Proyectos</h1>

 <table id="table">
    <tr>
        <th >N°</th>
        <th style="width: 18%;">Proyecto</th>
        <th style ="width: 18%;">Cliente</th>
        <th style ="width: 20%;">Fecha Inicio</th>
        <th style ="width: 20%;">Fecha Fin</th>
        <th>Duración</th>
        <th>Presupuesto</th>
        <th>Porcentaje </th>
        <th style ="width: 20%;">Estado</th>


    </tr>
    <?php
     $contador = 1;
         foreach ($proyectos as $proyecto) : ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?= $proyecto['nombrep']; ?></td>
                            <td><?= $proyecto['clientes']; ?></td>
                            <td>
                                <?php if (!empty($proyecto['Fechi'])) {
                                    echo date('d/m/Y', strtotime($proyecto['Fechi']));
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if (!empty($proyecto['Fechf'])) {
                                    echo date('d/m/Y', strtotime($proyecto['Fechf']));
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>

                               <td><?= isset($proyecto['duracion']) ? $proyecto['duracion'] . ' días' : ''; ?></td>

                               <td><?= 'S/.' . $proyecto['presupuesto']; ?></td>
                                <td><?= isset($proyecto['porcentaje']) ? $proyecto['porcentaje'] . '%' : '0%';?></td>

                            <td class="estado-label <?php echo getEstadoClass($proyecto['estado']); ?>"><?php echo $proyecto['estado']; ?></td>

                        
                        </tr>
                    <?php endforeach; ?>

</table>
<br>
<div class="footer">
    <p>GRUPO Dealy SRL</p>
    <p>Dirección: A.H 28 de julio F16, Talara</p>
    <p>Teléfono: +51 969 395 007</p>
</div>


<?php
function getEstadoClass($estado) {
    switch ($estado) {
        case 'No iniciado':
            return 'estado-no-iniciado';
        case 'Completado':
            return 'estado-completado';
        case 'Iniciado':
            return 'estado-iniciado';
        default:
            return 'estado-desconocido';
    }
}
?>


</body>

</html>
