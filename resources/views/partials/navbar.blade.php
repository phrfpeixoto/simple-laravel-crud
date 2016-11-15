<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('home')}}">{{trans('Simple Laravel CRUD')}}</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    @if(!auth()->check())
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form" method="post" action="{{route('login')}}" accept-charset="UTF-8">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="{{trans('Email address')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="{{trans('Password')}}" required>
                                            <div class="help-block text-right"><a href="">{{trans('Forget the password ?')}}</a></div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">{{trans('Sign in')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="bottom text-center">
                                    {{trans('}New here ?')}} <a href="/register"><b>{{trans('Join Us')}}</b></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @else
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <b><i class="fa fa-user-circle"></i> {{auth()->user()->name}}</b> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('manage-users')
                        <li>
                            <a href="{{route('manage-users')}}"><i class="fa fa-users"></i> {{trans('Users')}}</a>
                        </li>
                        @endcan
                        @can('audit', App\State::class)
                        <li>
                            <a href="{{route('audit')}}"><i class="fa fa-database"></i> {{trans('General Log')}}</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> {{trans('Logout')}}</a>
                        </li>
                    </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>