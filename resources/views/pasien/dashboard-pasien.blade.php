@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Riwayat Keluhan</h5>
                </div>
                <a href="{{ route('form.keluhan') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Tambah Keluhan</a>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Keluhan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keluhan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($response as  $resp)
                        <tr key={{$resp->id}}>
                            <td>
                                <div class="px-3">
                                    <span class="text-secondary text-xs font-weight-bold">{{$resp->created_at}}</span>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{$resp->answer}}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-{{$resp->status ? 'success' : 'warning' }}">{{$resp->status ? 'Selesai' : 'Pending'}}</span>
                            </td>
                            <td class="align-middle">
                                <a href="/hasil-analisa/{{$resp->id}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Lihat analisa">
                                    Lihat Analisa
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
    </div>
  </main>

  @endsection
