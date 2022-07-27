@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Pengkajian Pasien Covid-19') }}</h6>
            </div>
            <hr>
            <div class="card-body pt-4 p-3">
                @if (session('updated'))
                    <div class="mt-3  alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-text">{{ session('updated') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white">Periksa kembali data yang anda masukkan.</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                <form action="/validasi-user/{{$pasien->id}}" method="POST" role="form text-left">
                @csrf
                <li class="list-group-item border-0 p-4 bg-gray-100 border-radius-lg">
                    <div class="d-flex flex-column">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                        <div class="@error('name')border border-danger rounded-2 @enderror">
                                            <input class="form-control" value="{{$pasien->user_name}}" type="text" placeholder="Masukkan nama lengkap" id="name" name="name">
                                        </div>
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-control-label">{{ __('Nomor Telepon') }}</label>
                                        <div class="@error('phone')border border-danger rounded-2 @enderror">
                                            <input class="form-control" type="tel" placeholder="+62" id="phone" name="phone" value="{{$pasien->user_phone}}">
                                        </div>
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birthday" class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                        <div class="@error('birthday') border border-danger rounded-2 @enderror">
                                            <input class="form-control" type="date" placeholder="Isikan tanggal lahir pasien" id="birthday" name="birthday" value="{{$pasien->user_birthday}}">
                                        </div>
                                        @error('birthday')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="form-control-label">{{ __('Alamat') }}</label>
                                    <div class="@error('address') border border-danger rounded-2 @enderror">
                                        <textarea class="form-control" rows="5" type="text" placeholder="Masukkan alamat pasien" id="address" name="address" >{{ $pasien->user_address }}</textarea>
                                    </div>
                                    @error('address')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </li>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-0">{{ 'Update Data Pasien' }}</button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="card-body pt-4 p-3">
                <form action="{{route('update.keluhan', Request::route('id'))}}" method="POST" role="form text-left">
                    @csrf
                    <div class="row">
                        @foreach ($segments as $s)
                            <p class="font-weight-bolder">{{$s->question_segment}}</p>
                            @foreach ($questions as $key => $q)
                                @if ($s->id === $q->question_segment_id)
                                    <div class="{{$q->question_type === 'options' ? 'col-12' : 'col-md-6'}}">
                                        <div class="form-group">
                                            <label class="form-control-label">{{$key + 1}}. {{ $q->question_detail }}</label>

                                            {{--!!! Input !!!--}}
                                            @if ($q->question_type == 'text')
                                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                                    <input class="form-control" value="{{ old('question_'.$q->id, $q->answer) }}" type="text" placeholder="Silahkan diisi" id="input_{{$q->id}}" name="question_{{$q->id}}">
                                                </div>
                                            @endif

                                            {{--!!! Textarea !!!--}}
                                            @if ($q->question_type == 'textarea')
                                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                                    <textarea class="form-control" rows="5" type="textarea" placeholder="Silahkan diisi" id="textarea_{{$q->id}}" name="question_{{$q->id}}">{{ old('question_'.$q->id, $q->answer) }}</textarea>
                                                </div>
                                            @endif

                                            {{--!!! Radio !!!--}}
                                            @if ($q->question_type == 'boolean')
                                                <div class="row">
                                                @foreach ($choices as $c)
                                                    @if ($q->id === $c->question_id)
                                                        <div class="col-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                    @if (old('question_'.$q->id, $q->answer) == $c->id)
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
                                                    @if ($q->id === $c->question_id)
                                                        <div class="col-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                    @if ((is_array(old('question_'.$q->id)) && in_array($c->id, old('question_'.$q->id))) || (is_array($q->answer) && in_array($c->id, $q->answer)))
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

                                            {{--!!! Checkbox !!!--}}
                                            @if ($q->question_type == 'file')
                                                <div>
                                                    @if ($q->answer)
                                                        <a href="{{route('download.data.pendukung', $q->answer)}}"
                                                            class="text-dark font-weight-bold ms-sm-2"
                                                            style="display:flex;align-items:center;"
                                                        >
                                                            <i class="ni ni-cloud-download-95"></i>&nbsp;&nbsp;<span>{{$q->answer}}</span>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
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
                    <div class="d-flex justify-content-end mt-4 mb-4">
                        <button type="submit" class="btn bg-gradient-dark btn-md mb-0">{{ 'Update Keluhan' }}</button>
                        <a href="{{ route('form.analisis', Request::route('id')) }}" class="btn bg-gradient-info btn-md mb-0" style="margin-left:10px;" type="button">Analisa Pasien</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
