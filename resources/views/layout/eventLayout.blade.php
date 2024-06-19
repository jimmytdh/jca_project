{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css'])

</head>

<body>
    <div class="d-flex">
        <div class="sideBar bg-dark text-white p-4">
            <div class="text-center mb-4">
                <div class="img mb-3 bg-light mx-auto"></div>
                <h6>ADMINISTRATOR <i class="fas fa-th-large"></i></h6>

            </div>
            <hr class="bg-secondary">
            <nav class="nav flex-column">
                <a href="{{ route('event.index') }}" class="nav-link text-white">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Events
                </a>
                <a href="{{ route('eventShow.show', ['event' => $event->id]) }}" class="nav-link text-white">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Create Judge
                </a>
                <a href="{{ route('contestant.index', ['event' => $event->id]) }}" class="nav-link text-white">
                    <i class="fa fa-users" aria-hidden="true"></i> Create Contestant
                </a>

                <a href="{{ route('admin.logout')}}" class="nav-link text-white">
                    <i class="fa fa-unlock" aria-hidden="true"></i> Logout
                </a>


            </nav>
        </div>





        <div class="eventContent flex-grow-1 overflow-auto"> <!-- Added overflow-auto -->
            <div class="customHeader w-100 p-4 bg-primary text-white d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">{{ $event->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('preliminaryRatings.index', ['event' => $event->id]) }}"
                                    class="nav-link">Pre-interview</a></li>
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('swimwearRatings.index', ['event' => $event->id]) }}"
                                    class="nav-link">Swimwear</a></li>
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('gownRatings.index', ['event' => $event->id]) }}"
                                    class="nav-link">Gown</a></li>
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('ranking.index', ['event' => $event->id]) }}"
                                    class="nav-link">Ranking</a></li>
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('semifinalAdmin.index', ['event' => $event->id]) }}"
                                    class="nav-link">Semifinal</a></li>
                            <li class="nav-item d-none d-sm-inline-block"><a
                                    href="{{ route('finalRatings.index', ['event' => $event->id]) }}"
                                    class="nav-link">Final</a></li>
                        </ol>
                    </nav>
                </div>
                <p class="float-end" id="dateTime"></p>
            </div>
            <div class="p-3" id="show">
                @yield('eventContent')
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    @vite(['resources/js/app.js'])
    @yield('script')
</body>

</html>

 --}}





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @vite(['resources/css/app.css'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">

        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex flex-column align-items-start">
            <h3>{{ $event->title }}</h3>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('preliminaryRatings.index', ['event' => $event->id]) }}"
                        class="nav-link">Pre-interview</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('swimwearRatings.index', ['event' => $event->id]) }}"
                        class="nav-link">Swimwear</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('gownRatings.index', ['event' => $event->id]) }}" class="nav-link">Gown</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('ranking.index', ['event' => $event->id]) }}" class="nav-link">Ranking</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('semifinalAdmin.index', ['event' => $event->id]) }}"
                        class="nav-link">Semifinal</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a
                        href="{{ route('finalRatings.index', ['event' => $event->id]) }}" class="nav-link">Final</a>
                </li>

            </ul>

        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
                    <div class="image">
                        <img src="/Image/missq.jpg" class="img-circle" style="width: 100px; height: 100px; border-radius: 50%;" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Administrator</a>
                    </div>
                </div>



                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">



                        <li class="nav-item">
                            <a href="{{ route('event.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>Events</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('contestant.index', ['event' => $event->id]) }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Contestant</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('eventShow.show', ['event' => $event->id]) }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Judges</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-unlock"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

           @yield('eventHeader')


            <section class="content">
                <div class="container-fluid">
                    @yield('eventContent')
                </div>
            </section>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    @vite(['resources/js/app.js'])
    @yield('script')
</body>

</html>



{{-- <script>
    setInterval(() => {
        document.getElementById('dateTime').textContent = new Date().toLocaleString('en-US', {
            timeZone: 'Asia/Manila'
        })
    }, 1000);

    function cover() {
        const coverBtn = document.getElementById('coverBtn');
        const show = document.getElementById('show');
        const unshow = document.getElementById('unshow');

        if (coverBtn.textContent === "Cover") {
            coverBtn.textContent = "Uncover";
            show.style.display = "none";
            unshow.style.display = "block";
        } else {
            coverBtn.textContent = "Cover";
            show.style.display = "block";
            unshow.style.display = "none";
        }
    }
</script> --}}
