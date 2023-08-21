@extends('layouts.master')

@section('content')
<main>
  <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
      <div class="page-header-content pt-4">
        {{-- <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="tool"></i></div>
                            Rule App Menu
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div> --}}
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-n10">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                  <h3 class="card-title">List of Detail Transaction</h3>
                  <a href="{{ url('/transaction') }}" class="back-button"><i class="fas fa-arrow-left"></i> Back</a>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="mb-3 col-sm-12">

                      <!--alert success -->
                      @if (session('status'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session('status') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif

                      @if (session('failed'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session('failed') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif

                      <!--alert success -->
                      <!--validasi form-->
                      @if (count($errors)>0)
                      <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <ul>
                          <li><strong>Data Process Failed !</strong></li>
                          @foreach ($errors->all() as $error)
                          <li><strong>{{ $error }}</strong></li>
                          @endforeach
                        </ul>
                      </div>
                      @endif
                      <!--end validasi form-->
                    </div>
                    <div class="table-responsive">
                      <table id="tableDetailTransaction" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Price</th>
                            <th>NO Seats</th>
                            <th>NO Tickets</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                          $no=1;
                          @endphp
                          @foreach ($detail as $data)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->price }}</td>
                            <td>{{ $data->no_seat }}</td>
                            <td>{{ $data->no_ticket }}</td>
                          </tr>

                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>


</main>

<script>
    $(document).ready(function() {
      var table = $("#tableDetailTransaction").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>
@endsection