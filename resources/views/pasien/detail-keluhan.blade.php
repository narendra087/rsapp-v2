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
                    <p class="m-0">Tanggal Keluhan: <span class="font-weight-bold">{{$response[0]->created_at}}</span></p>
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

@endsection

