@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            Event Detail
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header p-2 d-flex justify-content-between align-items-center">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-detailEvent-tab" data-bs-toggle="pill" data-bs-target="#pills-detailEvent" type="button" role="tab" aria-controls="pills-detailEvent" aria-selected="true">Detail Event</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-tCategory-tab" data-bs-toggle="pill" data-bs-target="#pills-tCategory" type="button" role="tab" aria-controls="pills-tCategory" aria-selected="false">Ticket Category</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-tPayment-tab" data-bs-toggle="pill" data-bs-target="#pills-tPayment" type="button" role="tab" aria-controls="pills-tPayment" aria-selected="false">Ticket Payment</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-showTime-tab" data-bs-toggle="pill" data-bs-target="#pills-showTime" type="button" role="tab" aria-controls="pills-showTime" aria-selected="false">Show Time</button>
                      </li>
                  </ul>
                @if ($event->is_active == '1')
                <small class="badge bg-success">Active</small>
                @else
                <small class="badge bg-danger">Inactive</small>
                @endif
            </div><!-- /.card-header -->
            {{-- <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Detail of Event {{$event->event_name}}</h3>
               
                
            </div> --}}
            
            <div class="card-body">

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-detailEvent" role="tabpanel" aria-labelledby="pills-detailEvent-tab">
                       
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Event Category</strong>
                                    <p>{{$event->event_category}}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Event Highlight</strong>
                                    <p>{{$event->highlight}}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Event Description</strong>
                                    <p>{{$event->description}}</p>
                                </div>
                            </div>
                            <hr>
                            <h3><strong>Event Location</strong></h3>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <strong>Provinsi</strong>
                                    <p>{{$event->province}}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>City</strong>
                                    <p>{{$event->city}}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>District</strong>
                                    <p>{{$event->district}}</p>
                                </div>
                                <div class="col-md-3">
                                    <strong>Sub District</strong>
                                    <p>{{$event->sub_district}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <strong>Address</strong>
                                    <p>{{$event->event_address}}</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Zip Code</strong>
                                    <p>{{$event->zip_code}}</p>
                                </div>
                            </div>
            
                            <hr>
                            <h3><strong>Event Info</strong></h3>
                            <hr>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>exchange_ticket_info</strong>
                                    <p>{{$event->exchange_ticket_info}}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>tc_info</strong>
                                    <p>{{$event->tc_info}}</p>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>including_info</strong>
                                    <p>{{$event->including_info}}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>excluding_info</strong>
                                    <p>{{$event->excluding_info}}</p>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>facility</strong>
                                    <p>{{$event->facility}}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>attach_venue</strong>
                                    <p>{{$event->attach_venue}}</p>
                                </div>
                            </div>
                      
                    </div>
                    <div class="tab-pane fade" id="pills-tCategory" role="tabpanel" aria-labelledby="pills-tCategory-tab">
                        <div class="table-responsive">
                            <table id="tableTicketCategory" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Price</th>
                                {{-- <th>Action</th> --}}
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
                                    {{-- <td>
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
                                         
                                    </td> --}}
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
                    <div class="tab-pane fade" id="pills-tPayment" role="tabpanel" aria-labelledby="pills-tPayment-tab">
                        <div class="table-responsive"> 
                            <table id="tablePaymentTicket" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                                <th>No</th>
                                <th>Payment Method</th>
                                <th>Bank Name</th>
                                <th>Account Info</th>
                                {{-- <th>Action</th> --}}
                              </tr>
                              </thead>
                              <tbody>
                                @php
                                  $no=1;
                                @endphp
                                @foreach ($ticketPayment as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->payment_method }}</td>
                                    <td>{{ $data->bank_name }}</td>
                                    <td><strong>{{$data->account_name}}</strong><br>
                                       <i>({{ $data->account_number }})</i></td>
                                    {{-- <td>
                                        <button title="Edit Rule" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                            <i class="fas fa-edit"></i>
                                          </button>
                                        <button title="Delete Rule" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                          </button>   
                                    </td> --}}
                                </tr>
            
                                {{-- Modal Update --}}
                                <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title" id="modal-update{{ $data->id_event }}-label">Edit Ticket Payment</h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('ticket-payment/edit/'.$data->id_event) }}" method="POST">
                                          @csrf
                                          @method('patch')
                                          <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" value="{{ $data->id}}" hidden>
                                                <select class="form-control" name="payment_method" id="payment_method" required>
                                                    <option class="text-center" value="{{$data->payment_method}}" selected>{{$data->payment_method}}</option>
                                                    <option class="text-center" value="VVIP" >VVIP</option>
                                                    <option class="text-center" value="Reguler" >Reguler</option>
                                                    {{-- @foreach ($provinces as $province)
                                                    <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <select class="form-control" name="bank_name" id="bank_name" required>
                                                    <option class="text-center" value="{{$data->bank_name}}" selected>{{$data->bank_name}}</option>
                                                    <option class="text-center" value="1" >True</option>
                                                    <option class="text-center" value="2" >False</option>
                                                    {{-- @foreach ($provinces as $province)
                                                    <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <input type="number" class="form-control" id="account_number" name="account_number" placeholder="Enter Account Number" value="{{$data->account_number}}" required>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Account Name" value="{{$data->account_name}}" required>
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
                                        <form action="{{ url('ticket-payment/destroy/'.$data->id_event) }}" method="POST">
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
                    <div class="tab-pane fade" id="pills-showTime" role="tabpanel" aria-labelledby="pills-showTime-tab">
                        <div class="table-responsive"> 
                            <table id="tableShowTime" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                                <th>No</th>
                                <th>Show Time Start</th>
                                <th>Show Time Finish</th>
                                {{-- <th>Action</th> --}}
                              </tr>
                              </thead>
                              <tbody>
                                @php
                                  $no=1;
                                @endphp
                                @foreach ($showTime as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->showtime_start }}</td>
                                    <td>{{ $data->showtime_finish }}</td>
                                    {{-- <td>
                                        <button title="Edit Rule" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                            <i class="fas fa-edit"></i>
                                          </button>
                                        <button title="Delete Rule" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                          </button>   
                                    </td> --}}
                                </tr>
            
                                {{-- Modal Update --}}
                                <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title" id="modal-update{{ $data->id_event }}-label">Edit Show Time</h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('show-time/edit/'.$data->id_event) }}" method="POST">
                                          @csrf
                                          @method('patch')
                                          <div class="modal-body">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Start Show</label>
                                                    <input type="datetime-local" class="form-control" id="showtime_start" name="showtime_start" value="{{$data->showtime_start}}"  required>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label for="">Finish Show</label>
                                                    <input type="datetime-local" class="form-control" id="showtime_finish" name="showtime_finish" value="{{$data->showtime_finish}}"  required>
                                                </div>
                                                
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
                                        <form action="{{ url('show-time/destroy/'.$data->id_event) }}" method="POST">
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
                  </div>
                  

            </div>
        </div>

    </div>
</main>
@endsection