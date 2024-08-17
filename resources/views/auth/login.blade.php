<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon1.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <!-- Page CSS -->

    
    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
    
    <style>
      .bg-login-page {
         background-image: url('{{ asset('storage/asset/login-page.jpg') }}');
         background-size:cover;

        }
    </style>
</head>
<body>
  
 
    <section class="vh-100 bg-login-page" > 
     <form method="POST" action="{{ route('login') }}">
            @csrf
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
      
                  <h3 class="mb-5">Login</h3>
      
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" name="email" id="typeEmailX-2" class="form-control form-control-lg" />
                    <label class="form-label" for="typeEmailX-2">username</label>
                  </div>
      
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" />
                    <label class="form-label" for="typePasswordX-2">Password</label>
                  </div>
      
                  <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                </div>
              </div>
            </div>
          </div>
        </div>
     </form>
    </section>
<!-- Section: Design Block -->
 
      
      
          <!-- Core JS -->
          <!-- build:js assets/vendor/js/core.js -->
          <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
          <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
          <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
          <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
      
          <script src="{{asset('assets/vendor/js/menu.js')}}"></script>
          <!-- endbuild -->
      
          <!-- Vendors JS -->
          <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
      
          <!-- Main JS -->
          <script src="{{asset('assets/js/main.js')}}"></script>
      
          <!-- Page JS -->
          <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
      
          <!-- Place this tag in your head or just before your close body tag. -->
          <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
