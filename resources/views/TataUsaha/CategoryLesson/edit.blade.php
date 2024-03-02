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
            <li class="active">Ubah</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('category_lessons.update', ['category_lesson' => $categoryLesson]) }}" id="form" method="POST" class="form-horizontal">
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
                    <div class="form-group" @error('name') has-error @enderror">
                        <label class="control-label col-lg-2">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               value="{{ $categoryLesson->name }}"/>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-teal btn-outline"> <i class="fa fa-save"></i> Perbarui</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('category_lessons.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
