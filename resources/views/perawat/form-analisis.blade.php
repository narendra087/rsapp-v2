@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Pengkajian Pasien Covid-19') }}</h6>
            </div>
            <hr class="mb-0">
            <div class="card-body pt-4 p-3">
                <li class="list-group-item border-0 d-flex p-4 mb-4 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">Data Pasien</h6>
                        <div class="row">
                            @foreach ($data as $key => $dt)
                                <p class="mb-2 text-sm">{{$key + 1}}. {{$dt['pertanyaan']}}:
                                    @if ($dt['tipe'] == 'file' && $dt['jawaban'])
                                        <a href="{{route('download.data.pendukung',$dt['jawaban'])}}"
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
                <hr>
                <form action="{{route('analisa', Request::route('id'))}}" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">Periksa kembali data yang anda masukkan.</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        @foreach ($segments as $s)
                            <p class="font-weight-bolder">{{$s->question_segment}}</p>
                            @foreach ($questions as $key => $q)
                                @if ($s->id == $q->question_segment_id)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">{{ $q->question_detail }}</label>

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
                                @endif
                                @endforeach
                            <hr>
                        @endforeach
                        {{-- @foreach ($questions as $q)

                        @endforeach --}}
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
