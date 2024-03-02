@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">Kelas</span></h4>
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <a href="{{ route('classrooms.create') }}" class="btn bg-teal btn-rounded"><li class="fa fa-plus-square"></li> Tambah</a>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li class="active">Kelas</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            @if (session('message'))
                    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">{{session('message')}}</span>
                        </div>
                    </div>
                @endif
                <table class="table datatable-basic">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 45%">Kelas</th>
                            <th style="width: 15%">Jurusan</th>
                            <th style="width: 15%">Total Siswa</th>
                            <th style="width: 15%; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classrooms as $key => $classroom)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $classroom->name }}</td>
                            <td>@if ($classroom->class_major == "IPA")
                                    <span class="badge bg-teal">{{ $classroom->class_major }}</span>
                                @elseif ($classroom->class_major == "IPS")
                                <span class="badge badge-info">{{ $classroom->class_major }}</span>
                                @endif
                            </td>
                            <td>{{ $classroom->total_student }}</td>
                            <td>
                                <form action="{{ route('classrooms.destroy', ['classroom' => $classroom->id]) }}" method="post" onsubmit="return confirm('Yakin hapus data?')">
                                    <a href="{{ route('classrooms.edit', ['classroom' => $classroom]) }}"
                                        class="btn btn-default btn-icon btn-rounded" data-toggle="tooltip"
                                        data-original-title="Edit">
                                        <i class="icon-pen6"></i>
                                    </a>
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-default btn-icon btn-rounded"><i class="icon-trash"></i></button>
                                    </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>

@endsection
