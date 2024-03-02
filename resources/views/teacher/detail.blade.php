@extends('template')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="fa fa-graduatioin-cap position-left"></i> <span class="text-semibold">Guru</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i> Dashboard</a></li>
            <li><a href="{{ route('teachers.index') }}"> Guru</a></li>
            <li class="active">Detail</li>
        </ul>
    </div>
</div>
<!-- END page header -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <td width="20%"><b>Nik</b></td>
                            <td width="1%">:</td>
                            <td>{{ $teacher->nik }}</td>
                        </tr>
                        <tr>
                            <td><b>Nama</b></td>
                            <td>:</td>
                            <td>{{ $teacher->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Status Pengguna</b></td>
                            <td>:</td>
                            <td>
                                @if ($teacher->position->id == 3)
                                    <span class="badge badge-success">{{ $teacher->position->name }}</span>
                                @else
                                    <span class="badge badge-info">{{ $teacher->position->name }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Mata Pelajaran yang Diampu</b></td>
                            <td>:</td>
                            <td>
                                <ul>
                                    @foreach ($teacher->detailLessons as $detailLesson)
                                    @if (!empty($detailLesson->curriculumLesson))
                                        <li>{{ $detailLesson->curriculumLesson->name_lesson }}</li>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Kelas Mengajar</b></td>
                            <td>:</td>
                            <td>
                                <ul>
                                    @if ($teacher->x_class == 1)
                                        <li>
                                            X
                                        </li>
                                    @endif
                                    @if ($teacher->xi_class == 1)
                                        <li>
                                            XI
                                        </li>
                                    @endif
                                    @if ($teacher->xii_class == 1)
                                        <li>
                                            XII
                                        </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Beban Mengajar</b></td>
                            <td>:</td>
                            <td>{{ $teacher->load_teacher }}</td>
                        </tr>
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
