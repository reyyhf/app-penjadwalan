@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Jadwal</span> Mata Pelajaran</h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('lesson_hours.index') }}">Jadwal Mata Pelajaran</a></li>
            <li class="active">Ubah</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <form class="form-horizontal" action="{{ route('lesson_hours.update', ['lesson_hour' => $lessonHour]) }}" id="form" method="post">
            @csrf
            @method('PUT')
            <div class="panel-body">
                @if ($errors->any())
                    <div  class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-lg-2">Kelas <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" value="{{$classroom->name}}" name="name_lesson" readonly/>
                    </div>
                </div>
                    <div class="form-group" @error('type_curriculum') has-error @enderror">
                        <label class="control-label col-lg-2">Tipe Kurrikulum <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="type_curriculum" id="type_curriculum"
                            class="form-control @error('class_id') has-error @enderror">
                                <option value="">Pilih Tipe</option>
                                <option value="weight_x" {{ $lessonHour->type_curriculum == "weight_x" ? 'selected' : '' }}>X IPA</option>
                                <option value="weight_x_ips" {{ $lessonHour->type_curriculum == "weight_x_ips" ? 'selected' : '' }}>X IPS</option>
                                <option value="weight_xi" {{ $lessonHour->type_curriculum == "weight_xi" ? 'selected' : '' }}>XI IPA</option>
                                <option value="weight_xi_ips" {{ $lessonHour->type_curriculum == "weight_xi_ips" ? 'selected' : '' }}>XI IPS</option>
                                <option value="weight_xii" {{ $lessonHour->type_curriculum == "weight_xii" ? 'selected' : '' }}>XII IPA</option>
                                <option value="weight_xii_ips" {{ $lessonHour->type_curriculum == "weight_xii_ips" ? 'selected' : '' }}>XII IPS</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-teal btn-outline"> <i class="fa fa-save"></i> Perbarui</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('lesson_hours.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
