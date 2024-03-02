@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Kelas</span> </h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('classrooms.index') }}">Kelas</a></li>
            <li class="active">Tambah</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('classrooms.store') }}" id="form" method="post" class="form-horizontal">
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
                <div class="form-group" @error('name') has-error @enderror">
                    <label class="control-label col-lg-2">Nama Kelas <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name"/>
                    </div>
                </div>
                <div class="form-group" @error('class_major') has-error @enderror">
                    <label class="control-label col-lg-2">Jurusan <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <div class="radio">
                            <label>
                                <input name="class_major" value="IPA" type="radio" class="styled">IPA
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input name="class_major" value="IPS" type="radio" class="styled">IPS
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" @error('total_student') has-error @enderror">
                    <label class="control-label col-lg-2">Jumlah Siswa<span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="number" min="0" class="form-control @error('total_student') is-invalid @enderror" value="{{ old('total_student') }}" name="total_student"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-outline"> <i class="fa fa-save"></i> Simpan</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('classrooms.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
