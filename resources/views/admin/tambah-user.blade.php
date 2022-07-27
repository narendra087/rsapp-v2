@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Tambah User') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/tambah-user" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                                Periksa kembali data yang anda masukkan.
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-control-label">{{ __('Username (Nomor RM)') }}</label>
                                <div class="@error('username')border border-danger rounded-2 @enderror">
                                    <input class="form-control" value="{{ old('username') }}" type="text" placeholder="Masukkan nomor RM" id="username" name="username">
                                </div>
                                @error('username')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label">{{ __('Email') }}</label>
                                <div class="@error('email')border border-danger rounded-2 @enderror">
                                    <input class="form-control" value="{{ old('email') }}" type="email" placeholder="@example.com" id="email" name="email">
                                </div>
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                <div class="@error('name')border border-danger rounded-2 @enderror">
                                    <input class="form-control" value="{{ old('name') }}" type="text" placeholder="Masukkan nama lengkap" id="name" name="name" />
                                </div>
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-control-label">{{ __('Password') }}</label>
                                <div class="@error('password')border border-danger rounded-2 @enderror">
                                    <input class="form-control" value="" type="password" placeholder="Masukkan password" id="password" name="password" />
                                </div>
                                @error('password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-control-label">{{ __('Nomor Telepon') }}</label>
                                <div class="@error('phone')border border-danger rounded-2 @enderror">
                                    <input class="form-control" value="{{ old('phone') }}" type="tel" placeholder="Isikan Nomor Telepon User" id="phone" name="phone">
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
                                    <input class="form-control" value="{{ old('birthday') }}" type="date" placeholder="Isikan tanggal lahir User" id="birthday" name="birthday">
                                </div>
                                @error('birthday')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-control-label">{{ __('Alamat') }}</label>
                            <div class="@error('address') border border-danger rounded-2 @enderror">
                                <textarea class="form-control" rows="5" type="text" placeholder="Masukkan alamat User" id="address" name="address">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-control-label">{{ __('Role') }}</label>
                                <div class="row">
                                    @foreach ($role as $r)
                                    <div class="col-2">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                placeholder="Pilih role"
                                                id="role"
                                                name="role"
                                                value="{{$r->id}}"
                                                @if (old('role') == $r->id)
                                                    checked
                                                @endif
                                            >
                                            <label for="role" class="form-control-label">{{$r->role_name}}</label>
                                        </div>
                                    </div>
                                    @endforeach

                                    @error('role')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>
                                </div>
                            </label>
                        </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-primary btn-md mt-4 mb-4">{{ 'Tambah' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
