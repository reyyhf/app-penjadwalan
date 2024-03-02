@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-8">
                    <h4><span class="text-semibold">Metode</span> Tabu Search</h4>
                </div>
                <br>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
                <li class="active">Metode Tabu Search</li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                @if (session('message'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered"
                            x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                            <span class="text-semibold">{{ session('message') }}</span>
                        </div>
                    </div>
                @endif
                <form action="{{ route('tabu-search.searching') }}" method="POST" style="max-width: 28em">
                    @csrf
                    <div class="form-group">
                      <label style="font-weight: 500" for="tabu_size">Tabu size</label>
                      <input type="number" name="tabu_size" class="form-control" id="tabu_size" min="1" required>
                    </div>
                    <div class="form-group">
                      <label style="font-weight: 500" for="max_iteration">Max iteration</label>
                      <input type="number" name="max_iteration" class="form-control" id="max_iteration" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Hitung</button>
                </form>
            </div>
        </div>
    </div>
@endsection
