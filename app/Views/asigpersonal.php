<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/img/logo.png">
    <link rel="stylesheet" href="resources/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="resources/css/registro.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="resources/js/cerrar.js"></script>
    <script defer src="resources/js/validar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Grupo D'ealy - Asignaciones</title>
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
                <a href="<?php echo base_url();?>/Proyectos"><i class="fas fa-cogs"></i> Proyectos</a>
                <a href="<?php echo base_url();?>/Personal"><i class="fas fa-users"></i> Personal</a>
                <a href="<?php echo base_url();?>/Clientes"><i class="fas fa-user-friends"></i> Clientes</a>
                <a href="<?php echo base_url();?>/Recursos"><i class="fas fa-briefcase"></i> Recursos</a>
                <a href="<?php echo base_url();?>/Asignaciones"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
                <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>
            

            </div>
        </div>
    </nav>
    <br>  <br>
      <div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Asignación de Personal</h2>
            <div>
                <div>


        <div>
            <a href="<?php echo base_url();?>/Asignaciones" class="regresar-btn" id="regresar-btn"><i class="fas fa-arrow-left"></i> Regresar</a>
         
                <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Asignar Personal</button>
            
        </div>
               
                </div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
                <table id="table">
                    <tr>
                        <th hidden>ID</th>
                        <th>Proyecto</th>
                        <th>Personal</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>

            <?php foreach ($asigpersonal as $asigpersonal) : ?>
        <tr>
            <td hidden><?= $asigpersonal['idAsignacionper']; ?></td>
            <td><?= $asigpersonal['proyecto']; ?></td>
            <td><?= $asigpersonal['empleado']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($asigpersonal['Fecha'])); ?></td>
            <td><a class="btn-editar" data-id="<?php echo $asigpersonal['idAsignacionper']; ?>"><i class="fas fa-edit"></i></a></td>
            <td><a class="btn-eliminar" data-id="<?php echo $asigpersonal['idAsignacionper']; ?>"><i class="fas fa-trash"></i></a></td>
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
                title: "Asignar Personal",
                html:`
                    <br>
                    <form id="asigpersonal-form" method="post" action="<?= base_url('/AsigPersonal/Registrar') ?>">
                    <select id="Proyectoper" name="Proyectoper" class="form-control" required>
                    <option value="">Seleccione un Proyecto</option>
                    <?php 
                       $sortedproyectos = array();
                       foreach($proyectos as $proyecto) {
                          $sortedproyectos[$proyecto->nombrep] = $proyecto;
                       }
                       ksort($sortedproyectos);
                       foreach($sortedproyectos as $proyecto) {
                    ?>
                    <option value="<?php echo $proyecto->idProyectos; ?>"><?php echo $proyecto->nombrep; ?></option>
                    <?php 
                       }
                    ?>
                    </select>

                    <br>

                    <select id="Empleadoper" name="Empleadoper" class="form-control" required>
                    <option value="">Seleccione un Empleado</option>
                    <?php 
                       $sortedempleado = array();
                       foreach($personal as $empleado) {
                          $sortedempleado[$empleado->Nombre] = $empleado;
                       }
                       ksort($sortedempleado);
                       foreach($sortedempleado as $empleado) {
                    ?>
                    <option value="<?php echo $empleado->idEmpleado; ?>"><?php echo $empleado->Nombre; ?></option>
                    <?php 
                       }
                    ?>
                    </select>
                    </form>`,
                showCancelButton: false,
                confirmButtonText: "Asignar",
preConfirm: () => {
                const Proyectoper = Swal.getPopup().querySelector('#Proyectoper').value;
                const Empleadoper = Swal.getPopup().querySelector('#Empleadoper').value;
                
                if (!Proyectoper|| !Empleadoper) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('asigpersonal-form').submit();
            }
        });
    });
        });

    const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const asigpersonalId = this.getAttribute('data-id');
        const Proyectoper = this.parentNode.parentNode.children[1].textContent;
        const Empleadoper = this.parentNode.parentNode.children[2].textContent;
        const proyectosOptions = <?php echo json_encode($proyectos); ?>;
        const proyecto = proyectosOptions.find(p => p.nombrep === Proyectoper);

        if (proyecto && proyecto.estado === 'Completado') {
            Swal.fire({
                icon: 'error',
                title: 'No se puede editar',
                text: 'El proyecto está completado y no se puede editar.',
                confirmButtonColor: 'darkblue',
            });
            return;
        }

        const proyectosSelectOptions = proyectosOptions.map(function (proyectosOptions) {
            const selected = (proyectosOptions.nombrep === Proyectoper) ? 'selected' : '';
            return `<option value="${proyectosOptions.idProyectos}" ${selected}>${proyectosOptions.nombrep}</option>`;
        });
        const personalOptions = <?php echo json_encode($personal); ?>;

        const personalSelectOptions = personalOptions.map(function (personalOptions) {
            const selected = (personalOptions.Nombre === Empleadoper) ? 'selected' : '';
            return `<option value="${personalOptions.idEmpleado}" ${selected}>${personalOptions.Nombre}</option>`;
        });

        Swal.fire({
            title: 'Editar Asignación de personal',
            html: `
            <br>
            <form id="edit-asigpersonal-form" method="post" action="<?= base_url('/AsigPersonal/editar/') ?>/${asigpersonalId}">
                <div class="form-group">
                    <label for="edit-proyectoper">Proyecto</label>
                    <br><br>
                    <select id="edit-proyectoper" class="form-control" name="Proyectoper" required>
                        ${proyectosSelectOptions.join('')}
                    </select>
                </div>
                <br><br>
                <div class="form-group">
                    <label for="edit-empleadoper">Cargo</label>
                    <br><br>
                    <select id="edit-empleadoper" class="form-control" name="Empleadoper" required>
                        ${personalSelectOptions.join('')}
                    </select>
                </div>
            </form>`,
            showCancelButton: false,
            confirmButtonText: 'Actualizar',
            confirmButtonColor: 'darkblue',
            preConfirm: () => {
                const Proyectoper = Swal.getPopup().querySelector('#edit-proyectoper').value;
                const Empleadoper = Swal.getPopup().querySelector('#edit-empleadoper').value;
                if (!Proyectoper || !Empleadoper) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-asigpersonal-form').submit();
            }
        });
    });
}
const deleteButtons = document.getElementsByClassName('btn-eliminar');
for (let i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function() {
        const asigpersonalId = this.getAttribute('data-id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('<?php echo base_url(); ?>/AsigPersonal/Eliminar/' + asigpersonalId, {
                    method: 'POST'
                }).then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'La asignación de personal se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            data.message || 'Hubo un error al intentar eliminar la asignación de personal.',
                            'error'
                        );
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'No se pudo comunicar con el servidor. Por favor, inténtalo de nuevo.',
                        'error'
                    );
                });
            }
        });
    });
}


</script>
        <script type="text/javascript" src="resources/js/buscar.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>