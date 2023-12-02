<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/img/logo.png">
    <link rel="stylesheet" href="resources/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="resources/css/proyecto.css">
    <link rel="stylesheet" type="text/css" href="resources/css/estado.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="resources/js/cerrar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Grupo D'ealy - Proyectos</title>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="dropdown ms-auto">
                <button class="btn dropdown-toggle" type="button" id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="profile-image" class="img-profile rounded-circle" src="resources/img/logo.png" alt="" style="width: 40px; height: 40px;">
                    Administrador
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">
                    <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="fntcerrar()"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
                </ul>
            </div>
            <div class="sidebar">
                <div class="logo">
                    <img src="resources/img/GrupoealySRL.png" alt="Logo de la empresa">
                </div>
                <a href="<?php echo base_url();?>/DashboardController" ><i class="fas fa-home"></i> Inicio</a>
                <a href="<?php echo base_url();?>/Proyectos"class="active"><i class="fas fa-cogs"></i> Proyectos</a>
                <a href="<?php echo base_url();?>/Personal"><i class="fas fa-users"></i> Personal</a>
                 <a href="<?php echo base_url();?>/Clientes"><i class="fas fa-user-friends"></i> Clientes</a>
                <a href="<?php echo base_url();?>/Recursos"><i class="fas fa-briefcase"></i> Recursos</a>
                <a href="<?php echo base_url();?>/Asignaciones"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
                 <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>
            </div>
        </div>
    </nav>
<br> <br>
                 <div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Registro de Proyectos</h2>
            <div>
                <div>
                    <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Registrar Proyecto</button>
                
                    <div class="reporte-btn-container">
                    <a href="<?php echo base_url();?>/Proyectos/generarPDF" class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="# " class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>

               
                </div>
                <div>      
                </div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
<table id="table">
    <tr>
        <th hidden>ID</th>
        <th>Proyecto</th>
        <th style ="width: 18%;">Cliente</th>
        <th style ="width: 20%;">Fecha Inicio</th>
        <th style ="width: 20%;">Fecha Fin</th>
        <th>Duración</th>
        <th>Presupuesto</th>
        <th>Porcentaje</th>
        <th>Estado</th>
        <th>Acción</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>

        <?php foreach ($proyectos as $proyecto) : ?>
                        <tr>
                            <td hidden><?= $proyecto['idProyectos']; ?></td>
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
                             <td><?= isset($proyecto['porcentaje']) ? $proyecto['porcentaje'] . '%' : '0%';?><a class="btn-porcentanje" data-id="<?php echo $proyecto['idProyectos']; ?>"><i class="fas fa-pencil-alt"></i></a></td>

                 
                            <td class="estado-label <?php echo getEstadoClass($proyecto['estado']); ?>"><?php echo $proyecto['estado']; ?></td>


                            <td> <?php if ($proyecto['estado'] === 'No iniciado'): ?><a href="<?= base_url('/Proyectos/CambiarEstado/' . $proyecto['idProyectos'] . '/Iniciado'); ?>" class="btn-cambiar-estado" data-id="<?= $proyecto['idProyectos']; ?>">Iniciar</a>
                            <?php elseif ($proyecto['estado'] === 'Iniciado'): ?><a href="<?= base_url('/Proyectos/CambiarEstado/' . $proyecto['idProyectos'] . '/Completado'); ?>" class="btn-cambiar-estado" data-id="<?= $proyecto['idProyectos']; ?>">Completar</a>
                            <?php endif; ?>
                        </td>
                        <td><a class="btn-editar" data-id="<?php echo $proyecto['idProyectos']; ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a class="btn-eliminar" data-id="<?php echo $proyecto['idProyectos']; ?>"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?>

</table>

            </div>
        </div>
    </div>
</div>
<?php if (session()->has('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?= session('success') ?>',
        });
    </script>
<?php elseif (session()->has('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= session('error') ?>',
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        document.getElementById("registrar-btn").addEventListener("click", function () {
            
            Swal.fire({
                title: "Registrar Proyecto",
                html:`
                        <br>
                    <form id="proyecto-form" method="post" action="<?= base_url('/Proyectos/Registrar') ?>">
                    <input id="nombrep" name="nombrep" class="form-control" placeholder="Proyecto">
                    <br>
                    <select id="clientep" name="clientep" class="form-control" required>
                    <option value="">Seleccione un Cliente</option>
                    <?php 
                       $sortedCliente = array();
                       foreach($clientes as $cliente) {
                          $sortedCliente[$cliente->Nombre] = $cliente;
                       }
                       ksort($sortedCliente);
                       foreach($sortedCliente as $cliente) {
                    ?>
                    <option value="<?php echo $cliente->idClientes; ?>"><?php echo $cliente->Nombre; ?></option>
                    <?php 
                       }
                    ?>
                    </select>
                    <br>
                    <input id="presupuesto" type="text" name="presupuesto" class="form-control" placeholder="Presupuesto">

                    </form>`,
                showCancelButton: false,
                confirmButtonText: "Registrar",
preConfirm: () => {
                const nombrep = Swal.getPopup().querySelector('#nombrep').value;
                const clientep = Swal.getPopup().querySelector('#clientep').value;
                const presupuesto = Swal.getPopup().querySelector('#presupuesto').value;
                if (!nombrep|| !clientep || !presupuesto) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('proyecto-form').submit();
            }
        });
    });
        });

