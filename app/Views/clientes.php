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

    <title>Grupo D'ealy - Clientes</title>
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
                 <a href="<?php echo base_url();?>/Clientes"class="active"><i class="fas fa-user-friends"></i> Clientes</a>
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
            <h2>Registro de Clientes</h2>
            <div>
                <div>
                    <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Registrar Cliente</button>
                     


                
                    <div class="reporte-btn-container">
                    <a href="<?php echo base_url();?>/Clientes/generarPDF " class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
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
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                     <?php foreach ($clientes as $cliente) : ?>
                        <tr>
                            <td hidden><?= $cliente['idClientes']; ?></td>
                            <td><?= $cliente['Nombre']; ?></td>
                            <td><?= $cliente['Direccion']; ?></td>
                            <td><?= $cliente['Telefono']; ?></td>
                            <td><?= $cliente['Correo']; ?></td>
                 <td><a class="btn-editar" data-id="<?php echo $cliente['idClientes']; ?>"><i class="fas fa-edit"></i></a></td>
                <td><a class="btn-eliminar" data-id="<?php echo $cliente['idClientes']; ?>"><i class="fas fa-trash"></i></a></td>
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
    document.addEventListener("DOMContentLoaded", function () {
        
        document.getElementById("registrar-btn").addEventListener("click", function () {
            
           Swal.fire({
            title: 'Registrar Cliente',
            html: `
            <br>
                <form id="cliente-form" method="post" action="<?= base_url('/Clientes/Registrar') ?>">
                        <div class="form-group">
                        <label for="Nombre">Nombre</label>
                        <br><br>
                        <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                        <br>
                        <label for="Direccion">Direccion</label>
                        <br><br>
                        <input type="text" class="form-control" id="Direccion" name="Direccion" required>
                        <br>
                        <label for="Telefono">Telefono</label>
                        <br><br>
                        <input type="number" class="form-control" id="Telefono" name="Telefono" required>
                        <br>
                        <label for="Correo">Correo</label>
                        <br><br>
                        <input type="email" class="form-control" id="Correo" name="Correo" required>
                    
                   
                </form>`,
            showCancelButton: false,
            confirmButtonText: 'Registrar',

            preConfirm: () => {
                const Nombre = Swal.getPopup().querySelector('#Nombre').value;
                const Direccion = Swal.getPopup().querySelector('#Direccion').value;
                const Telefono = Swal.getPopup().querySelector('#Telefono').value;
                const Correo = Swal.getPopup().querySelector('#Correo').value;               
                if (!Nombre|| !Direccion || !Telefono || !Correo) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('cliente-form').submit();
            }
        });
    });
        });

const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const clientesId = this.getAttribute('data-id');
        const Nombre = this.parentNode.parentNode.children[1].textContent;
        const Direccion = this.parentNode.parentNode.children[2].textContent;
        const Telefono = this.parentNode.parentNode.children[3].textContent;
        const Correo = this.parentNode.parentNode.children[4].textContent;
        Swal.fire({
            title: 'Editar Cliente',
            html: `
            <br>
            <form id="edit-cliente-form" method="post" action="<?= base_url('/Clientes/editar/') ?>/${clientesId}">
                <div class="form-group">
                    <label for="edit-nombre">Nombre del Cliente</label>
                    <br>
                    <br>
                    <input type="text" class="form-control" id="edit-nombre" name="Nombre" required
                           value="${Nombre}">
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-direccion">Dirección</label>
                    <br><br>
                    <input type="text" class="form-control" id="edit-direccion" name="Direccion" required
                           value="${Direccion}">
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-telefono">Telefono</label>
                    <br><br>
                    <input type="number" class="form-control" id="edit-telefono" name="Telefono" required
                           value="${Telefono}">
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-correo">Correo Electronico</label>
                    <br><br>
                    <input type="email" class="form-control" id="edit-correo" name="Correo" required
                           value="${Correo}">
                </div>
            </form>`,
            showCancelButton: false,
               confirmButtonText: 'Actualizar',
                confirmButtonColor:'darkblue',
            preConfirm: () => {
                const Nombre = Swal.getPopup().querySelector('#edit-nombre').value;
                const Direccion = Swal.getPopup().querySelector('#edit-direccion').value;
                const Telefono = Swal.getPopup().querySelector('#edit-telefono').value;
                const Correo = Swal.getPopup().querySelector('#edit-correo').value;
                if (!Nombre || !Direccion || !Telefono || !Correo) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-cliente-form').submit();
            }
        });
    });
}


      const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            const clientesId = this.getAttribute('data-id');
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

                    fetch('<?php echo base_url(); ?>/Clientes/Eliminar/' + clientesId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El cliente se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el cliente debido a que se encuentra asociado a un proyecto.',
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