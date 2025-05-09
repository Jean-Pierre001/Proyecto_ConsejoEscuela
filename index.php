<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Consejo Escolar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="icon" href="img/consejoicono.ico" />
  <style>
    
    body {
      background: linear-gradient(180deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .hero {
      background-image: url('imagenes/fondo.jpg');
      background-size: cover;
      background-position: center;
      height: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      font-size: 2em;
      font-weight: bold;
      position: relative;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      border: 2px solid #888;
      background-attachment: fixed;
    }

    .hero::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
    }

    .hero-text {
      position: relative;
      z-index: 1;
    }

    section {
      padding: 40px 0;
    }

    section h2 {
      font-size: 2.5em;
      margin-bottom: 20px;
      color: #2C9E3E;
      font-weight: bold;
      text-align: center;
    }

    .service,
    .project {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
    }

    .service:hover,
    .project:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .imagenes {
      border-radius: 16px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
      width: 100%;
      height: auto;
      object-fit: cover;
      margin-bottom: 15px;
    }

    footer {
      background-color: #2C3E50;
      color: white;
      text-align: center;
      padding: 20px;
      margin-top: auto;
    }

    .navbar {
      transition: all 0.3s ease;
      background-color: white;
      padding-top: 1rem;
      padding-bottom: 1rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .navbar.shrink {
      padding-top: 0.3rem;
      padding-bottom: 0.3rem;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.7rem;
      color: #1d3a8a;
    }

    .navbar-brand span {
      font-size: 0.9rem;
      background-color: #1d3a8a;
      color: white;
      padding: 6px 6px;
      border-radius: 3px;
      margin-right: 4px;
    }

    .nav-link {
      color: #1d3a8a !important;
      font-weight: 500;
    }

    .nav-link:hover,
    .nav-item.dropdown:hover .nav-link {
      color: #f6b800 !important;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    

/* Desactivar los estilos de enlace en los servicios */
#servicios a {
  text-decoration: none; /* Quita el subrayado */
  color: inherit; /* Hereda el color del texto padre */
}

#servicios a:hover {
  text-decoration: none; /* Quita el subrayado al hacer hover */
  color: inherit; /* Mantiene el color del texto */
}

/* Estilo para la sección de servicios */
#servicios {
  background-color: #f4f7fc;
  padding: 60px 0;
}

.section-title {
  text-align: center;
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 40px;
  color: #2c3e50;
  text-transform: uppercase;
}

.service {
  background-color: #fff;
  border-radius: 10px;
  padding: 30px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.service:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.service h3 {
  font-size: 24px;
  margin-bottom: 15px;
  color: #34495e;
}

.service p {
  font-size: 16px;
  color: #7f8c8d;
  margin-bottom: 0;
}

.service-icon {
  font-size: 40px;
  color: #2980b9;
  margin-bottom: 15px;
}

.service-icon i {
  transition: color 0.3s ease;
}

.service:hover .service-icon i {
  color: #16a085;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.row {
  display: flex;
  justify-content: space-between;
}
.social-icons {
  margin-top: 10px;
}

.social-icon {
  margin: 0 10px;
  font-size: 1.5rem;
  color: #2C9E3E;
}

.social-icon:hover {
  color: #f6b800;
}

#logo {
  text-align:center;
}

  </style>
</head>
<body>

  <!-- Navbaresoooosiii -->
  <nav id="mainNavbar" class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <span class="bi bi-house-door-fill"> Consejo Escolar </span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="usuarios/usuarios.php">Usuarios</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">Servicios</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="folders.php">Gestión de carpetas</a></li>
              <li><a class="dropdown-item" href="socios.php">Gestión de socios</a></li>
           </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero: banner de fotografía.
  <div class="hero">
    <div class="hero-text">
      <p>Transformando el Futuro, Hoy</p>
    </div>
  </div> -->

<div id="logo">
  <img src="img/consejologo.png" alt="Logo del Consejo Escolar" height=15% width=15%></img>
</div>


<!-- Servicios -->
<section id="servicios">
  <h2 class="section-title">Herramientas de gestión</h2>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-4">
        <a href="folders.php" class="service text-center d-block h-100">
          <div class="service-icon">
            <i class="fas fa-folder-open"></i>
          </div>
          <h3>Gestión de Carpetas</h3>
          <p>Crear carpetas organizadas por fecha de creación.</p>
        </a>
      </div>
      <div class="col-md-6 mb-4">
        <a href="escuelas/escuelas.php" class="service text-center d-block h-100">
          <div class="service-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3>Gestión de Escuelas</h3>
          <p>Agrega, muestra y elimina escuelas en la base de datos.</p>
        </a>
      </div>
      <!--<div class="col-md-4 mb-4">
        <a href="sistemaContable/contable.php" class="service text-center d-block h-100">
          <div class="service-icon">
            <i class="fas fa-calculator"></i>
          </div>
          <h3>Sistema Contable</h3>
          <p>Visualiza la contabilidad de la empresa de manera detallada.</p>
        </a>
      </div> -->
    </div>
  </div>
</section>


  <!-- Proyectos -->
  <!-- Sin usar.
  <section id="proyectos">
    <h2>Proyectos Recientes</h2>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="project h-100">
            <img src="imagenes/obra1.jpg" alt="Proyecto 1" class="imagenes">
            <h3>Centro Comunitario "Nueva Esperanza"</h3>
            <p>Espacio multifuncional con salón de usos múltiples, aulas para talleres, oficinas administrativas y áreas verdes.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="project h-100">
            <img src="imagenes/obra2.jpg" alt="Proyecto 2" class="imagenes">
            <h3>Vivienda Unifamiliar "Los Álamos"</h3>
            <p>Vivienda de 90 m² con diseño funcional, dos dormitorios, cocina-comedor, baño y patio trasero.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="project h-100">
            <img src="imagenes/obra3.jpg" alt="Proyecto 3" class="imagenes">
            <h3>Nave Industrial "MetalSur"</h3>
            <p>Nave de 500 m² con estructura metálica, área de producción, oficinas y espacio de carga y descarga.</p>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <style>
.map-hover {
    width: 100%;
    max-width: 800px;
    height: 400px;
    margin: 0 auto;
    border: 2px solid #888;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.map-hover:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}
</style>

<div class="map-hover my-4">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.659104875207!2d-62.976390099999996!3d-40.791508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95f6a3695d9920c7%3A0x1230bcd0782d7251!2sCONSEJO%20ESCOLAR%20PATAGONES%20SEDE2!5e0!3m2!1ses-419!2sar!4v1746542196717!5m2!1ses-419!2sar" width=100% height=100% style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>


  <!-- Footer -->
  <footer>
  <p>&copy; 2025 Cooperativa de trabajo La Comarca Ltda. Todos los derechos reservados.</p>
  <div class="social-icons">
    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
  </div>
</footer>


  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        navbar.classList.add('shrink');
      } else {
        navbar.classList.remove('shrink');
      }
    });
  </script>
</body>
</html>