const editButtons = document.getElementsByClassName('btn-editar');

for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const proyectoID = this.getAttribute('data-id');
        const estado = this.parentNode.parentNode.querySelector('.estado-label').textContent;

           if (estado === 'Completado') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'No se puede editar un proyecto completado.',
                });
                return;
            }

        const nombrep = this.parentNode.parentNode.children[1].textContent;
        const clientep = this.parentNode.parentNode.children[2].textContent;
        const presupuesto = this.parentNode.parentNode.children[6].textContent;

        const clientesOptions = <?php echo json_encode($clientes); ?>;
        const clientesSelectOptions = clientesOptions.map(function (clientesOptions) {
            const selected = (clientesOptions.Nombre === nombrep) ? 'selected' : '';
            return `<option value="${clientesOptions.idClientes}" ${selected}>${clientesOptions.Nombre}</option>`;
        });

        const htmlContent = `
            <br>
            <form id="edit-proyecto-form" method="post" action="<?= base_url('/Proyectos/editar/') ?>/${proyectoID}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="edit-nombrep">Proyecto</label>
                    <br><br>
                    <input type="text" class="form-control" id="edit-nombrep" name="nombrep" required value="${nombrep}" ${estado === 'Iniciado' ? 'readonly' : ''}>
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-clientep">Cliente</label>
                    <br><br>
                    <select id="edit-clientep" class="form-control" name="clientep" required ${estado === 'Iniciado' ? 'disabled' : '' }>
                        ${clientesSelectOptions.join('')}
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-presupuesto">Presupuesto</label>
                    <br><br>
                    <input type="text" class="form-control" id="edit-presupuesto" name="presupuesto" required value="${presupuesto.replace('S/.', '')}">
                </div>
            </form>`;

        let swalConfig = {
            title: 'Editar Proyectos',
            html: htmlContent,
            showCancelButton: false,
            confirmButtonText: 'Actualizar',
            confirmButtonColor: 'darkblue',
            preConfirm: () => {
                const nombrep = Swal.getPopup().querySelector('#edit-nombrep').value;
                const clientep = Swal.getPopup().querySelector('#edit-clientep').value;
                const presupuesto = Swal.getPopup().querySelector('#edit-presupuesto').value;

                if (estado === 'Iniciado' && !presupuesto) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }

                if (estado == 'No iniciado' && (!nombrep || !clientep || !presupuesto)) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }

                Swal.close();
                document.getElementById('edit-proyecto-form').submit();
            }
        };

        Swal.fire(swalConfig);
    });
}


const porcentajeButtons = document.getElementsByClassName('btn-porcentanje');
for (let i = 0; i < porcentajeButtons.length; i++) {
    porcentajeButtons[i].addEventListener('click', function () {
        const proyectoID = this.getAttribute('data-id');
        const estado = this.parentNode.parentNode.querySelector('.estado-label').textContent;


        if (estado === 'Iniciado') {
            const porcentaje = this.parentNode.parentNode.children[7].textContent;
            Swal.fire({
                title: 'Editar Porcentaje',
                html: `
                    <form id="porcentaje-form" method="post" action="<?= base_url('/Proyectos/actualizarPorcentaje/') ?>/${proyectoID}" enctype="multipart/form-data">
                        <input type="number" class="swal2-input" id="edit-porcentaje" name="porcentaje" required value="${porcentaje.replace('%', '')}">
                    </form>`,
                showCancelButton: false,
                confirmButtonText: 'Actualizar',
                confirmButtonColor:'darkblue',
                preConfirm: () => {
                    const porcentaje = Swal.getPopup().querySelector('#edit-porcentaje').value;
                    if (!porcentaje) {
                        Swal.showValidationMessage('Por favor, completa todos los campos');
                        return false;
                    }
                    Swal.close();
                    document.getElementById('porcentaje-form').submit();
                }
            });
        } else {
            Swal.fire({
                title: 'No permitido',
                text: 'Solo puedes editar el porcentaje cuando el proyecto está en estado "Iniciado".',
                icon: 'warning',
                confirmButtonColor: 'darkblue'
            });
        }
    });
}

</script>




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


            <script type="text/javascript" src="resources/js/buscar.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>