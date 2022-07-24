@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          {{-- SECTION: Daftar Keluhan dan Analisis --}}
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Daftar Keluhan dan Analisis</h5>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Keluhan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pasien</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Perawat</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keluhan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="px-3">
                          <span class="text-secondary text-xs font-weight-bold">12/07/2022</span>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Sutejo</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Salsa</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Batuk</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('form.diagnosa') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">Diagnosa</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          {{-- SECTION: Riwayat diagnosa --}}
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-0">Riwayat Diagnosa</h5>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                  <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Keluhan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pasien</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Perawat</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keluhan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="px-3">
                          <span class="text-secondary text-xs font-weight-bold">12/07/2022</span>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Sutejo</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Salsa</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Batuk</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Selesai</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('form.diagnosa') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">Lihat Diagnosa</a>
                      </td>
                    </tr>
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
