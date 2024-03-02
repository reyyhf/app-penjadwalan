@extends('template')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">Pengguna</span></h4>
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <a href="{{ route('users.create') }}" class="btn bg-teal btn-rounded"><li class="fa fa-plus-square"></li> Tambah</a>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href=""><i class="icon-home2 position-left"></i> Dashboard</a></li>
            <li class="active">Pengguna</li>
        </ul>
    </div>
</div>
<!-- END page header -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                @if (session('message'))
                    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">{{session('message')}}</span>
                        </div>
                    </div>
                @endif
                <div class="panel-body">
                    <table id="table-user" class="table datatable-basic table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="15%" class="text-center">NIK</th>
                                <th class="text-center">Nama Pengguna</th>
                                <th width="15%" class="text-center">Status Pengguna</th>
                                <th width="17%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($employees as $employee)
                                <tr>
                                    <td width="10%" class="text-center">{{ $no }}</td>
                                    <td class="text-center">{{ $employee->nik }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td class="text-center">
                                        @if ($employee->position->id == 1)
                                            <span class="badge badge-danger">{{ $employee->position->name }}</span>
                                        @elseif ($employee->position->id == 2)
                                            <span class="badge badge-warning">{{ $employee->position->name }}</span>
                                        @elseif ($employee->position->id == 3)
                                            <span class="badge badge-success">{{ $employee->position->name }}</span>
                                        @else
                                            <span class="badge badge-info">{{ $employee->position->name }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('users.destroy',['user' => $employee->id]) }}" method="post" onsubmit="return confirm('Yakin hapus data?')">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('users.edit',['user' => $employee->id]) }}" class="btn btn-default btn-icon btn-rounded"><i class="icon-pen6"></i></a>
                                            <button type="submit" class="btn btn-default btn-icon btn-rounded"><i class="icon-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @php
                                $no++;
                            @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer text-muted">
        &copy; 2021. Penjadwalan
    </div>
    {{-- END Footer --}}
</div>
<!-- END Page Content -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
