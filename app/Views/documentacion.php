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

    <title>Grupo D'ealy - Documentación</title>
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
                 <a href="<?php echo base_url();?>/Documentacion"class="active"><i class="fas fa-folder"></i> Documentación</a>

            

            </div>
        </div>
    </nav>

    <br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Modulo de Documentación</h2>
            <div>
                <div>
                    <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i>Registrar Doc</button>
                </div>
                <div class="reporte-btn-container">
                    <a href="#" class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="#" class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>
            </div>
            <div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
                <table id="table">
                <tr>
                    <th hidden>ID</th>
                    <th>Proyecto</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Documento</th>
                    <th>Visualizar</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <?php foreach ($documentos as $documento) : ?>
                    <tr>
                        <td hidden><?= $documento['idDocumentacion']; ?></td>
                        <td><?= $documento['proyecto']; ?></td>
                        <td><?= $documento['Tipodoc']; ?></td>
                        <td><?= date('d/m/Y', strtotime($documento['Fechadoc'])); ?></td>
                        <td><?= $documento['documento']; ?></td>
                    <td>
                        <a href="<?= base_url('public/uploads/documents/' . $documento['documento']); ?>" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </td>

                        <td><a class="btn-editar" data-id="<?= $documento['idDocumentacion']; ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a class="btn-eliminar" data-id="<?= $documento['idDocumentacion']; ?>"><i class="fas fa-trash"></i></a></td>
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
            title: 'Registrar Documentacion',
            html: `
            <br>
            <form id="documento-form" method="post" action="<?= base_url('/Documentacion/Registrar') ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <select id="Proyectodoc" name="Proyectodoc" class="form-control" required>
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
                    <select id="Tipodoc" name="Tipodoc" class="form-control" required>
                        <option value="">Seleccione un Tipo de Documento</option>
                        <option value="Planos">Planos</option>
                        <option value="Informe">Informe</option>
                        <option value="Contrato">Contrato</option>
                    </select>
                    <br> <br>
                    <input type="file" class="form-control" id="documento" name="documento" accept=".pdf" required>
                </div>
            </form>`,
            showCancelButton: false,
            confirmButtonText: 'Registrar',
            preConfirm: () => {
                const Proyectodoc = Swal.getPopup().querySelector('#Proyectodoc').value;
                const Tipodoc = Swal.getPopup().querySelector('#Tipodoc').value;
                const documento = Swal.getPopup().querySelector('#documento').value;
                if (!Proyectodoc || !Tipodoc || !documento) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('documento-form').submit();
            }
        });
    });
});

const editButtons = document.getElementsByClassName('btn-editar');
for (let i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function () {
        const documentacionId = this.getAttribute('data-id');
        const Proyectodoc = this.parentNode.parentNode.children[1].textContent;
        const Tipodoc = this.parentNode.parentNode.children[2].textContent;
        const documento = this.parentNode.parentNode.children[4].textContent;

        const proyectosOptions = <?php echo json_encode($proyectos); ?>;

        const proyectosSelectOptions = proyectosOptions.map(function (proyectosOptions) {
            const selected = (proyectosOptions.nombrep === Proyectodoc) ? 'selected' : '';
            return `<option value="${proyectosOptions.idProyectos}" ${selected}>${proyectosOptions.nombrep}</option>`;
        });

   const opcionesTipoDocumento = ["", "Planos", "Informe", "Contrato"];

const tipoDocumentoSelectOptions = opcionesTipoDocumento.map(function (opcion) {
    const selected = (opcion === Tipodoc) ? 'selected' : '';
    return `<option value="${opcion}" ${selected}>${opcion === "" ? "Seleccione un Tipo de Documento" : opcion}</option>`;
});

        Swal.fire({
            title: 'Editar Documentacion',
            html: `
            <br>
            <form id="edit-personal-form" method="post" action="<?= base_url('/Documentacion/editar/') ?>/${documentacionId}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="edit-proyectos">Proyectos</label>
                    <br><br>
                    <select id="edit-proyectos" class="form-control" name="Proyectodoc" required>
                        ${proyectosSelectOptions.join('')}
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-tipodoc">Tipo</label>
                    <br>
                    <br>
                    <select id="edit-tipodoc" class="form-control" name="Tipodoc" required>
                        ${tipoDocumentoSelectOptions.join('')}
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="edit-documento">Documento</label>
                    <br><br>
                    <input type="text" class="form-control id="edit-documento" name="documento" value="${documento}" disabled>
                    <input type="file" class="form-control" id="edit-documento" name="documento" accept=".pdf" required value="${documento}">
                </div>
            </form>`,
            showCancelButton: false,
            confirmButtonText: 'Actualizar',
            confirmButtonColor:'darkblue',
            preConfirm: () => {
                const Proyectodoc = Swal.getPopup().querySelector('#edit-proyectos').value;
                const Tipodoc = Swal.getPopup().querySelector('#edit-tipodoc').value;
                if (!Proyectodoc || !Tipodoc) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('edit-personal-form').submit();
            }
        });
    });
}


const deleteButtons = document.getElementsByClassName('btn-eliminar');
    for (let i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            const documentacionId = this.getAttribute('data-id');
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

                    fetch('<?php echo base_url(); ?>/Documentacion/Eliminar/' + documentacionId, {
                        method: 'POST'
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                    }).then(() => {
                        Swal.fire(
                            '¡Eliminado!',
                            'La documentación se eliminó correctamente.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }).catch(error => {
                        Swal.fire(
                            'Error',
                            `No es posible eliminar la documentación`,
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