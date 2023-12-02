<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Clientes</title>
    

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
    <h1>Reporte de Clientes</h1>

 <table id="table">
        <tr>
            <th>N°</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Correo</th>
        </tr>
        <?php
        $contador = 1;
        foreach ($clientes as $cliente) :
        ?>
            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?= $cliente['Nombre']; ?></td>
                <td><?= $cliente['Direccion']; ?></td>
                <td><?= $cliente['Telefono']; ?></td>
                <td><?= $cliente['Correo']; ?></td>
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
