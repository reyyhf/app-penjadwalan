@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Kategori</span> Pelajaran</h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('category_lessons.index') }}">Kategori Pelajaran</a></li>
            <li class="active">Tambah</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form class="form-horizontal" action="{{ route('category_lessons.store') }}" id="form" method="post">
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
                        <label class="control-label col-lg-2">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-outline"> <i class="fa fa-save"></i> Simpan</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('category_lessons.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
