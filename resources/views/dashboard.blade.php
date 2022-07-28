@extends('layouts.user_type.auth')

@section('content')

  {{-- Data admin --}}
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Pasien Terdaftar</p>
                <h5 class="font-weight-bolder mb-0">
                  {{$count['pasien']}}
                  {{-- <span class="text-success text-sm font-weight-bolder">+10</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Keluhan Menunggu</p>
                <h5 class="font-weight-bolder mb-0">
                {{$count['menunggu']}}
                  {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Keluhan Selesai</p>
                <h5 class="font-weight-bolder mb-0">
                    {{$count['selesai']}}
                  {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel pasien --}}
  <div class="row mt-4">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">Data User</h5>
            </div>
            <a href="{{ route('tambah.user') }}" class="btn bg-gradient-info btn-sm mb-0" type="button">+&nbsp; Tambah User</a>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Daftar</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                @forelse ($user as $u)
                <tr key="{{$u->id}}">
                  <td>
                    <div class="px-3">
                      <span class="text-secondary text-sm font-weight-bold">{{$u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</span>
                    </div>
                  </td>
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{$u->user_username}}</p>
                  </td>
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{$u->user_name}}</p>
                  </td>
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{$u->role_name}}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-{{$u->user_status === 'Active' ? 'success' : 'warning'}}">{{$u->user_status === 'Active' ? 'Aktif' : 'Nonaktif'}}</span>
                  </td>
                  <td class="align-middle">
                    <a href="/edit-user/{{$u->id}}" class="btn bg-gradient-dark btn-sm mb-0 px-3" data-toggle="tooltip" data-original-title="Edit user">
                        Edit
                    </a>
                    {{-- <a href="javascript:;" class="btn bg-gradient-danger btn-sm mb-0 px-3" data-toggle="tooltip" data-original-title="Edit user">
                        Delete
                    </a> --}}
                    <a href="{{ route('rubah.status', $u->id) }}" onclick="event.preventDefault(); document.getElementById('submit-form-{{$u->id}}').submit();" class="btn bg-gradient-{{ $u->user_status === 'Active' ? 'secondary' : 'primary' }} btn-sm mb-0 px-3" data-toggle="tooltip" data-original-title="Edit user">
                        {{ $u->user_status === 'Active' ? 'Nonaktifkan' : 'Aktivasi' }}
                    </a>
                    <form id="submit-form-{{$u->id}}" action="{{ route('rubah.status', $u->id) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td class="text-center text-mute" colspan="4">Data post tidak tersedia</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@push('dashboard')
  <script>
    window.onload = function() {
      console.log('load')
    }
  </script>
@endpush

