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
                  <h3 class="card-title">List of Payment</h3>
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
                      <table id="tablePayment" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>File</th>
                            <th>Closed By</th>
                            <th>Closed Date</th>
                            <th>Payment Status</th>
                            <th>Payment Method</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                          $no=1;
                          @endphp
                          @foreach ($payment as $data)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#imagePayment{{ $data->id }}">
                                    Show
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="imagePayment{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Payment File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            @if (isset($data->payment_file))
                                                <img src="data:image/png;base64, {{$data->payment_file}}" />
                                            @else
                                                <img src="{{ asset('img/image_not_available.png') }}" class="img-fluid" alt="">
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                            </td>
                            <td>
                                @if($data->closed_by)
                                <div class="text-primary">
                                    <b><i>{{ $data->closed_by }}</i></b>
                                </div>
                                @else
                                <div class="text-secondary">
                                    <b><i>-</i></b>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($data->closed_date)
                                <div class="text-primary">
                                    <b><i>{{ $data->closed_date }}</i></b>
                                </div>
                                @else
                                <div class="text-secondary">
                                    <b><i>-</i></b>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($data->payment_status == '0')
                                <div class="text-secondary">
                                    <b><i>waiting for payment</i></b>
                                </div>
                                @elseif($data->payment_status == '1')
                                <div class="text-primary">
                                    <b><i>payment reviewed</i></b>
                                </div>
                                @elseif($data->payment_status == '2')
                                <div class="text-secondary">
                                    <b><i>refund</i></b>
                                </div>
                                <span class="badge badge-primary">refund</span>
                                @elseif($data->payment_status == '3')
                                <div class="text-danger">
                                    <b><i>canceled</i></b>
                                </div>
                                @elseif($data->payment_status == '4')
                                <div class="text-success">
                                    <b><i>success</i></b>
                                </div>
                                @else
                                <div class="text-secondary">
                                    <b><i>N/A</i></b>
                                </div>
                                @endif
                            </td>
                            <td>{{ $data->payment_method }}</td>
                            <td>
                                @if($data->payment_status == 1)
                                <button title="Accept Payment" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-accept{{ $data->id }}">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button title="Refund Payment" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-refund{{ $data->id }}">
                                    <i class="fas fa-undo"></i>
                                </button>
                                @else
                                {{-- <button title="Accept Payment" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-accept{{ $data->id }}" disabled >
                                    <i class="fas fa-check"></i>
                                </button>

                                <button title="Refund Payment" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-refund{{ $data->id }}" disabled >
                                    <i class="fas fa-undo"></i> --}}
                                </button>
                                @endif

                                {{-- Modal Accept Payment --}}
                                <div class="modal fade" id="modal-accept{{ $data->id }}" tabindex="-1" aria-labelledby="modal-accept{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modal-accept{{ $data->id }}-label">Accept Payment</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('transaction/accept-payment/'.$data->id) }}" method="POST">
                                        @csrf
                                        @method('post')
                                        <input type="hidden" name="id" id="id" value="{{ $data->payment_id }}">
                                        <input type="hidden" name="id_transaction_header" id="id_transaction_header" value="{{ $data->id_transaction_header }}">
                                        <div class="modal-body">
                                            <div class="form-group">
                                            Are you sure you want to accept payment ?
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <span><b>Notes</b></span>  <br/>
                                                </div>
                                                <div class="col-md-9">
                                                <textarea class="form-control" name="notes" id="notes" cols="30" rows="2" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                {{-- Modal Accept Payment --}}

                                {{-- Modal Refund Payment --}}
                                <div class="modal fade" id="modal-refund{{ $data->id }}" tabindex="-1" aria-labelledby="modal-refund{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="modal-refund{{ $data->id }}-label">Refund Payment</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('transaction/refund-payment/'.$data->id) }}" method="POST">
                                        @csrf
                                        @method('post')
                                        <input type="hidden" name="id" id="id" value="{{ $data->payment_id }}">
                                        <input type="hidden" name="id_transaction_header" id="id_transaction_header" value="{{ $data->id_transaction_header }}">
                                        <div class="modal-body">
                                            <div class="form-group">
                                            Are you sure you want to refund payment ?
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <span><b>Notes</b></span>  <br/>
                                                </div>
                                                <div class="col-md-9">
                                                <textarea class="form-control" name="notes" id="notes" cols="30" rows="2" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                {{-- Modal Refund Payment --}}
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
      var table = $("#tablePayment").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>
@endsection
