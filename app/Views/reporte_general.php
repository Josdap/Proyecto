<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General</title>
    

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
            font-size: 16px;
        }

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
       <img src="<?php echo base_url('resources/img/logo.png'); ?>" alt="" width="400">
       <div class="logo-text">Grupo D'ealy SRL</div>
        <h2>Fecha : <?php echo date('d/m/Y'); ?> | Hora : <?php echo date('H:i:s'); ?></h2>
    </div>
    <h1>Reporte General</h1>

<table id="table">
    <tr>
        <th>N°</th>
        <th>Proyecto</th>
        <th>Empleado</th>
        <th>Recurso</th>
        <th>Cantidad</th>
        <th>Fecha</th>
    </tr>
<?php
        $contador = 1;
 foreach ($combinedData as $asignacion) : ?>
        <tr>
            <td><?php echo $contador++; ?></td>
            <td><?php echo $asignacion['proyecto']; ?></td>
            <td>
                <?php if (isset($asignacion['empleado'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['empleado'] as $empleado) : ?>
                            <li><?php echo $empleado; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['recurso'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['recurso'] as $recurso) : ?>
                            <li><?php echo $recurso; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['Cantidad'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['Cantidad'] as $cantidad) : ?>
                            <li><?php echo $cantidad; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['Fecha'])) : ?>
                    <?php $fechaActual = '';
                    foreach ($asignacion['Fecha'] as $fecha) :
                        if ($fecha !== $fechaActual) : ?>
                            <?php echo $fecha; ?>
                            <?php $fechaActual = $fecha; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
        </tr>

<?php endforeach; ?>
</table>
<br>
<div class="footer">
    <p>GRUPO Dealy SRL</p>
    <p>Dirección: A.H 28 de julio F16, Talara</p>
    <p>Teléfono: +51 969 395 007</p>
</div>
</body>

</html>
