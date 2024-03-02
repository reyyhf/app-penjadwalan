@extends('template')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">Pengguna</span></h4>

        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href=""><i class="icon-home2 position-left"></i> Dashboard</a></li>
            <li><a href="{{ route('users.index') }}">Pengguna</a></li>
            <li class="active">Tambah</li>
        </ul>
    </div>
</div>
<!-- END page header -->
<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                @if (session('message'))
                    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 1000)" x-show="show">
                        <div id="alert_notif" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" x-init="setTimeout()">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">{{session('message')}}</span>
                        </div>
                    </div>
                @endif
                <div class="panel-body">
                    <form action="{{ route('users.store') }}" method="post" class="form-horizontal" id="user-new">
                        @csrf
                        <div class="form-group mb-5">
                            <h6 class=""><strong>Informasi Personal</strong></h6>
                        </div>
                        <div class="form-group">
                            <label class="control-label">NIK<span class="text-danger">*</span></label>
                            <div class="">
                                <input id="nik" name="nik" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email<span class="text-danger">*</span></label>
                            <div class="">
                                <input id="email" name="email" type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Pengguna<span class="text-danger">*</span></label>
                            <div class="">
                                <input id="name" name="name" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password<span class="text-danger">*</span></label>
                            <div class="">
                                <input id="password" name="password" type="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hak Akses<span class="text-danger">*</span></label>
                            <div class="">
                                @foreach ($positions as $position)
                                    <div class="radio">
                                        <label>
                                            <input name="status" value="{{ $position->id }}" type="radio" class="styled" @if($position->id == 1) checked @else @endif>
                                            {{ $position->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group mb-5 addition-teacher hidden">
                            <h6 class=""><strong>Informasi Guru</strong></h6>
                        </div>
                        <div class="form-group addition-teacher hidden">
                            <label class="control-label">Mata Pelajaran yang Diampu Guru<span class="text-danger">*</span></label>
                            <div class="">
                                <div class="multi-select-full">
                                    <select class="multiselect-filtering" name="lesson[]" multiple="multiple" required>
                                        @foreach ($lessons as $lesson)
                                        <option value="{{ $lesson->id }}">{{ $lesson->name_lesson." - ".$lesson->categoryLesson['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group addition-teacher hidden">
                            <label class="control-label">Kelas Mengajar Guru<span class="text-danger">*</span></label>
                            <div class="">
                                <div class="checkbox">
                                    <label>
                                        <input name="x" value="1" type="checkbox" class="styled">
                                        Kelas X
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="xi" value="1" type="checkbox" class="styled">
                                        Kelas XI
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="xii" value="1" type="checkbox" class="styled">
                                        Kelas XII
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group addition-teacher hidden">
                            <label class="control-label">Beban Mengajar Guru(Jam)<span class="text-danger">*</span></label>
                            <div class="">
                                <input name="load_teacher" type="number" class="form-control"
                                    placeholder="Masukkan Beban Mengajar Guru" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save position-left"></i> Simpan</button>
                            <span class="text-muted">&nbsp atau</span>
                            <a href="{{ route('users.index') }}"
                                class="btn btn-btn-link">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer text-muted">
        &copy; 2021. Penjadwalan
    </div>
    {{-- END Footer --}}
</div>
<!-- END Page Content -->
@endsection
@section('js')
{{-- <script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script> --}}
{{-- <script type="text/javascript" src="assets/js/pages/datatables_sorting.js"></script> --}}
<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/form_multiselect.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
<script>
    $(document).ready(function () {
        $(".styled, .multiselect-container input").uniform({
	        radioClass: 'choice'
		});

        $("input[type=radio][name='status']").change(function () {
            var status = $(this).val();
            if(status == 3 || status == 4){
                $(".addition-teacher").removeClass("hidden");
            }else{
                $(".addition-teacher").addClass("hidden");
            }
        })

        $("#user-new").validate({
            rules: {
                nik: {
                    digits: true,
                    minlength: 5,
                    maxlength: 10
                },
                name: {
                    digits: false,
                    minlength: 5
                },
                lesson: {
                    minlength: 1
                },
                load_teacher: {
                    digits: true
                }
            },
            messages: {
                nik: {
                    required: "Kolom NIK harus diisi",
                    digits: "Harus berisi Angka",
                    minlength: "NIK minimal 5 digit",
                    maxlength: "NIK minimal 10 digit"
                },
                name: {
                    required: "Kolom nama harus diisi",
                    digits: "Harus berisi huruf",
                    minlength: "Nama minimal 5 digit"
                },
                lesson: {
                    minlength: "Minimal 1 Mata Pelajaran"
                },
                load_teacher: {
                    required: "Kolom beban mengajar harus diisi",
                    digits: "Harus berisi angka"
                }
            }
        });

    });

</script>
@endsection
