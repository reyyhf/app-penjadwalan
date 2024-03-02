<!DOCTYPE html>
<html>

<head>
    <title>Laporan {{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table {
            font-size: 3.5pt;
        }
    </style>
    <center>
        <h4>Laporan {{ $title }}</h4>
        <p style="font-size: 11px; color: red">* Gunakan zoom in / zoom out untuk memperjelas atau melihat data</p>
    </center>

    <table style="width: 100%; text-align: center" border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <td rowspan="2" style="background: #22c55e">Pengajar</td>
                <td rowspan="2" style="background: #eab308">Kelas</td>
                @foreach ($days as $day)
                    <td colspan="{{ count($hours) }}">{{ $day }}</td>
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
</body>

</html>
