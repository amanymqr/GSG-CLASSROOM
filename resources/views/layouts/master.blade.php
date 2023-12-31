<!doctype html>
<html dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}" lang="{{ App::currentLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    {{--  @if (App::currentLocale() == 'ar')  --}}
    @if (App::isLocale('ar'))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
            integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    @endif



    @stack('styles ')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @yield('style')

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg  border-bottom">
            <div class="container">
                <div class="">
                    <img style="width: 60px " src="{{ asset('img/googlelogo_color_92x30dp.png') }}" alt="">
                    <a class="navbar-brand text-secondary fs-5  fw-normal"
                        href="{{ route('classroom.index') }}">{{ config('app.name', 'Laravel') }}</a>
                </div>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto  ">
                        <x-user-notification-menue count="5" />

                    </ul>
                    <div class="d-flex align-items-center justify-content-center">

                        <ul class="navbar-nav   ">
                            <li class="nav-item dropdown  ">
                                <a class="fs-5 mx-2 text-dark " href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-list-ul"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Join Classroom</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('classroom.create') }}">Create
                                            Classroom</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('classroom.trashed') }}">Trashed
                                            Classroom</a></li>
                                    <li>
                                </ul>
                            </li>
                        </ul>
                        {{--  <p class="mx-1 mb-0">{{ Auth::user()->name }}</p>  --}}
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt=""
                            class="rounded-circle mt-2" style="width: 26px ;">
                    </div>


                </div>


            </div>
        </nav>

    </header>


    @yield('content')


    <footer>
        <p class="text-center text-muted  "><span class="py-2">© {{ date('Y') }} GSG Classroom</span></p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </script>

    <script>
        var classroomId;
        const userId = "{{ Auth::id() }}"
    </script>
    @stack('scripts')
    @vite(['resources/js/app.js'])
</body>

</html>
