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
                                {{ __('Storage Log Viewer') }}
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
                    <a class="navbar-brand">Log Viewer - Current Log - <strong>{{$file_to_display}}</strong></a> <a href="{{ route('logdwnld',['file'=>$file_to_display]) }}" class="btn btn-sm"><i class="fa fa-download"></i> Download</a>
                </div>
                <div class="available-log" style="width: 30%;">
                    <select class="form-control" id="pacakge-log-select">
                        @foreach($file_name as $key => $value)
                            <option value="{{Crypt::encryptString($value)}}" @if($value==$file_to_display) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Log Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <tr>
                                        <th>
                                            Environment
                                        </th>
                                        <th style="width: 10%;">
                                            Level
                                        </th>
                                        <th style="width: 20%;">
                                            Date
                                        </th>
                                        <th>
                                            Content
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($final_log as $key => $value)
                                        <tr>
                                            <td>
                                                {{ ucfirst($value['context']) }}
                                            </td>
                                            <td>
                                                <h4><span class="badge" style="background-color: {{ isset($value['level'][1]) ? $value['level'][1] : '#000000'}};color: white">{{ isset($value['level'][0]) ? ucfirst($value['level'][0]) : ''}}</span></h4>
                                            </td>
                                            <td>
                                                {{ $value['date']}}
                                            </td>
                                            <td>
                                                {{ $value['text'] }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info show-desc" data-row="{{$key}}" data-view="show">Show</button>
                                            </td>
                                        </tr>
                                        <tr style="display: none;" id="desc_{{$key}}">
                                            <td COLSPAN="4">
                                                {{ $value['desc'] }}
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
@include('logViewer::script')
<script>
    $(document).on('change', '#pacakge-log-select', function () {
        var logFile = $(this).val();
        window.location.href = '/logviewer?log='+logFile;
    });
    $(document).on('click', '.show-desc', function () {
        var currentRow = $(this).data('row');
        var currentView = $(this).attr('data-view');
        var tempThis = this;
        if(currentView === 'show')
        {
            $('#desc_'+currentRow).show();
            $(tempThis).attr('data-view', 'hide');
            $(tempThis).text('Hide');
        }
        else
        {
            $('#desc_'+currentRow).hide();
            $(tempThis).attr('data-view', 'show');
            $(tempThis).text('Show');
        }
    });
</script>
</body>
</html>
