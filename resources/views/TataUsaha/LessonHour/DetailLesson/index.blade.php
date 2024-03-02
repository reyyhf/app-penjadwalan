@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">{{ $classroom->name }} - </span>{{ $lessonHour->start_period }} / {{ $lessonHour->last_period }}</h4>
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <a href="{{ route('lesson_hours.index') }}" class="btn btn-info btn-rounded"><li class="fa fa-arrow-circle-left"></li>  Kembali</a>
                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('lesson_hours.index') }}">Jadwal Mata Pelajaran</a></li>
            <li class="active">{{ $classroom->name }} - {{ $lessonHour->start_period }} / {{ $lessonHour->last_period }}</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form action="{{ route('lesson_hours.detail_lessons.store',  ['lesson_hour' => $lessonHour->id]) }}"
                id="form" method="post" class="form-horizontal">
                @if (session('message'))
                <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                    <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">{{session('message')}}</span>
                    </div>
                </div>
                @endif
                @if (session('gagal'))
                <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                    <div id="alert_notif" class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">{{session('gagal')}}</span>
                    </div>
                </div>
                @endif
                @if ($errors->any())
                    <div  class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                <input type="hidden" id="weight" name="weight">
                <div class="form-group" @error('curriculum_id') has-error @enderror">
                    <label class="control-label col-lg-2">Pelajaran <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="curriculum_id" id="curriculum_id"
                            class="form-control @error('curriculum_id') has-error @enderror">
                            <option value="">Pilih Pelajaran</option>
                            @foreach ($curriculumLessons as $curriculumLesson)
                                <option value="{{ $curriculumLesson->id }}" data-weight="{{ $curriculumLesson->weight }}">
                                    {{ $curriculumLesson->name_lesson }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-group tanggal hidden" @error('day') has-error @enderror">
                    <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="day" id="day"
                            class="form-control @error('day') has-error @enderror">
                            <option value="">Pilih Hari</option>
                            @foreach ($days as $day)
                                <option value="{{ $day->id }}">
                                    {{ $day->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group tanggal hidden" @error('teacher_id') has-error @enderror">
                    <label class="control-label col-lg-2">Pilih Pengajar</label>
                    <div class="col-lg-10">
                        <select name="teacher_id" id="teacher_id"
                            class="form-control @error('teacher_id') has-error @enderror">
                                <option value="">Pilih Pengajar</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="form-group tanggal hidden" @error('hour') has-error @enderror">
                    <label class="control-label col-lg-2">Jam Pelajaran Ke - </label>
                    <div class="col-lg-10">
                        <select name="hour" id="hour"
                            class="form-control @error('hour') has-error @enderror">
                                <option value="">Pilih Jam</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                    </div>
                </div>


                <div class="form-group tanggal1 hidden" @error('day1') has-error @enderror">
                    <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="day1" id="day1"
                            class="form-control @error('day1') has-error @enderror">
                            <option value="">Pilih Hari</option>
                            @foreach ($days as $day)
                                <option value="{{ $day->id }}">
                                    {{ $day->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group tanggal1 hidden" @error('teacher_id_1') has-error @enderror">
                    <label class="control-label col-lg-2">Pilih Pengajar</label>
                    <div class="col-lg-10">
                        <select name="teacher_id_1" id="teacher_id_1"
                            class="form-control @error('teacher_id_1') has-error @enderror">
                                <option value="">Pilih Pengajar</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="form-group tanggal1 hidden" @error('hour1') has-error @enderror">
                    <label class="control-label col-lg-2">Jam Pelajaran Ke - </label>
                    <div class="col-lg-5">
                        <select name="hour1" id="hour1"
                            class="form-control @error('hour1') has-error @enderror">
                                <option value="">Pilih Jam</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                    </div>
                    <div class="col-lg-5">
                        <input type="integer" class="form-control @error('hour2') is-invalid @enderror" value="{{ old('hour2') }}" name="hour2" id="hour2" readonly/>
                    </div>
                </div>

                <div class="form-group tanggal2 hidden" @error('day2') has-error @enderror">
                    <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="day2" id="day2"
                            class="form-control @error('day2') has-error @enderror">
                            <option value="">Pilih Hari</option>
                            @foreach ($days as $day)
                                <option value="{{ $day->id }}">
                                    {{ $day->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group tanggal2 hidden" @error('teacher_id_2') has-error @enderror">
                    <label class="control-label col-lg-2">Pilih Pengajar </label>
                    <div class="col-lg-10">
                        <select name="teacher_id_2" id="teacher_id_2"
                            class="form-control @error('teacher_id_2') has-error @enderror">
                                <option value="">Pilih Pengajar</option>
                                @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="form-group tanggal2 hidden" @error('hour3') has-error @enderror">
                    <label class="control-label col-lg-2">Jam Pelajaran Ke - </label>
                    <div class="col-lg-5">
                        <select name="hour3" id="hour3"
                            class="form-control @error('hour3') has-error @enderror">
                                <option value="">Pilih Jam</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                    </div>
                    <div class="col-lg-5">
                        <input type="integer" class="form-control @error('hour4') is-invalid @enderror" value="{{ old('hour4') }}" name="hour4" id="hour4" readonly/>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-outline"> <i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="panel panel-flat">
        <div class="panel-body">
            <table class="table datatable-basic">
                <thead>
                    <th style="width: 10%">#</th>
                    <th style="width: 10%">Hari</th>
                    <th style="width: 25%">Pelajaran</th>
                    <th style="width: 25%">Pengajar</th>
                    <th style="width: 20%">Jam Mengajar</th>
                    <th style="width: 10%; text-align:center">Aksi</th>
                </thead>
                <tbody>
                    @foreach ($detailLessons as $key => $detailLesson)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $detailLesson->day_name }}</td>
                        <td>{{ $detailLesson->name_lesson }}</td>
                        <td>{{ $detailLesson->teacher_name }}</td>
                        <td>Jam ke-{{ $detailLesson->hour }}</td>
                        <td>
                            <a href="{{ route('lesson_hours.detail_lessons.edit', ['lesson_hour' => $lessonHour->id, 'detail_lesson' => $detailLesson->id]) }}"
                                class="btn btn-default btn-icon btn-rounded" data-toggle="tooltip"
                                data-original-title="Edit">
                                <i class="icon-pen6"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $("#curriculum_id").change(function () {
        const weight = $('#curriculum_id option:selected').data('weight');
        $('#weight').val(weight);
        if (weight == 1) {
            $(".tanggal").removeClass("hidden");
            $(".tanggal1").addClass("hidden");
            $(".tanggal2").addClass("hidden");
        }else if (weight == 2) {
            $(".tanggal1").removeClass("hidden");
            $(".tanggal2").addClass("hidden");
            $(".tanggal").addClass("hidden");
        }else if(weight == 3){
            $(".tanggal").removeClass("hidden");
            $(".tanggal1").removeClass("hidden");
            $(".tanggal2").addClass("hidden");
        }else if(weight == 4){
            $(".tanggal").addClass("hidden");
            $(".tanggal1").removeClass("hidden");
            $(".tanggal2").removeClass("hidden");
        }else{
            $(".tanggal").addClass("hidden");
            $(".tanggal1").addClass("hidden");
            $(".tanggal2").addClass("hidden");
        }
    })

    $("#hour1").change(function () {
        var jumlah = $(this).val();
        total = parseInt(jumlah) + 1;
        $('#hour2').val(total);
    })

    $("#hour3").change(function () {
        var jumlah = $(this).val();
        total = parseInt(jumlah) + 1;
        $('#hour4').val(total);
    })
});
</script>
@endsection
