@extends('layouts.user_type.auth')

@section('content')

<div>
    <div>
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Detail Pengkajian Pasien Covid-19') }}</h6>
            </div>
            <hr class="mb-0">
            <div class="card-body pt-4 p-3">
                <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">Data Pasien</h6>
                        <div class="row">
                            @foreach ($dataPasien as $key => $dPasien)
                                <p class="mb-2 text-sm text-break">{{$key + 1}}. {{$dPasien['pertanyaan']}}:
                                    @if ($dPasien['tipe'] == 'file' && $dPasien['jawaban'])
                                        <a href="{{route('download',$dPasien['jawaban'])}}"
                                            class="text-dark font-weight-bold ms-sm-2"
                                            style="display:inline-flex;align-items:center;"
                                        >
                                            <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dPasien['jawaban'] ? $dPasien['jawaban'] : '-'}}</span>
                                        </a>
                                    @else
                                        <span class="text-dark font-weight-bold ms-sm-2">{{$dPasien['jawaban'] ? $dPasien['jawaban'] : '-'}}</span>
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    </div>
                </li>
                <hr>
                <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column w-100">
                        <h6 class="mb-3 text-sm">Analisis Masalah</h6>
                        <div class="row">
                            @foreach ($dataPerawat as $key => $dPerawat)
                                @if ($dPerawat['pertanyaan'] != 'Prioritas Masalah')
                                    <p class="mb-2 text-sm text-break">{{$dPerawat['pertanyaan']}}:
                                        @if ($dPerawat['tipe'] == 'file' && $dPerawat['jawaban'])
                                            <a href="{{route('download',$dPerawat['jawaban'])}}"
                                                class="text-dark font-weight-bold ms-sm-2"
                                                style="display:inline-flex;align-items:center;"
                                            >
                                                <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dPerawat['jawaban'] ? $dPerawat['jawaban'] : '-'}}</span>
                                            </a>
                                        @else
                                            <span class="text-dark font-weight-bold ms-sm-2">{{$dPerawat['jawaban'] ? $dPerawat['jawaban'] : '-'}}</span>
                                        @endif
                                    </p>
                                @else
                                    <div>
                                        <hr class="mt-3 mb-4">
                                        <h6 class="text-sm mb-3">Prioritas Masalah</h6>
                                        <span class="text-dark">{{$dPerawat['jawaban'] ? $dPerawat['jawaban'] : '-'}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('update.pengkajian', Request::route('id')) }}" class="btn bg-gradient-dark btn-sm mb-0" type="button">Ubah</a>
                        </div>
                    </div>
                </li>
                <hr>
                <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <div class="row">
                            @if (count($dataDokter) > 0)
                                @foreach ($dataDokter as $key => $dDokter)
                                    <p class="mb-2 text-sm text-break">{{$dDokter['pertanyaan']}}:
                                        @if ($dDokter['tipe'] == 'file' && $dDokter['jawaban'])
                                            <a href="{{route('download',$dDokter['jawaban'])}}"
                                                class="text-dark font-weight-bold ms-sm-2"
                                                style="display:inline-flex;align-items:center;"
                                            >
                                                <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dDokter['jawaban'] ? $dDokter['jawaban'] : '-'}}</span>
                                            </a>
                                        @else
                                            <span class="text-dark font-weight-bold ms-sm-2">{{$dDokter['jawaban'] ? $dDokter['jawaban'] : '-'}}</span>
                                        @endif
                                    </p>
                                @endforeach
                            @else
                            <p class="mb-2 text-sm">Belum ada diagnosa.</p>
                            @endif
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </div>
</div>
@endsection
