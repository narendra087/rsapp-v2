@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Detail Self Assessment Covid-19</h6>
                </div>
                <hr>
                <div class="px-3">
                    <p class="m-0">Tanggal: <span class="font-weight-bold">{{$response[0]->created_at}}</span></p>
                </div>
                <div class="card-body pt-4 p-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <div class="row">
                                @foreach ($data as $key => $dt)
                                    <p class="mb-2 text-sm text-break">{{$key + 1}}. {{$dt['pertanyaan']}}:
                                        @if ($dt['tipe'] == 'file' && $dt['jawaban'])
                                            <a href="{{route('download',$dt['jawaban'])}}"
                                                class="text-dark font-weight-bold ms-sm-2"
                                                style="display:inline-flex;align-items:center;"
                                            >
                                                <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dt['jawaban'] ? $dt['jawaban'] : '-'}}</span>
                                            </a>
                                        @else
                                            <span class="text-dark font-weight-bold ms-sm-2">{{$dt['jawaban'] ? $dt['jawaban'] : '-'}}</span>
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="/dashboard-pasien" class="btn bg-gradient-dark btn-md mt-4 mb-4" data-toggle="tooltip" data-original-title="Lihat analisa">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

