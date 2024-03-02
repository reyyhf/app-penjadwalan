@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">Struktur</span> Kurikulum</h4>
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <a href="{{ route('curriculum_lessons.create') }}" class="btn bg-teal btn-rounded"><li class="fa fa-plus-square"></li> Tambah</a>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li class="active">Struktur Kurikulum</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="col-md-12">
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
                            <th style="width: 5%" rowspan="2">#</th>
                            <th style="width: 25%" rowspan="2">Kategori</th>
                            <th style="width: 20%" rowspan="2">Pelajaran</th>
                            <th colspan="6" style="text-align: center">Jadwal Minggu / Jam</th>
                            <th style="width: 20%;text-align:center" rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th style="width: 5%">X IPA</th>
                            <th style="width: 5%">X IPS</th>
                            <th style="width: 5%">XI IPA</th>
                            <th style="width: 5%">XI IPS</th>
                            <th style="width: 5%">XII IPA</th>
                            <th style="width: 5%">XII IPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($curriculumLessons as $key => $curriculumLesson)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $curriculumLesson->category_name }}</td>
                                <td>{{ $curriculumLesson->name_lesson }} <br> <b>[{{ $curriculumLesson->acronym }}]</b></td>
                                <td>{{ $curriculumLesson->weight_x }}</td>
                                <td>{{ $curriculumLesson->weight_x_ips }}</td>
                                <td>{{ $curriculumLesson->weight_xi }}</td>
                                <td>{{ $curriculumLesson->weight_xi_ips }}</td>
                                <td>{{ $curriculumLesson->weight_xii }}</td>
                                <td>{{ $curriculumLesson->weight_xii_ips }}</td>
                                <td>
                                    <form action="{{ route('curriculum_lessons.destroy', ['curriculum_lesson' => $curriculumLesson->id]) }}" method="post" onsubmit="return confirm('Yakin hapus data?')">
                                        <a href="{{ route('curriculum_lessons.edit', ['curriculum_lesson' => $curriculumLesson->id ]) }}"
                                            class="btn btn-default btn-icon btn-rounded" data-toggle="tooltip"
                                            data-original-title="Edit">
                                            <i class="icon-pen6"></i></i>
                                        </a>
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
