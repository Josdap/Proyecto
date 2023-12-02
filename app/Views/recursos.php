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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Grupo D'ealy - Recursos</title>
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
                <a href="<?php echo base_url();?>/Recursos"class="active"><i class="fas fa-briefcase"></i> Recursos</a>
                <a href="<?php echo base_url();?>/Asignaciones"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
                 <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>
            </div>
        </div>
    </nav>

    <br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Registro de Recursos</h2>
            <div>
                
                <div>
                    <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Registrar Recurso</button>
                     
                     <a href="<?php echo base_url();?>/TipoRecursos" id="registrar-tipo-recurso-btn"><i class="fas fa-cogs"></i></a>
          
                </div>
               
                <div class="reporte-btn-container">
                    <a href="<?php echo base_url();?>/Recursos/generarPDF" class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="#" class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>
            </div>
            <div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
                <table id="table">
                    <tr>
                        <th hidden>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Stock</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
             <?php foreach ($recursos as $recurso) : ?>
    <tr>
        <td hidden><?= $recurso['idRecursos']; ?></td>
        <td><?= $recurso['Nombre']; ?></td>
        <td><?= $recurso['tipo']; ?></td>
        <td class="<?php echo getColorClass($recurso['Stock']); ?>"><?= $recurso['Stock']; ?></td>
        <td><a  class="btn-editar" data-id="<?php echo $recurso['idRecursos']; ?>"><i class="fas fa-edit"></i></a></td>
        <td><a class="btn-eliminar" data-id="<?php echo $recurso['idRecursos']; ?>"><i class="fas fa-trash"></i></a></td>
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
                title: "Registrar Recurso",
                html:`
                <br>
                    <form id="recurso-form" method="post" action="<?= base_url('/Recursos/Registrar') ?>">
                    <input id="Nombre" name="Nombre" class="form-control" placeholder="Recurso">
                    <br>
                    <select id="Tipo" name="Tipo" class="form-control" required>
                    <option value="">Seleccione Tipo de Recurso</option>
                    <?php 
                       $sortedTipos = array();
                       foreach($tipos as $tipo) {
                          $sortedTipos[$tipo->Tiporecurso] = $tipo;
                       }
                       ksort($sortedTipos);
                       foreach($sortedTipos as $tipo) {
                    ?>
                    <option value="<?php echo $tipo->idTiporecursos; ?>"><?php echo $tipo->Tiporecurso; ?></option>
                    <?php 
                       }
                    ?>
                    </select>
                    <br>
                    <input id="Stock" type="number" name="Stock" class="form-control" placeholder="Stock">
                    </form>`,
                showCancelButton: false,
                confirmButtonText: "Registrar",
preConfirm: () => {
                const Nombre = Swal.getPopup().querySelector('#Nombre').value;
                const Tiporecurso = Swal.getPopup().querySelector('#Tipo').value;
                const Stock = Swal.getPopup().querySelector('#Stock').value;
                if (!Tipo|| !Nombre || !Stock) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('recurso-form').submit();
            }
        });
    });
        });

    const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const recursosId = this.getAttribute('data-id');
        const Nombre = this.parentNode.parentNode.children[1].textContent;
        const Tipo = this.parentNode.parentNode.children[2].textContent;
        const Stock = this.parentNode.parentNode.children[3].textContent;

        const tiposOptions = <?php echo json_encode($tipos); ?>;

        const tiposSelectOptions = tiposOptions.map(function (tiposOptions) {
            const selected = (tiposOptions.Tiporecurso === Tipo) ? 'selected' : '';
            return `<option value="${tiposOptions.idTiporecursos}" ${selected}>${tiposOptions.Tiporecurso}</option>`;
        });

        Swal.fire({
            title: 'Editar Recurso',
            html: `
            <br>
            <form id="edit-recurso-form" method="post" action="<?= base_url('/Recursos/editar/') ?>/${recursosId}">
                <div class="form-group">
                    <label for="edit-nombre">Recurso</label>
                    <br>
                    <br>
                    <input type="text" class="form-control" id="edit-nombre" name="Nombre" required
                           value="${Nombre}">
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-tipo">Tipo de Recurso</label>
                    <br><br>
                    <select id="edit-tipo" class="form-control" name="Tipo" required>
                        ${tiposSelectOptions.join('')}
                    </select>
                </div>

                <br><br>
                <div class="form-group">
                    <label for="edit-stock">Stock</label>
                    <br>
                    <br>
                    <input type="number" class="form-control" id="edit-stock" name="Stock" required
                           value="${Stock}">
                </div>
            </form>`,
            showCancelButton: false,
               confirmButtonText: 'Actualizar',
                confirmButtonColor:'darkblue',
            preConfirm: () => {
                const Nombre = Swal.getPopup().querySelector('#edit-nombre').value;
                const Tipo = Swal.getPopup().querySelector('#edit-tipo').value;
                const Stock = Swal.getPopup().querySelector('#edit-stock').value;
                if (!Nombre || !Tipo || !Stock) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-recurso-form').submit();
            }
        });
    });
}
const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            const recursosId = this.getAttribute('data-id');
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

                    fetch('<?php echo base_url(); ?>/Recursos/Eliminar/' + recursosId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El recurso se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            'No se puede eliminar el recurso debido a que se encuentra asignado a un proyecto.',
                            'error'
                        );
                    });
                }
            });
        });
    }


</script>

    <?php
function getColorClass($stock) {
    if ($stock > 99) {
        return 'stock-verde';
    } elseif ($stock <= 99 && $stock > 40) {
        return 'stock-amarillo';
    } else {
        return 'stock-rojo';
    }
}
    ?>

        <script type="text/javascript" src="resources/js/buscar.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>