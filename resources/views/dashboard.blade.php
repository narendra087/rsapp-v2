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
                  {{count($pasien)}}
                  {{-- <span class="text-success text-sm font-weight-bolder">+10</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Keluhan Selesai</p>
                <h5 class="font-weight-bolder mb-0">
                  10
                  {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Keluhan Pending</p>
                <h5 class="font-weight-bolder mb-0">
                  5
                  {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
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
            <a href="{{ route('tambah.user') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Tambah User</a>
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
                @forelse ($pasien as $psn)
                <tr key="{{$psn->id}}">
                  <td>
                    <div class="px-3">
                      <span class="text-secondary text-xs font-weight-bold">{{$psn->created_at ? $psn->created_at->format('d/m/Y') : '-' }}</span>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{$psn->user_username}}</p>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{$psn->user_name}}</p>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">{{$psn->role_name}}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-{{$psn->user_status === 'Active' ? 'success' : 'warning'}}">{{$psn->user_status === 'Active' ? 'Aktif' : 'Nonaktif'}}</span>
                  </td>
                  <td class="align-middle">
                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                      Lihat Pasien
                    </a>
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

