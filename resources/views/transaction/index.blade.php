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
                  <h3 class="card-title">List of Transaction</h3>
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
                      <table id="tableTransaction" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No</th>
                            {{-- <th>User</th> --}}
                            <th>NO Transaction</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                            <th>Ref Code</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Platform Fee</th>
                            <th>Grandtotal</th>
                            <th>Partner Portion</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                          $no=1;
                          @endphp
                          @foreach ($transaction as $data)
                          <tr>
                            <td>{{ $no++ }}</td>
                            {{-- <td>{{ $data->user_name }}</td> --}}
                            <td>{{ $data->no_transaction }}</td>
                            <td>{{ $data->qty }}</td>
                            <td>Rp. {{ number_format($data->sub_total) }}</td>
                            <td>{{ $data->ref_code }}</td>
                            <td>Rp. {{ number_format($data->discount) }}</td>
                            <td>Rp. {{ number_format($data->tax) }}</td>
                            <td>Rp. {{ number_format($data->platform_fee) }}</td>
                            <td>Rp. {{ number_format($data->grand_total) }}</td>
                            <td>Rp. {{ number_format($data->partner_portion) }}</td>
                            <td>
                                @if($data->status == '0')
                                <div class="text-secondary">
                                    <b><i>waiting for payment</i></b>
                                </div>
                                @elseif($data->status == '1')
                                <div class="text-primary">
                                    <b><i>payment reviewed</i></b>
                                </div>
                                @elseif($data->status == '2')
                                <div class="text-secondary">
                                    <b><i>refund</i></b>
                                </div>
                                <span class="badge badge-primary">refund</span>
                                @elseif($data->status == '3')
                                <div class="text-danger">
                                    <b><i>canceled</i></b>
                                </div>
                                @elseif($data->status == '4')
                                <div class="text-success">
                                    <b><i>success</i></b>
                                </div>
                                @else
                                <div class="text-secondary">
                                    <b><i>N/A</i></b>
                                </div>
                                @endif
                            </td>
                            <td>{{ $data->notes }}</td>
                            <td>
                                <a href="{{ url('transaction/detail/'.encrypt($data->id) ) }}" class="btn btn-secondary btn-sm my-1" title="Transaction Details"><i class="fa fa-file"></i></a>
                                <a href="{{ url('transaction/payment/'.encrypt($data->id) ) }}" class="btn btn-primary btn-sm my-1" title="Payment"><i class="fas fa-shopping-bag"></i></a>
                            </td>
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
      var table = $("#tableTransaction").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>
@endsection
