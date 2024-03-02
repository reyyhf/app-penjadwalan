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
            <li class="active">Tambah</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="panel panel-flat">
        <form class="form-horizontal" action="{{ route('lesson_hours.store') }}" id="form" method="post">
            <div class="panel-body">
                @if (session('message'))
                    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">{{session('message')}}</span>
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
                    <div class="form-group" @error('class_id') has-error @enderror">
                        <label class="control-label col-lg-2">Kelas <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="class_id" id="class_id"
                                class="form-control @error('class_id') has-error @enderror">
                                <option value="">Pilih Kelas</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">
                                        {{ $classroom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @error('type_curriculum') has-error @enderror">
                        <label class="control-label col-lg-2">Tipe Kurrikulum <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select name="type_curriculum" id="type_curriculum"
                            class="form-control @error('class_id') has-error @enderror">
                                <option value="">Pilih Tipe</option>
                                <option value="weight_x">X IPA</option>
                                <option value="weight_x_ips">X IPS</option>
                                <option value="weight_xi">XI IPA</option>
                                <option value="weight_xi_ips">XI IPS</option>
                                <option value="weight_xii">XII IPA</option>
                                <option value="weight_xii_ips">XII IPS</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-outline"> <i class="fa fa-save"></i> Simpan</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('lesson_hours.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
