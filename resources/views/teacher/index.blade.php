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
            <li><a href=""><i class="icon-home2 position-left"></i> Dashboard</a></li>
            <li class="active">Guru</li>
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
                    <table id="table-teacher" class="table datatable-basic datatable-complex-header table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="10%" rowspan="2" class="text-center">No</th>
                            <th rowspan="2" class="text-center">NIK</th>
                            <th rowspan="2" class="text-center">Nama Guru</th>
                            <th colspan="3" class="text-center">Kelas Mengajar</th>
                            <th width="15%" rowspan="2" class="text-center">Status Guru</th>
                            <th width="10%" rowspan="2" class="text-center">Beban Mengajar</th>
                            <th rowspan="2" width="5%" class="text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th width="6%" class="text-center">X</th>
                            <th width="6%" class="text-center">XI</th>
                            <th width="6%" class="text-center">XII</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td class="text-center">{{ $no }}</td>
                                <td class="text-center">{{ $teacher->nik }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td class="text-center">
                                    @if ($teacher->x_class == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($teacher->xi_class == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($teacher->xii_class == 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($teacher->position->id == 3)
                                        <span class="badge badge-success">{{ $teacher->position->name }}</span>
                                    @else
                                        <span class="badge badge-info">{{ $teacher->position->name }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $teacher->load_teacher }}</td>
                                <td class="text-center">
                                    <a href="{{ route('teachers.show',['teacher' => $teacher->id]) }}" class="btn btn-default btn-icon btn-rounded"><i class="icon-search4"></i></a>
                                </td>
                                @php
                                    $no++;
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
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
