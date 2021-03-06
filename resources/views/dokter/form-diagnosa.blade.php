@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Detail Self Assessment Covid-19</h6>
                </div>
                <hr>
                <div class="card-body pt-2 py-3 pb-3">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Data Pasien</h6>
                            <div class="row">
                                @foreach ($dataPasien as $key => $dPsn)
                                    <p class="mb-2 text-sm">{{$key + 1}}. {{$dPsn['pertanyaan']}}:
                                        @if ($dPsn['tipe'] == 'file' && $dPsn['jawaban'])
                                            <a href="{{route('download.data.pasien',$dPsn['jawaban'])}}"
                                                class="text-dark font-weight-bold ms-sm-2"
                                                style="display:inline-flex;align-items:center;"
                                            >
                                                <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$dPsn['jawaban'] ? $dPsn['jawaban'] : '-'}}</span>
                                            </a>
                                        @else
                                            <span class="text-dark font-weight-bold ms-sm-2">{{$dPsn['jawaban'] ? $dPsn['jawaban'] : '-'}}</span>
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div>
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Formulir Diagnosa Dokter') }}</h6>
            </div>
            <hr class="mb-0">
            <div class="card-body pt-4 p-3">
                <form action="{{route('diagnosa', Request::route('id'))}}" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">Periksa kembali masukkan Anda.</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        @foreach ($questionsDokter as $key => $q)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">{{$key + 1}}. {{ $q->question_detail }}</label>

                                    {{--!!! Input !!!--}}
                                    @if ($q->question_type == 'text')
                                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                            <input class="form-control" value="{{ old('question_'.$q->id) }}" type="text" placeholder="Silahkan diisi" id="input_{{$q->id}}" name="question_{{$q->id}}">
                                        </div>
                                    @endif

                                    {{--!!! Textarea !!!--}}
                                    @if ($q->question_type == 'textarea')
                                        <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                            <textarea class="form-control" rows="5" type="textarea" placeholder="Silahkan diisi" id="textarea_{{$q->id}}" name="question_{{$q->id}}">{{ old('question_'.$q->id) }}</textarea>
                                        </div>
                                    @endif

                                    {{--!!! Radio !!!--}}
                                    @if ($q->question_type == 'boolean')
                                        <div class="row">
                                        @foreach ($choices as $c)
                                            @if ($q->id == $c->question_id)
                                                <div class="col-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                            @if (old('question_'.$q->id) == $c->id)
                                                                checked
                                                            @endif
                                                            type="radio"
                                                            value="{{$c->id}}"
                                                            name="question_{{$q->id}}"
                                                            id="radio_{{$q->id}}_{{$c->id}}"\
                                                        >
                                                        <label class="custom-control-label" for="radio_{{$q->id}}_{{$c->id}}">{{$c->choice}}</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    @endif

                                    {{--!!! Checkbox !!!--}}
                                    @if ($q->question_type == 'options')
                                        <div class="row">
                                        @foreach ($choices as $c)
                                            @if ($q->id == $c->question_id)
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                            @if ((is_array(old('question_'.$q->id)) && in_array($c->id, old('question_'.$q->id))))
                                                                checked
                                                            @endif
                                                            type="checkbox"
                                                            name="question_{{$q->id}}[]"
                                                            value="{{$c->id}}"
                                                            id="options_{{$q->id}}_{{$c->id}}"
                                                        >
                                                        <label class="custom-control-label" for="options_{{$q->id}}_{{$c->id}}">{{$c->choice}}</label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    @endif

                                    {{--!!! File !!!--}}
                                    @if ($q->question_type == 'file')
                                        <div>
                                            <input class="form-file" name="question_{{$q->id}}" type="file" >
                                        </div>
                                    @endif

                                    @error('question_'.$q->id)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Kirim' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
