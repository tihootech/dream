<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top pl-4">
        <span class="mx-2 text-info text-capitalize"> Current Month : {{cm()}} - {{cmn()}} </span>
        <span class="mx-2 text-success"> Current Year : {{cy()}} </span>
        <span class="mx-2 text-danger"> This Month : {{nf(get_points(cm(),cy()))}} </span>
        <small class="mx-2">
            <a href="{{url('birthdays')}}">
                @if (count( $birthdays = birthdays() ))
                    <i class="fa fa-birthday-cake text-secondary"></i>
                    @foreach ($birthdays as $birthday)
                        <span class="mx-1"> {{$birthday}} </span>
                    @endforeach
                @else
                    <em class="text-muted"> no birthdays... </em>
                @endif
            </a>
        </small>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <form action="{{url('search')}}" method="get">
                            <input class="form-control" name="ps" type="text" placeholder="Search..." id="header-search">
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('home')}}" title="Home" data-toggle="tooltip"> <i class="fas fa-fw fa-home"></i> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{url('result')}}" title="Result" data-toggle="tooltip"> <i class="fas fa-fw fa-list"></i> </a>
                </li>

                <li class="nav-item dropdown connection">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-fw fa-th"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                        <li class="connection-list">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{route('competition')}}" class="connection-item">
                                        <i class="fa fa-car d-block"></i>
                                        Compt
                                    </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{route('process')}}" class="connection-item">
                                        <i class="fa fa-sync d-block"></i>
                                        Process
                                    </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{route('prixes')}}" class="connection-item">
                                        <i class="fa fa-th-list d-block"></i>
                                        Prixes
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{route('events')}}" class="connection-item">
                                        <i class="fa fa-folder-open d-block"></i>
                                        Events
                                    </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{url('stars')}}" class="connection-item">
                                        <i class="fa fa-star d-block"></i>
                                        Stars
                                    </a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{url('awards')}}" class="connection-item">
                                        <i class="fa fa-trophy d-block"></i>
                                        Awards
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                    <a href="{{route('rooms')}}" class="connection-item">
                                        <i class="fa fa-bed d-block"></i>
                                        Rooms
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('assets/images/avatar-1.jpg')}}" alt="user" class="user-avatar-md rounded-circle"></a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <a class="dropdown-item" href="{{url('settings')}}"><i class="fas fa-cog mr-2"></i>Setting</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
