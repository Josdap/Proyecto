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

    <title>Grupo D'ealy - Cargos</title>
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
<br> <br>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Registro de Cargos</h2>
            <div>
                <div>
                    <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Registrar Cargo</button>
               
                </div>
                <div>      
                </div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
                <table id="table">
                    <tr>
                        <th hidden>ID</th>
                        <th>Cargo</th>
                        <th>Descripcion</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>

                      <?php foreach ($roles as $rol) : ?>
        <tr>
            <td hidden><?= $rol['idCargo']; ?></td>
            <td><?= $rol['Cargo']; ?></td>
            <td><?= $rol['descripcion']; ?></td>
            <td><a class="btn-editar" data-id="<?php echo $rol['idCargo']; ?>"><i class="fas fa-edit"></i></a></td>
            <td><a class="btn-eliminar" data-id="<?php echo $rol['idCargo']; ?>"><i class="fas fa-trash"></i></a></td>

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
    <?php endif; ?>

<script>
    $(document).ready(function () {
        $('#registrar-btn').click(function () {
            Swal.fire({
                title: 'Registrar Cargo',
                html: `
                    <form id="cargo-form" method="post" action="<?= base_url('/Cargos/Registrar') ?>">
                        <input type="text" id="Cargo" name="Cargo" class="swal2-input" placeholder="Cargo">
                        <input type="text" id="descripcion" name="descripcion" class="swal2-input" placeholder="Descripción">
                    </form>`,
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                preConfirm: () => {
                    const Cargo = Swal.getPopup().querySelector('#Cargo').value;
                    const descripcion = Swal.getPopup().querySelector('#descripcion').value;

                    if (!Cargo || !descripcion) {
                        Swal.showValidationMessage('Todos los campos son obligatorios');
                        return false;
                }
                Swal.close();
                document.getElementById('cargo-form').submit();
            }
        });
    });
        });

    const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const cargosId = this.getAttribute('data-id');
        const Cargo = this.parentNode.parentNode.children[1].textContent;
        const descripcion = this.parentNode.parentNode.children[2].textContent;
        Swal.fire({
            title: 'Editar Cargo',
            html: `
            <br>
            <form id="edit-cargo-form" method="post" action="<?= base_url('/Cargos/editar/') ?>/${cargosId}">
                <div class="form-group">
                    <label for="edit-cargo">Cargo</label>
                    <br>
                    <br>
                    <input type="text" class="form-control" id="edit-cargo" name="Cargo" required
                           value="${Cargo}">
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-descripcion">Descripcion</label>
                    <br><br>
                    <input type="text" class="form-control" id="edit-descripcion" name="descripcion" required
                           value="${descripcion}">
                </div>
              
            
            </form>`,
            showCancelButton: false,
               confirmButtonText: 'Actualizar',
                confirmButtonColor:'darkblue',
            preConfirm: () => {
                const Cargo = Swal.getPopup().querySelector('#edit-cargo').value;
                const descripcion = Swal.getPopup().querySelector('#edit-descripcion').value;
                if (!Cargo || !descripcion) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-cargo-form').submit();
            }
        });
    });
}


      const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            const cargosId = this.getAttribute('data-id');
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

                    fetch('<?php echo base_url(); ?>/Cargos/Eliminar/' + cargosId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El Cargo se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el cargo debido a que se encuentra asociado a un trabajador.',
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