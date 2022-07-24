@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Detail Keluhan</h6>
                </div>
                <hr>
                <div class="px-3">
                    <p class="m-0">Tanggal Keluhan: <span class="font-weight-bold">12-04-22</span></p>
                </div>
                <div class="card-body pt-4 p-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Data Keluhan</h6>
                            <div class="row">
                                @foreach ($data as $key => $dt)
                                    <span class="mb-2 text-sm">{{$key + 1}}. {{$dt['pertanyaan']}}: <span class="text-dark font-weight-bold ms-sm-2">{{$dt['jawaban'] ? $dt['jawaban'] : '-'}}</span></span>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </div>
                <hr>
                <div class="px-3">
                    <p class="m-0">Tanggal Diagnosa: <span class="font-weight-bold">-</span></p>
                </div>
                <div class="card-body pt-4 p-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Data Diagnosa</h6>
                            <div class="row">
                                @if ($diagnosa)
                                    <span class="mb-2 text-sm">Diagnosa: <span class="text-dark font-weight-bold ms-sm-2">Hasil diagnosis disini</span></span>
                                @else
                                    <span class="mb-2 text-sm">Belum ada diagnosa.</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Formulir Diagnosa Dokter') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/user-profile" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        @foreach ($questions as $q)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user-name" class="form-control-label">{{ $q->question_detail }}</label>
                                    <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->name }}" type="text" placeholder="Silahkan diisi" id="user-name" name="name">
                                            @error('name')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
