<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Forms - Kaiadmin Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('backend/assets/img/kaiadmin/favicon.ico')}}"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["backend/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css')}}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css')}}" />
  </head>

  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Login</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="#">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
           
        </ul>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Login Here</div>
            </div>
            <div class="card-body">
              <div class="row">
            @include('backend/layouts/message')

                <div class="col-md-6 col-lg-12">
                    <form action="{{ route('admin.authenticate') }}" method="POST">
                        @csrf
                  <div class="form-group">
                    <label for="email"><strong>Email</strong></label>
                    <input
                      type="email"
                      value="{{ old('email') }}"
                      class="form-control  @error('email') is-invalid @enderror"
                      name="email"
                      id="email"
                      placeholder="Enter Email" />

                      @error('email')

                      <p class="invalid-feedback">{{ $message }}</p>
                          
                      @enderror
                    
                  </div>
                  <div class="form-group">
                    <label for="password"><strong>Password</strong></label>
                    <input
                      type="password"
                      class="form-control  @error('password') is-invalid @enderror"
                      name="password"
                      id="password"
                      placeholder="Enter Password"/>
                      @error('password')

                      <p class="invalid-feedback">{{ $message }}</p>
                          
                      @enderror
                  </div>
                  <div class="card-action">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>