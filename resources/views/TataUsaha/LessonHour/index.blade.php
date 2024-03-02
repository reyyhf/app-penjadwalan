@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">Jadwal</span> Mata Pelajaran</h4>
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <a href="{{ route('lesson_hours.create') }}" class="btn bg-teal btn-rounded"><li class="fa fa-plus-square"></li> Tambah</a>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li class="active">Jadwal Mata Pelajaran</li>
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
                            <th style="width: 20%">Tahun Ajaran</th>
                            <th style="width: 40%">Kelas</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 20%; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lessonHours as $key => $lessonHour)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $lessonHour->start_period }} / {{ $lessonHour->last_period }}</td>
                            <td>{{ $lessonHour->class_name }}</td>
                            <td>@if ($lessonHour->status =="0")
                                    <span class="badge badge-danger">Belum Selesai</span>
                                @elseif ($lessonHour->status =="1")
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <form action="{{ route('lesson_hours.destroy', ['lesson_hour' => $lessonHour->id]) }}" method="post" onsubmit="return confirm('Yakin hapus data?')">
                                    <a href="{{ route('lesson_hours.edit', ['lesson_hour' => $lessonHour->id]) }}"
                                        class="btn btn-default btn-icon btn-rounded" data-toggle="tooltip"
                                        data-original-title="Edit">
                                        <i class="icon-pen6"></i>
                                    </a>
                                    <a href="{{ route('lesson_hours.detail_lessons.index', ['lesson_hour' => $lessonHour->id]) }}"
                                        class="btn btn-default btn-icon btn-rounded" data-toggle="tooltip"
                                        data-original-title="Detail"><i class="icon-search4"></i></a>
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
