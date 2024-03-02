@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-10">
                    <h4>Detail Laporan <span class="text-semibold">{{ $ts_report->title }}</span></h4>
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
                <li class="active">Detail Laporan {{ $ts_report->title }}</li>
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
                    <div <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px">
                        <h5><b>Skor konflik : {{ $score }}</b></h5>
                        <div>
                            <a href="{{ route('jadwal-pelajaran.index_pdf', $ts_report->id) }}" target="_blank" class="btn btn-success btn-rounded">
                                <li class="fa fa-download"></li> Download Laporan
                            </a>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="3">Kelas</th>
                            </tr>
                            <tr>
                                @foreach ($days as $day)
                                    <th colspan="{{ count($hours) }}" class="text-center border">{{ $day }}</th>
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
                            @foreach ($class_reports as $row)
                                <tr>
                                    <td style="font-weight: 500">
                                        <span>{{ $row->class_name }}</span>
                                        <hr>
                                        <span style="white-space: nowrap">Kode guru</span>
                                        <hr>
                                        <span style="white-space: nowrap">Skor</span>
                                    </td>

                                    @foreach ($days as $day)
                                        @foreach ($hours as $key => $hour)
                                            @php
                                                $filter_schedule = $row->schedule_reports->filter(function ($k) use ($day) {
                                                    return strtolower($k->day) == strtolower($day);
                                                });
                                                $key_filter_lesson = null;
                                                $result = null;

                                                if (count($filter_schedule) != 0) {
                                                    $key_filter = $filter_schedule->keys();

                                                    $key_first = $key_filter[0];
                                                    $result = $filter_schedule[$key_first]->hour_reports;
                                                    // dd($result);
                                                }

                                            @endphp
                                            <td class="@if (isset($result[$key]) && $result[$key]->conflict != 0) bg-warning @endif">
                                                @if (isset($result[$key]))
                                                    {!! $result[$key]->acronym . '<hr/>' . $result[$key]->id_guru . '<hr/>' !!}
                                                    @if (isset($result[$key]->conflict))
                                                        {!! $result[$key]->conflict !!}
                                                    @else
                                                        0
                                                    @endif
                                                @endif
                                            </td>
                                        @endforeach
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
