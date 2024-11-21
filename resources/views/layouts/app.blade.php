<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Momentym</title>

    <!-- Bootstrap core CSS --> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
    
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .rounded {
        border-radius: 10px;
    }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .back-arrow {
            cursor: pointer;
            margin-right: 10px;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">
</head>
<body>

    @include('layouts.partials.navbar') 
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <main class="container">
        <br>
     
        @yield('content')
          <div class="container">
        @yield('content')
    </div>

    @auth
    <div class="container">
        <h1>Уведомления</h1>

        @foreach(Auth::user()->notifications as $notification)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $notification->type }}</h5>
                    <p class="card-text">{{ $notification->data }}</p>
                    <p class="card-text"><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small></p>
                </div>
            </div>
        @endforeach
    </div>
    @endauth
    </main>
    <footer>
        <p>&copy; 2024 Momentym</p>
    </footer>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
      
  </body>
</html>
