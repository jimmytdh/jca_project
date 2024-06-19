{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{session('event_name')}}</title>

    @vite(['resources/css/app.css'])

</head>

<body>

    @if (session('judge_name'))
        <div class="container-fluid bg-secondary">
            <div class="d-flex justify-content-between align-items-center bg-secondary p-3 rounded shadow-sm">

                <div class="d-flex gap-2 align-items-center">
                    <div>
                        <p class="mb-0">Hello <strong>{{ session('judge_name') }}</strong>, Welcome to <strong>{{session('event_name')}}</strong>!</p>
                    </div>
                    @yield('judgesNavs')
                </div>


                <div>
                    <form action="{{ route('judge.logout') }}" method="get" class="mb-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn btn-sm">Logout</i>
                        </button>
                    </form>
                </div>


            </div>
        </div>


        @yield('judgesCont')


    @else
        <h1>You are not logged in</h1>
    @endif


    @vite(['resources/js/app.js'])
    @yield('judgingScript')


    <div class="contestantInfoAll">
        @yield('contestant')
    </div>


</body>

</html>

<style>
    .contestantInfoAll{
        width: 100%;
        height: 100vh;
        background-color: rgba(51, 51, 51, 0.8);
        position: fixed;
        top: 0;
        display: none;
    }
    </style>

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.contestantInfoAll').forEach(function(element) {
            element.addEventListener('click', function() {
                this.style.display = 'none';
                this.style.justify-content = 'center';
                this.style. align-items = 'center';
            });
        });
    });
</script>



 --}}





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{session('event_name')}}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex flex-column align-items-start">
            <h4>{{session('event_name')}}</h4>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                @yield('judgesNavs')
            </ul>

        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
                    <div class="image">
                        <img src="/Image/missq.jpg" class="img-circle" style="width: 100px; height: 100px; border-radius: 50%;" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ session('judge_name') }}</a>
                    </div>
                </div>



                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">



                        <li class="nav-item">
                            <a href="{{ route('event.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>Cover</p>
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
                    @yield('judgesCont')
                </div>
            </section>

        </div>
    </div>



    @vite(['resources/js/app.js'])
    @yield('judgingScript')
</body>

</html>
