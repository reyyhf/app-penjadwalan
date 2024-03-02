@extends('template')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Master</span> Hari</h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="icon-home2 position-left"></i>Dashboard</a></li>
            <li><a href="{{ route('days.index') }}">Master Hari</a></li>
            <li class="active">Ubah</li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <form action="{{ route('days.update', ['day' => $day]) }}" id="form" method="post" class="form-horizontal">
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
                    <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$day->name}}" name="name"/>
                    </div>
                </div>
                <div class="form-group" @error('hour_perday') has-error @enderror">
                    <label class="control-label col-lg-2">Hari <span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="number" class="form-control @error('hour_perday') is-invalid @enderror" value="{{$day->hour_perday}}" name="hour_perday"/>
                    </div>
                </div>
                    <button type="submit" class="btn bg-teal btn-outline"> <i class="fa fa-save"></i> Perbarui</button>
                    <span class="text-muted">&nbsp atau</span>
                    <a href="{{ route('days.index') }}"
                        class="btn btn-btn-link">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
