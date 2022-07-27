@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">

          {{-- SECTION: Daftar Pasien --}}
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Daftar Pasien</h5>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Pasien</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keluhan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($response as $resp)
                    <tr>
                      <td>
                        <div class="px-3">
                          <span class="text-secondary text-xs font-weight-bold">{{$resp->created_at}}</span>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$resp->user_name}}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$resp->answer }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-{{$resp->response_status_id == 1 ? 'warning' : 'success'}}">{{$resp->response_status_id == 1 ? 'Menunggu' : 'Selesai'}}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('validasi.keluhan', [$resp->answer_response_id]) }}" class="btn bg-gradient-info btn-sm mb-0" type="button">Analisa</a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td class="text-center text-mute" colspan="5">Data pasien belum tersedia</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- SECTION: Riwayat Pasien --}}
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Riwayat Pasien</h5>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Pasien</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keluhan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($result as $res)
                    <tr>
                      <td>
                        <div class="px-3">
                          <span class="text-secondary text-xs font-weight-bold">{{$res->created_at}}</span>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$res->user_name}}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$res->answer}}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-{{$res->response_status_id == 2 ? 'warning' : 'success'}}">{{$res->response_status_id == 2 ? 'Menunggu Diagnosa' : 'Selesai'}}</span>
                      </td>
                      <td class="align-middle">
                        {{-- <a href="javascript:;" class="btn bg-gradient-primary btn-sm mb-0" type="button">Lihat Analisa</a> --}}
                        <a href="javascript:;" class="btn bg-gradient-info btn-sm mb-0" type="button">Ubah Analisa</a>
                      </td>
                    </tr>
                    @empty
                        <tr>
                            <td class="text-center text-mute" colspan="5">Riwayat pasien belum tersedia</td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  @endsection
