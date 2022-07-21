@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Formulir Screening') }}</h6>
            </div>
            <hr>
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
                                                    <input class="form-control" value="" type="text" placeholder="Silahkan diisi" id="input_{{$q->id}}" name="{{$q->id}}">
                                                    @error('name')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            @endif

                                            {{--!!! Textarea !!!--}}
                                            @if ($q->question_type == 'textarea')
                                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                                    <input class="form-control" value="" row="3" type="textarea" placeholder="Silahkan diisi" id="textarea_{{$q->id}}" name="{{$q->id}}">
                                                    @error('name')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            @endif

                                            {{--!!! Radio !!!--}}
                                            @if ($q->question_type == 'boolean')
                                                <div class="row">
                                                @foreach ($choices as $c)
                                                    @if ($q->id === $c->question_id)
                                                        <div class="col-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="{{$q->id}}" id="radio_{{$q->id}}_{{$c->id}}">
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
                                                                <input class="form-check-input" type="checkbox" value="{{$c->choice}}" id="options_{{$q->id}}_{{$c->id}}">
                                                                <label class="custom-control-label" for="options_{{$q->id}}_{{$c->id}}">{{$c->choice}}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                </div>
                                            @endif

                                            {{--!!! Checkbox !!!--}}
                                            @if ($q->question_type == 'file')
                                                <div class="form-check">
                                                    <input class="form-check-input" type="file" >
                                                </div>
                                            @endif

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
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Kirim Keluhan' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
