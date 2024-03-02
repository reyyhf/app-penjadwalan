@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Struktur</span> Kurikulum</h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('curriculum_lessons.index') }}">Struktur Kurikulum</a></li>
            <li class="active">Tambah</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('curriculum_lessons.store') }}" id="form" method="post" class="form-horizontal">
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
                <div class="form-group" @error('name_lesson') has-error @enderror">
                    <label class="control-label col-lg-2">Nama Pelajaran <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control @error('name_lesson') is-invalid @enderror" value="{{ old('name_lesson') }}" name="name_lesson"/>
                    </div>
                </div>

                <div class="form-group" @error('acronym') has-error @enderror">
                    <label class="control-label col-lg-2">Akronim Nama <br> Pelajaran <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input placeholder="Contoh: MAT untuk Matematika" type="text" class="form-control @error('acronym') is-invalid @enderror" value="{{ old('name_lesson') }}" name="acronym"/>
                    </div>
                </div>

                <div class="form-group" @error('category_id') has-error @enderror">
                    <label class="control-label col-lg-2">Kategori Pelajaran <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="category_id" id="category_id"
                            class="form-control @error('category_id') has-error @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categoryLessons as $categoryLesson)
                                <option value="{{ $categoryLesson->id }}">
                                    {{ $categoryLesson->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <h6>Jadwal per Minggu</h6>
                <hr>
                <div class="form-group" @error('weight_x') has-error @enderror">
                    <label class="control-label col-lg-2">X IPA</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_x') is-invalid @enderror" value="{{ old('weight_x') }}" name="weight_x"/>
                    </div>
                </div>
                <div class="form-group" @error('weight_x_ips') has-error @enderror">
                    <label class="control-label col-lg-2">X IPS</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_x_ips') is-invalid @enderror" value="{{ old('weight_x_ips') }}" name="weight_x_ips"/>
                    </div>
                </div>
                <div class="form-group" @error('weight_xi') has-error @enderror">
                    <label class="control-label col-lg-2">XI IPA</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_xi') is-invalid @enderror" value="{{ old('weight_xi') }}" name="weight_xi"/>
                    </div>
                </div>
                <div class="form-group" @error('weight_xi_ips') has-error @enderror">
                    <label class="control-label col-lg-2">XI IPS</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_xi_ips') is-invalid @enderror" value="{{ old('weight_xi_ips') }}" name="weight_xi_ips"/>
                    </div>
                </div>
                <div class="form-group" @error('weight_xii') has-error @enderror">
                    <label class="control-label col-lg-2">XIi IPA</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_xii') is-invalid @enderror" value="{{ old('weight_xii') }}" name="weight_xii"/>
                    </div>
                </div>
                <div class="form-group" @error('weight_xii_ips') has-error @enderror">
                    <label class="control-label col-lg-2">XII IPS</label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('weight_xii_ips') is-invalid @enderror" value="{{ old('weight_xii_ips') }}" name="weight_xii_ips"/>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary btn-outline"> <i class="fa fa-save"></i> Simpan</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('curriculum_lessons.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
