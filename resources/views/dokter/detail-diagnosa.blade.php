@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Detail Diagnosa Assessment Covid-19</h6>
                </div>
                <hr>
                <div class="card-body pt-2 py-3 pb-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <div class="row">
                                @foreach ($dataPasien as $key => $dP)
                                    <p class="mb-2 text-sm text-break">{{$key + 1}}. {{$dP['pertanyaan']}}:
                                        @if ($dP['tipe'] == 'file' && $dP['jawaban'])
                                            <a href="{{route('download.data.pasien',$dP['jawaban'])}}"
                                                class="text-dark font-weight-bold ms-sm-2"
                                                style="display:inline-flex;align-items:center;"
                                            >
                                                <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dP['jawaban'] ? $dP['jawaban'] : '-'}}</span>
                                            </a>
                                        @else
                                            <span class="text-dark font-weight-bold ms-sm-2">{{$dP['jawaban'] ? $dP['jawaban'] : '-'}}</span>
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </div>
                <hr>
                <div class="px-3">
                    <p class="m-0">Diagnosa</p>
                </div>
                <div class="card-body pt-4 p-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <div class="row">
                                @forelse ($dataDokter as $dD)
                                    <span class="mb-2 text-sm">{{$dD['pertanyaan']}}: <span class="text-dark font-weight-bold ms-sm-2">{{$dD['jawaban']}}</span></span>
                                @empty
                                    <span class="mb-2 text-sm">Belum ada diagnosa.</span>
                                @endforelse
                            </div>
                        </div>
                    </li>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="/dashboard-dokter" class="btn bg-gradient-dark btn-md mt-4 mb-4" data-toggle="tooltip" data-original-title="Lihat analisa">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

