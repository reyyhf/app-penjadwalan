<!DOCTYPE html>
<html>

<head>
    <title>Laporan {{ $ts_report->title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table thead tr td,
        table tbody tr td {
            font-size: 3.5pt;
        }
    </style>
    <center>
        <h4>Laporan {{ $ts_report->title }}</h4>
        <h5>Skor Konflik : {{ $score }}</h5>
    </center>

    <table style="width: 100%" border="1" cellspacing="0" cellpadding="2">
        <thead>
            <td rowspan="3" style="font-size: 8px">
                Kelas
            </td>
            <tr>
                @foreach ($days as $day)
                    <td colspan="{{ count($hours) }}" class="text-center border">{{ $day }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($days as $day)
                    @foreach ($hours as $hour)
                        <td>{{ $hour }}</td>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($class_reports as $row)
                <tr>
                    <td>
                        <span>{{ $row->class_name }}</span>
                        <hr>
                        <span>Kode guru</span>
                        <hr>
                        <span>Skor</span>
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
    <p style="font-size: 11px; color: red">* Gunakan zoom in / zoom out untuk memperjelas atau melihat data</p>
</body>

</html>
