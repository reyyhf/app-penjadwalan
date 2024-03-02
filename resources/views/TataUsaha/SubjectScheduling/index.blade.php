@extends('template')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="col-md-8">
                    <h4><span class="text-semibold">Penjadwalan</span> Mata Pelajaran</h4>
                </div>
                <br>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-component">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
                <li class="active">Penjadwalan Mata Pelajaran</li>
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
                    <h5>Skor konflik : {{ $conflict_score }}</h5>
                    <table class="table datatable-basic table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="3">Kelas</th>
                            </tr>
                            <tr>
                                @foreach ($days as $day)
                                    <th colspan="{{ $day->hour_perday }}" class="text-center border">{{ $day->name }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($days as $day)
                                    @for ($i = 1; $i <= $day->hour_perday; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <td style="font-weight: 500">
                                        <span>{{ $lesson['class_name'] }}</span>
                                        <hr>
                                        <span style="white-space: nowrap">Kode guru</span>
                                        <hr>
                                        <span style="white-space: nowrap">Score</span>
                                    </td>

                                    @foreach ($days as $day)
                                        @for ($i = 0; $i < $day->hour_perday; $i++)
                                            @php
                                                $filter_lessons = array_filter($lesson['schedule'], function ($k) use ($day) {
                                                    return $k['day'] == $day->name;
                                                });

                                                $key_filter_lesson = null;
                                                $result = null;

                                                if ($filter_lessons) {
                                                    $key_filter_lesson = key($filter_lessons);
                                                    $result = $filter_lessons[$key_filter_lesson]['hours'];
                                                }

                                            @endphp
                                            <td class="@if (isset($result[$i]) && isset($result[$i]->conflict)) bg-warning @endif">
                                                @if (isset($result[$i]))
                                                    {!! $result[$i]->acronym . '<hr/>' . $result[$i]->id_guru . '<hr/>' !!}
                                                    @if (isset($result[$i]->conflict))
                                                        {!! $result[$i]->conflict !!}
                                                    @else
                                                        0
                                                    @endif
                                                @endif
                                            </td>
                                        @endfor
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
