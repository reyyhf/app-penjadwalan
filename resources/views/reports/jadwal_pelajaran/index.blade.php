@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-8">
                    <h4><span class="text-semibold">Laporan</span> Jadwal Pelajaran</h4>
                </div>
                <br>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
                <li class="active">Laporan Jadwal Pelajaran</li>
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
                <div class="table-responsive">
                    <table class="table datatable-basic table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th>Judul laporan</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $key => $report)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $report->title }}</td>
                                    <td>
                                        <form action="{{ route('jadwal-pelajaran.destroy', $report->id) }}" method="post" onsubmit="return confirm('Yakin hapus data?')">
                                            <a href="{{ route('jadwal-pelajaran.show', $report->id) }}" class="btn btn-default btn-icon btn-rounded"><i class="icon-eye"></i></a>
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
    </div>
@endsection
