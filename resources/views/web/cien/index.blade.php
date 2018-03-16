<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Instituto CIEN</title>
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />

  <!-- Bootstrap core CSS -->
  <!--link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"-->
  {!!Html::style('cien/vendor/bootstrap/css/bootstrap.min.css')!!}

  <!-- Custom fonts for this template -->
  <!--link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"-->
  {!!Html::style('cien/vendor/font-awesome/css/font-awesome.min.css')!!}
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <!--link href="css/agency.min.css" rel="stylesheet"-->
  {!!Html::style('cien/css/agency.css')!!}
  {!!Html::style('css/cien.css')!!}
  <style>
    nav a.navbar-brand{
      background-image: url("{!!URL::to('icons/logo.svg')!!}");
    }
    nav.navbar-shrink a.navbar-brand{
      background-image: url("{!!URL::to('icons/logo_w.svg')!!}");
    }
    @media (max-width: 992px) {
      nav a.navbar-brand{
        background-image: url("{!!URL::to('icons/logo_w.svg')!!}");
      }
    }
  </style>
</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#page-top">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#services">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#portfolio">Carreras</a>
          </li>
          <!--li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">Convocatorias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#team">Nosotros</a>
          </li-->
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contacto</a>
          </li>
          <li class="nav-item login">
            @if(!Auth::user())
            <div class="nav-link log">Log In</div>
            @else
            <a class="nav-link" href="admin">{{ Auth::user()->user }}</a>
            @endif
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in">Asegura tu ingreso!</div>
        <div class="intro-heading text-uppercase">INSTITUTO C1EN</div>
        <!--a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#services">Saber más</a-->
      </div>
    </div>
  </header>

  <!-- Servicios -->
  <section id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Servicios</h2>
          <h3 class="section-subheading text-muted">Conoce nuestros cursos y modalidades de enseñanza.</h3>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fa fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-university fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Cursos Pre Universitarios</h4>
          <p class="text-muted">Orientamos al estudiante sobre su proyección profesional futura y lo preparamos con capacitación y educación superior para rendir el examen de ingreso.</p>
        </div>
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fa fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-line-chart fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Nivelación Escolar</h4>
          <p class="text-muted">​​Consolidamos los conocimientos y habilidades cognitivas necesarias para finalizar secundaria y, que son fundamentales, para ingresar a la vida académica universitaria.​</p>
        </div>
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fa fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-suitcase fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Clases Particulares</h4>
          <p class="text-muted">Te preparamos en el área o asignaturas que necesites reforzar y mejorar con docentes capacitados y flexibilidad de horarios.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Carreras Grid -->
  <section class="bg-light" id="portfolio" style="padding: 50px 0 50px 0;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Carreras</h2>
          <h3 class="section-subheading text-muted">Estas son algunas de nuestras áreas de preparación profesional que tenemos para ti.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal1">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/01-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Cs. y Tecnología</h4>
            <p class="text-muted">Electrónica, Sistemas,..</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal2">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/02-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Policias - Militares</h4>
            <p class="text-muted">Esbapol, Politécnico,..</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal3">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/03-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Cs. de la Salud</h4>
            <p class="text-muted">Medicina, Enfermería,..</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal4">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/04-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Cs. Económicas</h4>
            <p class="text-muted">Comercial, Contaduría,..</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal5">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/05-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Normalistas</h4>
            <p class="text-muted">Maestros</p>
          </div>
        </div>
        <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal6">
            <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="{!!URL::to('cien/img/portfolio/06-thumbnail.jpg')!!}" alt="">
          </a>
          <div class="portfolio-caption">
            <h4>Cs. Jurídicas y Políticas</h4>
            <p class="text-muted">Derecho, Politología,..</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Convocatorias -->
  <!--section id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Convocatorias</h2>
          <h3 class="section-subheading text-muted">No dejes pasar el tiempo, inscríbete y preparate.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="timeline">
            <li>
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="{!!URL::to('cien/img/about/01.jpg')!!}" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>Febrero</h4>
                  <h4 class="subheading">Policias y Militares</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">Febrero abrimos nuestra convocatoria de curso completo con duración de 6 meses y a partir de mayo nuestros cursos intensivos.</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="{!!URL::to('cien/img/about/2.jpg')!!}" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>Mayo Junio</h4>
                  <h4 class="subheading">An Agency is Born</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="{!!URL::to('cien/img/about/3.jpg')!!}" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>Agosto</h4>
                  <h4 class="subheading">Transition to Full Service</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <img class="rounded-circle img-fluid" src="{!!URL::to('cien/img/about/4.jpg')!!}" alt="">
              </div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4>Noviembre</h4>
                  <h4 class="subheading">Phase Two Expansion</h4>
                </div>
                <div class="timeline-body">
                  <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
              </div>
            </li>
            <li class="timeline-inverted">
              <div class="timeline-image">
                <h4>Se parte
                  <br>De la
                  <br>Historia!
                </h4>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section-->

  <!-- Nosotros -->
  <!--section class="bg-light" id="team">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Sobre Nosotros</h2>
          <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="team-member">
            <img class="mx-auto rounded-circle" src="{!!URL::to('cien/img/team/1.jpg')!!}" alt="">
            <h4>Kay Garland</h4>
            <p class="text-muted">Lead Designer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-whatsapp"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="team-member">
            <img class="mx-auto rounded-circle" src="{!!URL::to('cien/img/team/2.jpg')!!}" alt="">
            <h4>Larry Parker</h4>
            <p class="text-muted">Lead Marketer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-whatsapp"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="team-member">
            <img class="mx-auto rounded-circle" src="{!!URL::to('cien/img/team/3.jpg')!!}" alt="">
            <h4>Diana Pertersen</h4>
            <p class="text-muted">Lead Developer</p>
            <ul class="list-inline social-buttons">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-whatsapp"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 mx-auto text-center">
          <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
        </div>
      </div>
    </div>
  </section-->
  <!-- Clients -->
  <section class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-6">
          <a href="http://www.umss.edu.bo" target="_blank">
            <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/logos/umss.jpg')!!}" alt="">
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="http://www.ejercito.mil.bo/articulos/la_institucion/colmil.html" target="_blank">
            <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/logos/colmil.jpg')!!}" alt="">
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="http://www.unipol.edu.bo/index.php/esbapol" target="_blank">
            <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/logos/esbapol.jpg')!!}" alt="">
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="http://cefomb.blogspot.com/" target="_blank">
            <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/logos/cefom-b.jpg')!!}" alt="">
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contáctanos -->
  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Contáctanos</h2>
          <h3 class="section-subheading text-muted" style="margin-bottom: 50px">Escríbenos por correo o a travez de nuestras redes.</h3>
        </div>
        <div class="col-lg-12 text-center redes">
          <a href="https://api.whatsapp.com/send?phone=59176989899" target="_blank">
            <span>76989899</span><img src="{!!URL::to('icons/whats.svg')!!}" alt="">
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          {!! Form::open(['url' => 'mail','method'=>'post']) !!}
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {!! Form::text('name',null,['placeholder'=>'Nombre Completo *','required', 'maxlength'=>150,'class'=>'col-md-12']) !!}
              </div>
              <div class="form-group">
                {!! Form::email('email',null,['placeholder'=>'Ingrese Email *','required', 'maxlength'=>100,'class'=>'col-md-12']) !!}
              </div>
              <div class="form-group">
                {!! Form::text('phone',null,['placeholder'=>'Ingrese Teléfono *','required', 'maxlength'=>30,'onkeypress'=>"return justNumbers(event);",'class'=>'col-md-12']) !!}
              </div>
              <div class="form-group">
                {!! Form::textarea('message',null,['placeholder'=>'Mensaje *','required', 'maxlength'=>255,'class'=>'col-md-12']) !!}
              </div>
              <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar</button>
              </div>
              <br>
            </div>
            <div class="col-md-6">
              <div class="fb-page" data-href="https://www.facebook.com/instituto100/" data-tabs="timeline" data-width="400" data-height="560" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/instituto100/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/instituto100/">Instituto CIEN</a></blockquote></div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12 text-center">
              <!-- aqui estaba el boton -->
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </section>
  <div id="fb-root"></div>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <span class="copyright">Copyright &copy; www.institutocien.com 2018</span>
        </div>
        <div class="col-md-4">
          <ul class="list-inline social-buttons">
            <!--li class="list-inline-item">
              <a href="#">
                <i class="fa fa-twitter"></i>
              </a>
            </li-->
            <!--li class="list-inline-item">
              <a href="fb://page/462521267252802">
                <i class="fa fa-facebook"></i>
              </a>
            </li-->
            <li class="list-inline-item">
              <a href="https://www.facebook.com/instituto100/" target="_blank">
                <i class="fa fa-facebook"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://api.whatsapp.com/send?phone=59176989899" target="_blank">
                <i class="fa fa-whatsapp"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-4">
          <ul class="list-inline quicklinks">
            <li class="list-inline-item">
              <div>(4) 4028383</div>
            </li>
            <li class="list-inline-item">
              <div>(+591) 76989899</div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Carreras Modals -->

  <!-- Modal 1 -->
  <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Facultad de Tecnología</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/01-full.jpg')!!}" alt="">
                <p><b>La facultad de Ciencias y Tecnología está compuesta por las carreras siguientes:</b></p>
                <ul class="list-inline">
                  <li>Ingeniería Civil</li>
                  <li>Ingeniería de Alimentos</li>
                  <li>Ingeniería de Sistemas</li>
                  <li>Ingeniería Eléctrica</li>
                  <li>Ingeniería Electrónica</li>
                  <li>Ingeniería Electromecánica</li>
                  <li>Ingeniería Industrial</li>
                  <li>Ingeniería en Informática</li>
                  <li>Ingeniería Matemática</li>
                  <li>Ingeniería Mecánica</li>
                  <li>Ingeniería Química</li>
                  <li>Licenciatura en Biología</li>
                  <li>Licenciatura en Didáctica de la Física</li>
                  <li>Licenciatura en Didáctica de la Matemática</li>
                  <li>Licenciatura en Física</li>
                  <li>Licenciatura en Matemáticas</li>
                  <li>Licenciatura en Química</li>
                </ul>
                <p><b>Prepárate para el examen de ingreso en cualquiera de las carreras anteriores con nuestro curso Pre-universitario compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Aritmética-Álgebra</li>
                  <li>Geometría-Trigonometría</li>
                  <li>Física</li>
                  <li>Química</li>
                  <li>Biología</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 2 -->
  <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Facultad de Licenciatura en Ciencias Policiales</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/02-full.jpg')!!}" alt="">

                <p><b>Unidades académicas:</b></p>
                <ul class="list-inline">
                  <li>ANAPOL</li>
                  <li>ESBAPOL</li>
                  <li>ESBAPOLMUS</li>
                </ul>
                <br><br>
                <h2 class="text-uppercase">Ejército de Bolivia</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/021-full.jpg')!!}" alt="">

                <p><b>Unidades académicas:</b></p>
                <ul class="list-inline">
                  <li>COLMIL</li>
                  <li>EMSSE</li>
                  <li>EMTE</li>
                  <li>EMME</li>
                  <li>COLMILAV</li>
                  <li>POLMILAE</li>
                  <li>EMMFAB</li>
                  <li>ESA</li>
                  <li>ESNAMIL</li>
                </ul>
                <p><b>Prepárate para el examen de ingreso en cualquiera de las carreras anteriores con nuestro curso Pre-universitario compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Revisión Médica</li>
                  <li>Test Psicotécnico - Psicológico</li>
                  <li>Matemáticas</li>
                  <li>Fisica</li>
                  <li>Química</li>
                  <li>Lenguaje Literatura</li>
                  <li>Historia - Cívica - Geografía</li>
                  <li>Psicología - Filosofía</li>
                  <li>Bliología</li>
                  <li>Instrucción Física</li>
                  <li>Natación</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 3 -->
  <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Medicina</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/03-full.jpg')!!}" alt="">
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Morfofunción I y II</li>
                  <li>Biología Celular</li>
                  <li>Educación para la Salud</li>
                </ul>
                <br><br><br>
                <h2 class="text-uppercase">Fisioterápia</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Morfofunción</li>
                  <li>Física Básica</li>
                </ul>
                <br><br><br>
                <h2 class="text-uppercase">Nutrición</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Anatomía y Fisiología</li>
                  <li>Biología y Genética</li>
                  <li>Aritmétiga - Lógica</li>
                  <li>Química General</li>
                  <li>Conocimientos y Conceptos Generales</li>
                </ul>
                <br><br><br>
                <h2 class="text-uppercase">Odontología</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Biología</li>
                  <li>Química</li>
                  <li>Técnicas de Estudio</li>
                  <li>Soporte Básico de Vida</li>
                </ul>
                <br><br><br>
                <h2 class="text-uppercase">Bioquímica</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Matemáticas</li>
                  <li>Física</li>
                  <li>Química</li>
                  <li>Biología</li>
                </ul>
                <br><br><br>
                <h2 class="text-uppercase">Enfermería</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <p><b>Nuestro curso Pre-universitario está compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Biología</li>
                  <li>Salud Pública</li>
                  <li>Química</li>
                  <li>Enfermería Clinica</li>
                  <li>Técnicas de Estudio</li>
                  <li>Expresión Oral y Escrita</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 4 -->
  <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">FACULTAD DE CIENCIAS ECONÓMICAS</h2>
                <p class="item-intro text-muted"><!--Lorem ipsum dolor sit amet consectetur.--></p>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/04-full.jpg')!!}" alt="">
                <p><b>La facultad de Ciencias Económicas está compuesta por las carreras siguientes:</b></p>
                <ul class="list-inline">
                  <li>Licenciatura en Contaduría Publica</li>
                  <li>Licenciatura en Administración de Empresas</li>
                  <li>Licenciatura en Economía</li>
                  <li>Licenciatura en Ingeniería Financiera</li>
                  <li>Licenciatura en Ingeniería Comercial</li>
                </ul>
                <p><b>Prepárate para el examen de ingreso en cualquiera de las carreras anteriores con nuestro curso Pre-universitario compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Aritmética</li>
                  <li>Álgebra</li>
                  <li>Historia</li>
                  <li>Lenguaje</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 5 -->
  <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">NORMALISTAS</h2>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/05-full.jpg')!!}" alt="">
                <p><b>Carreras Disponíbles:</b></p>
                <ul class="list-inline">
                  <li>EDUCACIÓN INICIAL</li>
                  <li>CIENCIAS NATURALES</li>
                  <li>CIENCIAS SOCIALES</li>
                  <li>EDUCACIÓN MUSICAL</li>
                  <li>ARTES PLÁSTICAS Y VISUALES</li>
                  <li>VALORES ESPIRITUALES Y RELIGIOSOS</li>
                  <li>COSMOVISIÓN PSICOLOGÍA Y FILOSOFÍA</li>
                  <li></li>
                </ul>
                <p><b>Prepárate para el examen de ingreso en cualquiera de las carreras anteriores con nuestro curso Pre-universitario compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Conocimientos de Materias</li>
                  <li>Conocimnientos de la Especialidad</li>
                  <li>Razonamiento Lógico - Matemático</li>
                  <li>Comprensión Lectora y Razonamiento Verbal</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal 6 -->
  <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">FACULTAD DE CIENCIAS JURÍDICAS Y POLÍTICAS</h2>
                <img class="img-fluid d-block mx-auto" src="{!!URL::to('cien/img/portfolio/06-full.jpg')!!}" alt="">
                <p><b>La facultad de Ciencias Jurídicas y Políticas está compuesta por las carreras siguientes:</b></p>
                <ul class="list-inline">
                  <li>CIENCIAS JURÍDICAS</li>
                  <li>CIENCIAS POLÍTICAS</li>
                </ul>
                <p><b>Prepárate para el examen de ingreso en cualquiera de las carreras anteriores con nuestro curso Pre-universitario compuesto por las siguientes materias:</b></p>
                <ul class="list-inline">
                  <li>Historia Crítica Boliviana</li>
                  <li>Geografía Univ. y Bol.</li>
                  <li>Cívica</li>
                  <li>Normativa Inst. U.</li>
                  <li>Lenguaje y Redacción</li>
                </ul>
                <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fa fa-times"></i>
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('modal.login')
  @include('alerts.succes')

  <!-- Bootstrap core JavaScript -->
  <!--script src="vendor/jquery/jquery.min.js"></script-->
  {!!Html::script('cien/vendor/jquery/jquery.min.js')!!}
  <!--script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script-->
  {!!Html::script('cien/vendor/bootstrap/js/bootstrap.bundle.min.js')!!}

  <!-- Plugin JavaScript -->
  <!--script src="vendor/jquery-easing/jquery.easing.min.js"></script-->
  {!!Html::script('cien/vendor/jquery-easing/jquery.easing.min.js')!!}

  <!-- Contáctanos form JavaScript -->
  <!--script src="js/jqBootstrapValidation.js"></script-->
  {!!Html::script('cien/js/jqBootstrapValidation.js')!!}
  <!--script src="js/contact_me.js"></script-->
  {!!Html::script('cien/js/contact_me.js')!!}

  <!-- Custom scripts for this template -->
  <!--script src="js/agency.min.js"></script-->
  {!!Html::script('cien/js/agency.min.js')!!}
  {!!Html::script('js/cien.js')!!}

</body>

</html>