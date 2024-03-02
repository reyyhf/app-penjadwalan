@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-8">
                    <h4><span class="text-semibold">Constraint</span></h4>
                </div>
                <br>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
                <li class="active">Constraint</li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                @if (session('message'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered"
                            x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span></button>
                            <span class="text-semibold">{{ session('message') }}</span>
                        </div>
                    </div>
                @endif
                <form action="{{ route('constraints.update', ['constraint' => $constraint]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 500" for="jam_mengajar_perhari">Jam mengajar perhari & permatkul
                                    di kelas yang sama</label>
                                <input type="number" name="jam_mengajar_perhari"
                                    value="{{ $constraint->jam_mengajar_perhari }}" class="form-control"
                                    id="jam_mengajar_perhari" min="1" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label style="font-weight: 500" for="jam_maks_berurutan">Jam maksimal matpel berurutan
                                    perhari</label>
                                <input type="number" name="jam_maks_berurutan"
                                    value="{{ $constraint->jam_maks_berurutan }}" class="form-control"
                                    id="jam_maks_berurutan" min="1" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2" style="float: right">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
