@extends('base.layout')
@section('title','home')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-2 container-p-y">
      <div class="row">
        <div class="col-lg-8 mb-4 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Hello {{ Auth::user()->name }}</h5>
                  <p class="mb-4">
                    Selamat Datang di website  <span class="fw-bold">Pengelolaaan Data Siswa SMP 43 Padang </span>
                  </p>
                </div>
              </div>
              <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                  <img
                    src="../assets/img/illustrations/man-with-laptop-light.png"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
         <!-- Container untuk ApexCharts -->
         <div id="chart">

         </div>
         <div class="container-fluid">
          <section>
            <div class="row">
              <div class="col-12 mt-3 mb-1">
                <h5 class="text-uppercase">Data Siswa SMP 43 Padang</h5>
                <p>Statistics </p>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                      <div class="d-flex flex-row">
                        <div class="align-self-center">
                          <i class="fas fa-pencil-alt text-info fa-3x me-4"></i>
                        </div>
                        <div>
                          <h4>Total Siswa Terdaftar disistem</h4>
                          <h2 class="h1 mb-0 text-center" >{{$totalStudents}}</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="">
                      <div class="">
                        <div>
                          <h4 class="text-center">Total Pelanggaran Siswa</h4>
                          <h2 class="h1 mb-0 text-center" >{{$totalDisiplin}}</h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between p-md-1">
                      <div class="d-flex flex-row">
                        <div>
                          <h4>Total Kegiatan Ekstrakurikuler</h4>
                          <h2 class="h1 mb-0 text-center" >{{$totalEkskul}}</h2>
                        </div>
                      </div>
                      <div class="align-self-center">
                        <i class="far fa-heart text-danger fa-3x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-md-12 mb-4">
                <div class="card">
                  <div class="card-body">
                    <div class="">
                      <div class="">
                        <div>
                          <h4 class="text-center">Total user</h4>
                          <h2 class="h1 mb-0 text-center" >{{$totalUser}}</h2>
                        </div>
                      </div>
                      <div class="align-self-center">
                        <i class="far fa-heart text-danger fa-3x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <!-- / Content -->


   <div class="content-backdrop fade"></div>
  </div>
  </div>
 <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [{
                name: 'Jumlah Siswa',
                data: @json($values)
            }],
            xaxis: {
                categories: @json($labels),
                title: {
                    text: 'Bulan'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah'
                }
            },
            title: {
                text: 'Jumlah pelanggaran siswa per Bulan',
                align: 'left'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
@endsection



