<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Storage Log Viewer') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    @include('logViewer::css')
</head>
<body>
<div class="wrapper ">
    <div class="main-panel">
        <div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
            <div class="logo">
                            <span class="simple-text logo-normal">
                                {{ __('Route Usage') }}
                            </span>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item {{ request()->is('logviewer') ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('logviewer') }}">
                            <i class="material-icons">content_paste</i>
                            <p>{{ __('Log Viewer') }}</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('routeusage') ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('routeusage') }}">
                            <i class="material-icons">router</i>
                            <p>{{ __('Route Usage') }}</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand">Project Route Usage</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Route Usage Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <tr>
                                            <th>
                                                Route Name
                                            </th>
                                            <th>
                                                Uri
                                            </th>
                                            <th>
                                                Controller
                                            </th>
                                            <th>
                                                Count
                                            </th>
                                            <th>
                                                Last Accessed
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($query_route as $key => $value)
                                            <tr>
                                                <td>
                                                    {{$value->route_name}}
                                                </td>
                                                <td>
                                                    {{$value->uri}}
                                                </td>
                                                <td>
                                                    {{$value->controller}}
                                                </td>
                                                <td>
                                                    {{$value->count}}
                                                </td>
                                                <td>
                                                    @if($value->last_accessed !== null)
                                                        {{$value->last_accessed}}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                {{--<nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://www.creative-tim.com">
                                {{ __('Creative Tim') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://creative-tim.com/presentation">
                                {{ __('About Us') }}
                            </a>
                        </li>
                        <li>
                            <a href="http://blog.creative-tim.com">
                                {{ __('Blog') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://www.creative-tim.com/license">
                                {{ __('Licenses') }}
                            </a>
                        </li>
                    </ul>
                </nav>--}}
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>, made with <i class="material-icons">favorite</i> by
                    Ahilan S M.
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<!--   Core JS Files   -->
@include('logViewer::script')
</body>
</html>
