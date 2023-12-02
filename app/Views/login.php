<!doctype html>
<html lang="en">
<head> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="resources/css/login.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="resources/img/logo.png">
  <script src="resources/js/alert.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

  <title>Grupo D'ealy - Login</title>
</head>
<body>
  <nav>
    <input type="checkbox" id="check">
    <label for="check" class="check">
      <i class="fas fa-bars"></i>
    </label>
    <a href="#" class="enlace">
      <img src="https://raw.githubusercontent.com/Josdap/Imagen/main/Bodoques.png" alt="" class="cabeza">
    </a>
    <ul> 
      <li><a href="<?php echo base_url();?>">INICIO</a></li>
      <li><a href="#" onclick="fntmensaje()">ACERCA DE</a></li>
    </ul>
  </nav>  
  
  <div class="container-fluid ps-md-0">
    <div class="row g-0">
      <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
      <div class="col-md-8 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-5 col-lg-12 mx-auto">
                <h3 class="login-heading mb-4">¡Bienvenido de nuevo!</h3>

                <form action="<?php echo base_url('login/validateLogin');?>" method="post">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="usuario" id="usuario" required  placeholder="usuario">
                    <label for="usuario">Usuario</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" required placeholder="password">
                    <label for="password">Contraseña</label>
                  </div>
                  <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="showPasswordCheckbox">
                  <label class="form-check-label" for="showPasswordCheckbox">Mostrar contraseña</label>
                  </div>

                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" name="btningresar" type="submit">INICIAR SESION</button>
                    <div class="text-center"> 
                    </div>
                  </div>
                </form>
                <?php if(isset($error)): ?>
                <script>
                 document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                    title: 'Aviso de sesión',
                    text: "<?php echo $error; ?>",
                    icon: 'error',
                    confirmButtonText: 'OK'
                     });
                   });
                 </script>
                 <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
      event.preventDefault();

      const usuario = document.getElementById('usuario').value;
      const password = document.getElementById('password').value;
      const xhr = new XMLHttpRequest();

      xhr.open('POST', '<?php echo base_url('login/validateLogin');?>', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onload = function() {
  if (xhr.status === 200) {
    const response = JSON.parse(xhr.responseText);

    if (response.success) {
      Swal.fire({
        title: '¡Inicio de sesión exitoso!',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000
      }).then(() => {
        window.location.href = response.redirect;
      });
    } else {
      Swal.fire({
        title: 'Aviso de sesión',
        text: response.error,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  }
};


      xhr.send('usuario=' + encodeURIComponent(usuario) + '&password=' + encodeURIComponent(password));
    });
  });
</script>


  <script type="text/javascript" src="resources/js/mostrar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   
</body>
</html>

