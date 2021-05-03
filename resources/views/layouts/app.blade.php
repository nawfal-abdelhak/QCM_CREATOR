<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @auth
    <script>
        window.Laravel = {!! json_encode([
            'user' => Auth::user() ,
            'unreadnotifs' => Auth()->user()->unreadnotifications,
            'readnotifs' => Auth()->user()->readnotifications,
            'count' => Auth()->user()->unreadnotifications->count(),

        ]) !!};
    </script>

    @endauth
    
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body >
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Qcm') }} --}}
                    QCM
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    @auth
                   
                    <ul class="navbar-nav">
                        
                        @if (Auth::user()->is_admin)
                        <li class="nav-item mr-5">
                            <router-link :to="{ name: 'createQcm' }" :class="{'ss': subIsActive('/createQcm')}">creer qcm</router-link>
                        </li>
                        @endif
                        @if (!Auth::user()->is_admin)
                        <li class="nav-item mr-5">
                            <router-link :to="{ name: 'qcm' }" :class="{'ss': subIsActive('/qcm')}">qcm</router-link>
                        </li>
                        @endif
                        @if (Auth::user()->is_admin)
                        <li class="nav-item mr-5">
                            <router-link :to="{ name: 'myqcm' }" :class="{'ss': subIsActive('/myqcm')}">mes qcm</router-link>
                        </li>
                        @endif
                        @if (Auth::user()->is_admin)
                        <li class="nav-item mr-5">
                            <router-link :to="{ name: 'addstudent' }" :class="{'ss': subIsActive('/addstudent')}">Ajouter etudiant</router-link>
                        </li>
                        @endif
                        <li class="nav-item mr-5">
                        <notifications-component></notifications-component>
                       </li>

                        {{-- <li class="nav-item dropdown">
                            <a id="navbarDropdown" class=" dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                               
                                    <span class=" fa fa-bell"></span>
                            <span class="badge badge-light ">{{Auth()->user()->unreadnotifications->count()}}</span>

                                 
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                
                                <a class="dropdown-item">
                                 @foreach (Auth()->user()->unreadNotifications  as $notification)
                                @if (!Auth::user()->is_admin)
                                <div onclick="sendnotif('{{$notification->id}}')" style="background-color:lightgray">{{$notification->data['data']}}</div>
                                @endif
                                @if (Auth::user()->is_admin)
                                <div onclick="sendnotif('{{$notification->id}}')"  style="background-color:lightgray" >{{$notification->data['data1']}}</div>
                                @endif
                                @endforeach

                                  
                                @foreach (Auth()->user()->readNotifications  as $notification)
                                @if (!Auth::user()->is_admin)
                                <div >{{$notification->data['data']}}</div>
                                @endif
                                @if (Auth::user()->is_admin)
                                <div  >{{$notification->data['data1']}}</div>
                                @endif
                                @endforeach


                                </a>

                               
                            </div>
                        </li>  --}}
                        

                        
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('se connecter') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        {{-- style="background-image: url('images/ss.jpeg') cover" --}}
        <main class="py-4">            
            @yield('content')
        </main>
    </div>
    
  {{-- <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer> --}}
</body>
</html>
<script>

 




</script>

<style>
    .ss{
        text-decoration: underline;

    }
 </style>
