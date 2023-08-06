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
                          <button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-include">
                            Input Seat
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
                                        <div class="form-group">
                                          <label class="mb-3" for="">Input Category</label>
                                          <textarea class="form-control" id="category" name="category" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                          <label class="mb-3" for="">Include Seat?</label>
                                          <br>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioOptions" id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                          </div>
                                        </div>
                                        
                                        <br>
                                        <div class="form-group">
                                            <input type="text" class="form-control rupiah-input" id="price" name="price" placeholder="Enter Price" required>
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

                          {{-- modal include --}}
                           
                          <!-- Modal -->
                          <div class="modal fade" id="modal-include" tabindex="-1" aria-labelledby="modal-include-label" aria-hidden="true">
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
                        <td>{{ $data->price }}</td>
                        <td>
                            <button title="Edit Rule" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id_event }}">
                                <i class="fas fa-edit"></i>
                              </button>
                            <button title="Delete Rule" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id_event }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>   
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="modal-update{{ $data->id_event }}-label">Edit Rule</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('ticket-category/edit/'.$data->id_event) }}" method="POST">
                              @csrf
                              @method('patch')
                              <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="id" value="{{$data->id}}" hidden>
                                    <select class="form-control" name="category" id="category">
                                        <option class="text-center" value="{{$data->category}}" selected>{{$data->category}}</option>
                                        {{-- @foreach ($provinces as $province)
                                        <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <br>
                                <select class="form-control" name="inc_seat" id="inc_seat">
                                    <option class="text-center" value="{{$data->inc_seat}}" selected>{{$data->inc_seat}}</option>
                                    <option class="text-center" value="1" selected>True</option>
                                    <option class="text-center" value="2" selected>False</option>
                                    {{-- @foreach ($provinces as $province)
                                    <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                    @endforeach --}}
                                </select>
                                <br>
                                <div class="form-group">
                                    <input value="{{$data->price}}" type="text" class="form-control rupiah-input" id="price" name="price" placeholder="Enter Price" required>
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
                            <h4 class="modal-title" id="modal-delete{{ $data->id_event }}-label">Delete Rule</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('ticket-category/destroy/'.$data->id_event) }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" hidden value="{{$data->id}}">
                            <div class="modal-body">
                                <div class="form-group">
                                Are you sure you want to delete <label for="rule">{{ $data->rule_name }}</label>?
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
    });
  </script>
@endsection