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
              <div class="card-header">
                <h3 class="card-title">List of Ticket Category <i>({{$event->event_name}})</i></h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i>
                          </button>
                          
                          <!-- Modal -->
                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-add-label">Add Ticket Category</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('ticket-category/store/'.$id) }}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                    <div hidden>
                                        <input class="form-control" id="id_event" name="id_event" value="{{$id}}"/>
                                    </div>
                                        <div class="form-group">
    
                                          <input class="form-control" id="category" name="category" cols="30" rows="3" placeholder="Enter Category">
                                        </div>
                                        <br>
                                        <div class="form-group">
                                          <label class="mb-3" for="">Include Seat?</label>
                                          <br>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inc_seat" id="inlineRadio1" value="1">
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inc_seat" id="inlineRadio2" value="0">
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                          </div>
                                        </div>
                                        
                                        <br>
                                        <div class="form-group">
                                            <input type="text" id="price" name="price" class="form-control" autocomplete="off" placeholder="Enter Price">
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
                <table id="tableTicketCategory" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($ticketCategory as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->category }}</td>
                        <td>Rp. {{ number_format($data->price) }}</td>
                        <td>
                            <button title="Edit Ticket Category" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                <i class="fas fa-edit"></i>
                              </button>
                            <button title="Delete Ticket Category" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                              @if ($data->inc_seat == 1)
                              <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-include{{ $data->id }}">
                                Upload Seat
                              </button>
                              @endif
                             
                        </td>
                    </tr>

                     {{-- modal include --}}

                          <!-- Modal -->
                          <div class="modal fade" id="modal-include{{ $data->id }}" tabindex="-1" aria-labelledby="modal-include{{ $data->id }}-label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-include-label">Upload Seat</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('ticket-category/store/'.$id) }}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                        <div class="form-group">
                                            <input type="file" class="form-control rupiah-input" id="price" name="price" placeholder="Enter Price" required>
                                        </div>
                                        <div class="form-group">
                                          <a href="#">Download Template Here</a>
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

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="modal-update{{ $data->id }}-label">Edit Ticket Category</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('ticket-category/edit/'.$data->id) }}" method="POST">
                              @csrf
                              @method('patch')
                              <div class="modal-body">

                                <div hidden>
                                  <input type="text" name="id_event" value="{{$data->id_event}}" hidden>
                              </div>
                                  <div class="form-group">
                                    <input class="form-control" id="category" name="category" cols="30" rows="3" value="{{$data->category}}" placeholder="{{$data->category}}">
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label class="mb-3" for="">Include Seat?</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="inc_seat" id="inlineRadio1" value="1" @if ($data->inc_seat == 1) checked @endif>
                                      <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="inc_seat" id="inlineRadio2" value="0" @if ($data->inc_seat == 0) checked @endif>
                                      <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <input type="text" id="price" name="price" class="form-control" value="{{ old('',number_format($data->price)) }}" autocomplete="off">
                                  </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    {{-- Modal Update --}}

                    {{-- Modal Delete --}}
                    <div class="modal fade" id="modal-delete{{ $data->id }}" tabindex="-1" aria-labelledby="modal-delete{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-delete{{ $data->id }}-label">Delete Ticket Category</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('ticket-category/destroy/'.$data->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" name="id_event" hidden value="{{$data->id_event}}">
                            <div class="modal-body">
                                <div class="form-group">
                                Are you sure you want to delete <label for="rule">{{ $data->category }}</label>?
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
                    {{-- Modal Delete --}}

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
    // Function to format the price in rupiah format
    function formatRupiah(amount) {
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        });
        return formatter.format(amount);
    }

    // Function to remove non-numeric characters from the input
    function removeNonNumeric(input) {
        return input.replace(/\D/g, '');
    }

    // Function to handle price input
    function handlePriceInput(event) {
        const input = event.target;
        const value = removeNonNumeric(input.value);
        const formattedValue = formatRupiah(value);

        input.value = formattedValue;
    }

    // Attach event listener to all elements with the class "rupiah-input"
    const rupiahInputs = document.querySelectorAll('.rupiah-input');
    rupiahInputs.forEach((input) => {
        input.addEventListener('input', handlePriceInput);
    });


</script>

<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tableTicketCategory").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
      var price = document.getElementById('price');

        price.addEventListener('keyup',function(e){
            price.value = formatCurrency(this.value,' ');
        });

    function formatCurrency(number,prefix)
        {
            var number_string = number.replace(/[^.\d]/g, '').toString(),
                split	= number_string.split('.'),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? ',' : '';
                rupiah += separator + ribuan.join(',');
            }

            rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    });
  </script>
@endsection
