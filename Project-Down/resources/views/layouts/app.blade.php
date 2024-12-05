<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href={{ asset('images/logo.png')}} rel="icon">
  <link href={{ asset('base/img/apple-touch-icon.png')}} rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href={{ asset('base/vendor/bootstrap/css/bootstrap.min.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/bootstrap-icons/bootstrap-icons.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/boxicons/css/boxicons.min.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/quill/quill.snow.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/quill/quill.bubble.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/remixicon/remixicon.css') }} rel="stylesheet">
  <link href={{ asset('base/vendor/simple-datatables/style.css') }} rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href={{ asset('base/css/style.css') }} rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  @include('layouts.navigation')

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')

  <main id="main" class="main">

    @yield('pagetitle')

    @yield('main')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src={{ asset('base/vendor/apexcharts/apexcharts.min.js') }}></script>
  <script src={{ asset('base/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
  <script src={{ asset('base/vendor/chart.js/chart.umd.js') }}></script>
  <script src={{ asset('base/vendor/echarts/echarts.min.js') }}></script>
  <script src={{ asset('base/vendor/quill/quill.js') }}></script>
  <script src={{ asset('base/vendor/simple-datatables/simple-datatables.js') }}></script>
  <script src={{ asset('base/vendor/tinymce/tinymce.min.js') }}></script>
  <script src={{ asset('base/vendor/php-email-form/validate.js') }}></script>

  <!-- Template Main JS File -->
  <script src={{ asset('base/js/main.js') }}></script>

</body>

</html>