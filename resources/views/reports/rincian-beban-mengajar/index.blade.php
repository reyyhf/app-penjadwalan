@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-10">
                    <h4>Laporan <span class="text-semibold">{{ $title }}</span></h4>
                </div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="btn btn-info btn-rounded">
                        <li class="fa fa-arrow-circle-left"></li> Kembali
                    </a>
                </div>
                <br>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
                <li class="active">Laporan {{ $title }}</li>
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

                <div style="display: flex; justify-content: end; align-items: center; margin-bottom: 20px">
                    <div>
                        <a href="{{ route('rincian-beban-mengajar.cetak-pdf') }}" target="_blank"
                            class="btn btn-success btn-rounded">
                            <li class="fa fa-download"></li> Download Laporan
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datatable-basic table-bordered text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" style="background: #22c55e">Pengajar</th>
                                <th rowspan="2" style="background: #eab308">Kelas</th>
                                @foreach ($days as $day)
                                    <th colspan="{{ count($hours) }}">{{ $day }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($days as $day)
                                    @foreach ($hours as $hour)
                                        <th>{{ $hour }}</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td rowspan="{{ count($schedule['classes']) + 1 }}" style="background: #86efac">
                                        <p style="white-space: nowrap">NIK : {{ $schedule['teacher_nik'] }}</p>
                                        <p style="white-space: nowrap">Nama : {{ $schedule['teacher_name'] }}</p>
                                    </td>

                                    @foreach ($schedule['classes'] as $class)
                                        <tr>
                                            <td style="white-space: nowrap; background: #fde047">{{ $class['class_name'] }}</td>
                                            @foreach ($days as $day)
                                                @foreach ($hours as $hour)
                                                    <td>
                                                        @foreach ($class['detail_lessons'] as $items)
                                                            @foreach ($items as $item)
                                                                @if ($day == $item->day_name && $hour == $item->hour)
                                                                    {{ $item->acronym }}
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
