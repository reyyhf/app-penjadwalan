<!DOCTYPE html>
<html>

<head>
    <title>Laporan {{ $ts_report->title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-4">
        <center>
            <h4>Laporan {{ $ts_report->title }}</h4>
            <h5>Skor Konflik : {{ $score }}</h5>
        </center>
        <br />
        <a href="{{ route('jadwal-pelaran.cetak_pdf', $ts_report->id) }}" class="btn btn-primary mb-2" target="_blank">CETAK PDF</a>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th rowspan="3" class="text-center" style="position: relative">
                        <div style="position: absolute; right: 50%; bottom: 50%; translate: 50%">Kelas</div>
                    </th>
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
                                <td class="@if (isset($result[$key]) && $result[$key]->conflict != 0) bg-danger text-white @endif">
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

</body>

</html>
