@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <div class="col-md-10">
                <h4><span class="text-semibold">{{ $classroom->name }} - </span>{{ $lessonHour->start_period }} / {{ $lessonHour->last_period }}</h4>
            </div>
            <div class="col-md-2">
            </div>
            <br>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('lesson_hours.index') }}">Jadwal Mata Pelajaran</a></li>
            <li><a href="{{ route('lesson_hours.detail_lessons.index',['lesson_hour'=>$lessonHour->id]) }}">{{ $classroom->name }} - {{ $lessonHour->start_period }} / {{ $lessonHour->last_period }}</a></li>
            <li class="active">Ubah</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('lesson_hours.detail_lessons.update', ['lesson_hour' => $lessonHour, 'detail_lesson' => $detailLesson]) }}" id="form" method="post">
                @csrf
                @method('PUT')
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-lg-2">Pelajaran <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" value="{{$curriculum->name_lesson}}" name="name_lesson" readonly/>
                        </div>
                    </div>
                    <div class="form-group" @error('day') has-error @enderror">
                        <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="day" id="day"
                                class="form-control @error('day') has-error @enderror">
                                <option value="">Pilih Hari</option>
                                @foreach ($days as $day)
                                    <option value="{{ $day->id }}" {{ $detailLesson->day == $day->id ? 'selected' : '' }}>
                                        {{ $day->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @error('hour') has-error @enderror">
                        <label class="control-label col-lg-2">Jam Pelajaran Ke - </label>
                        <div class="col-lg-10">
                            <select name="hour" id="hour"
                                class="form-control @error('hour') has-error @enderror">
                                    <option value="">Pilih Jam</option>
                                    <option value="1" {{ $detailLesson->hour == "1" ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $detailLesson->hour == "2" ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $detailLesson->hour == "3" ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $detailLesson->hour == "4" ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $detailLesson->hour == "5" ? 'selected' : '' }}>5</option>
                                    <option value="6" {{ $detailLesson->hour == "6" ? 'selected' : '' }}>6</option>
                                    <option value="7" {{ $detailLesson->hour == "7" ? 'selected' : '' }}>7</option>
                                    <option value="8" {{ $detailLesson->hour == "8" ? 'selected' : '' }}>8</option>
                                    <option value="9" {{ $detailLesson->hour == "9" ? 'selected' : '' }}>9</option>
                                </select>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-teal btn-outline"> <i class="fa fa-save"></i> Perbarui</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('lesson_hours.detail_lessons.index',['lesson_hour'=>$lessonHour->id]) }}"
                        class="btn btn-btn-link">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
