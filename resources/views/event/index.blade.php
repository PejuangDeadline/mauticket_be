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
              <div class="card-header  p-2 d-flex justify-content-between align-items-center">
                <h3 class="card-title">List of Event</h3>
                @if ($getPartner->is_active == '0')
                <small class="badge bg-danger">Inactive</small>
                @endif
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                        @if ($getPartner->is_active == '1')
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i>
                          </button>
                        @endif
                       

                          <!-- Modal -->
                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-add-label">Add Event</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <form action="{{ url('/event/store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div hidden>
                                            <input class="form-control" id="created_by" name="created_by" value="{{auth()->user()->email}}"/>
                                            <input class="form-control" id="is_active" name="is_active" value="1"/>
                                            <input class="form-control" id="id_partner" name="id_partner" value="{{$getPartner->id}}"/>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <select name="event_category" id="event_category" class="form-control" required>
                                                    <option class="text-center" value="">Select Event Category</option>
                                                    @foreach ($getEventCategory as $item)
                                                    <option class="text-center" value="{{$item->name_value}}">{{$item->name_value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control" id="event_name" name="event_name" type="text" placeholder="Input Event Name"/>
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control" id="highlight" name="highlight" type="text" placeholder="Input Highlight"/>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Description</b></label>
                                            <textarea class="form-control" id="description" name="description" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="row mb-3" align="left">
                                            <div class="col-md-3">
                                                <span><b>Provinsi</b></span>  <br/>
                                                <small class="text-muted" style="font-style: italic;">Province</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" name="province_by_id" id="province_by_id">
                                                    <option class="text-center" value="" selected>- Select Province -</option>
                                                    @foreach ($provinces as $province)
                                                    <option class="text-center" value="{{ $province['id'] }}">{{ $province['nama'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @csrf
                                            <div class="col-md-3">
                                                <span><b>Kota</b></span>  <br/>
                                                <small class="text-muted" style="font-style: italic;">City</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select name="city" id="city" class="form-control" required>
                                                    <option class="text-center" value="">- Select City -</option>
                                                </select>
                                            </div>
                                        </div>
                                        @csrf
                                        <div class="row mb-3" align="left">
                                            <div class="col-md-3">
                                                <span><b>Kecamatan</b></span>  <br/>
                                                <small class="text-muted" style="font-style: italic;">District</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select id="district" name="district" class="form-control">
                                                    <option class="text-center" value="">- Select District -</option>
                                                </select>
                                            </div>
                                            @csrf
                                            <div class="col-md-3">
                                                <span><b>Kelurahan</b></span>  <br/>
                                                <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                                            </div>
                                            <div class="col-md-3">
                                                <select id="subdistrict" name="subdistrict" class="form-control">
                                                    <option class="text-center" value="">- Select Subdistrict -</option>
                                                </select>
                                            </div>
                                        </div>
                                        @csrf
                                        <div class="row mb-3" align="left">
                                            <div class="col-md-3">
                                                <span><b>Kode Pos</b></span>  <br/>
                                                <small class="text-muted" style="font-style: italic;">Postal Code</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="zip_code" name="zip_code" class="form-control text-center" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label><b>Address</b></label>
                                            <textarea class="form-control" id="event_address" name="event_address" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Exchange Ticket Info</b></label>
                                            <textarea class="form-control" id="exchange_ticket_info" name="exchange_ticket_info" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>TC Info</b></label>
                                            <textarea class="form-control" id="tc_info" name="tc_info" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Including Info</b></label>
                                            <textarea class="form-control" id="including_info" name="including_info" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Excluding Info</b></label>
                                            <textarea class="form-control" id="excluding_info" name="excluding_info" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label><b>Facility</b></label>
                                            <textarea class="form-control" id="facility" name="facility" cols="30" rows="3" placeholder=""></textarea>
                                        </div>
                              </div>
                              <div class="modal-footer">
                                  <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                  <button class="btn btn-primary" type="submit">Save</button>
                              </div>
                              </form>
                              </div>
                            </div>
                          </div>

                    <div class="col-sm-12">
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
                </div>
                <div class="table-responsive">
                <table id="tableEvent" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Event Name</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                      $no=1;
                    @endphp
                    @foreach ($event as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><strong>{{ $data->event_name }}</strong><br>
                            <i>({{ $data->event_category }})</i>
                        </td>
                        <td>
                            <strong>{{ $data->province }},</strong>
                            <i>{{$data->city}},{{$data->district}},{{$data->sub_district}}</i>
                             <p>{{$data->partner_addr}}</p>

                        </td>
                        <td>
                            @if ($data->is_active == '1')
                                <div class="text-success">
                                    <b><i>Active</i></b>
                                </div>
                            @else
                                <div class="text-danger">
                                    <b><i>Inactive</i></b>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($getPartner->is_active == '1')
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                  </button>
                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="{{ url('event/detail/'.encrypt($data->id) ) }}"><i class="fas fa-info-circle"></i> Detail</a></li>
                                    <li>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}">
                                            <i class="fas fa-edit"></i> Edit Detail
                                        </a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('ticket-category/'.encrypt($data->id) ) }}"><i class="fas fa-plus"></i> Ticket Categories</a></li>
                                    <li><a class="dropdown-item" href="{{ url('ticket-payment/'.encrypt($data->id) ) }}"><i class="fas fa-plus"></i> Ticket Payment</a></li>
                                    <li><a class="dropdown-item" href="{{ url('show-time/'.encrypt($data->id) ) }}"><i class="fas fa-plus"></i> Showtimes</a></li>
                                    <li>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                            <i class="fas fa-trash-alt"></i>Delete
                                        </a>
                                    </li>
                                </ul>
                               </div>
                            @endif
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="modal-update{{ $data->id }}-label">Edit Partner</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('/event/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div hidden>
                                    <input class="form-control" id="created_by" name="created_by" value="{{auth()->user()->email}}"/>
                                    <input class="form-control" id="is_active" name="is_active" value="1"/>
                                    <input class="form-control" id="id_partner" name="id_partner" value="{{$data->id_partner}}"/>
                                </div>
                                <div class="row mb-3">
                                  
                                    <div class="col-md-12">
                                        <select name="event_category" id="event_category" class="form-control">
                                            <option class="text-center" value="{{ $data->event_category }}">{{ $data->event_category }}</option>
                                            @foreach ($getEventCategory as $item)
                                            <option class="text-center" value="{{$item->name_value}}" {{ $item->name_value == $data->event_category ? 'selected' : '' }}>{{$item->name_value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" id="event_name" name="event_name" type="text" placeholder="Input Event Name" value="{{$data->event_name}}"/>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" id="highlight" name="highlight" type="text" placeholder="Input Highlight" value="{{$data->highlight}}"/>
                                </div>
                                <div class="mb-3">
                                    <label><b>Description</b></label>
                                    <textarea class="form-control" id="description" name="description" cols="30" rows="3" placeholder="">{{$data->description}}</textarea>
                                </div>
                                <div class="row mb-3" align="left">
                                    <div class="col-md-3">
                                        <span><b>Provinsi</b></span>  <br/>
                                        <small class="text-muted" style="font-style: italic;">Province</small>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="province_by_id" id="province_by_id">
                                            <option class="text-center" value="{{$data->province}}" selected>{{$data->province}}</option>
                                            @foreach ($provinces as $province)
                                            <option class="text-center" value="{{ $province['id'] }}" {{ $province['nama'] == $data->province ? 'selected' : '' }}>{{ $province['nama'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @csrf
                                    <div class="col-md-3">
                                        <span><b>Kota</b></span>  <br/>
                                        <small class="text-muted" style="font-style: italic;">City</small>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="city" id="city" class="form-control" required>
                                            <option class="text-center" value="{{$data->city}}">{{$data->city}}</option>
                                        </select>
                                    </div>
                                </div>
                                @csrf
                                <div class="row mb-3" align="left">
                                    <div class="col-md-3">
                                        <span><b>Kecamatan</b></span>  <br/>
                                        <small class="text-muted" style="font-style: italic;">District</small>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="district" name="district" class="form-control">
                                            <option class="text-center" value="{{$data->district}}">{{$data->district}}</option>
                                        </select>
                                    </div>
                                    @csrf
                                    <div class="col-md-3">
                                        <span><b>Kelurahan</b></span>  <br/>
                                        <small class="text-muted" style="font-style: italic;">Subdistrict</small>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="subdistrict" name="subdistrict" class="form-control">
                                            <option class="text-center" value="{{$data->sub_district}}">{{$data->sub_district}}</option>
                                        </select>
                                    </div>
                                </div>
                                @csrf
                                <div class="row mb-3" align="left">
                                    <div class="col-md-3">
                                        <span><b>Kode Pos</b></span>  <br/>
                                        <small class="text-muted" style="font-style: italic;">Postal Code</small>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="zip_code" name="zip_code" class="form-control text-center" value="{{$data->zip_code}}" autocomplete="off">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label><b>Address</b></label>
                                    <textarea class="form-control" id="event_address" name="event_address" cols="30" rows="3" placeholder="">{{$data->event_address}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label><b>Exchange Ticket Info</b></label>
                                    <textarea class="form-control" id="exchange_ticket_info" name="exchange_ticket_info" cols="30" rows="3" placeholder="">{{$data->exchange_ticket_info}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label><b>TC Info</b></label>
                                    <textarea class="form-control" id="tc_info" name="tc_info" cols="30" rows="3" placeholder="">{{$data->tc_info}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label><b>Including Info</b></label>
                                    <textarea class="form-control" id="including_info" name="including_info" cols="30" rows="3" placeholder="">{{$data->including_info}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label><b>Excluding Info</b></label>
                                    <textarea class="form-control" id="excluding_info" name="excluding_info" cols="30" rows="3" placeholder="">{{$data->excluding_info}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label><b>Facility</b></label>
                                    <textarea class="form-control" id="facility" name="facility" cols="30" rows="3" placeholder="">{{$data->facility}}</textarea>
                                </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit">Save</button>
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
                            <h4 class="modal-title" id="modal-delete{{ $data->id }}-label">Delete Event</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/event/destroy/'.$data->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <div class="modal-body">
                                <div class="form-group">
                                Are you sure you want to delete <label for="partner">{{ $data->event_name }}</label>?
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

                    {{--Modal Add Contract --}}
                    <div class="modal fade" id="modal-addContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-addContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-addContract{{ $data->id }}-label">Add Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/contract') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input hidden value="{{$data->id}}" class="form-control" id="id_partner" name="id_partner"/>
                                    </div>
                                  <div class="form-group">
                                    <label for="date-from">From</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label for="date-to">To</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
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
                    {{--Modal Add Contract --}}

                     {{--Modal Edit Contract --}}
                     <div class="modal fade" id="modal-editContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-editContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-editContract{{ $data->id }}-label">Edit Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/contract/update') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id_partner" id="id_partner" value="{{$data->id_partner}}" hidden>
                                  <div class="form-group">
                                    <label for="date-from">From</label>
                                    <input value="{{\Carbon\Carbon::parse($data->start_date)->format('Y-m-d')}}" type="date" class="form-control" id="start_date" name="start_date" required>
                                  </div>
                                  <br>
                                  <div class="form-group">
                                    <label for="date-to">To</label>
                                    <input value="{{\Carbon\Carbon::parse($data->end_date)->format('Y-m-d')}}" type="date" class="form-control" id="end_date" name="end_date" required>
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
                    {{--Modal Add Contract --}}


                    {{-- Modal Show --}}
                    <div class="modal fade" id="modal-showContract{{ $data->id }}" tabindex="-1" aria-labelledby="modal-showContract{{ $data->id }}-label" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="modal-showContract{{ $data->id }}-label">Show Contract</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/'.$data->id) }}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="date-from">From</label>
                                    <p  class="form-control">{{\Carbon\Carbon::parse($data->start_date)->format('Y-m-d')}}</p>
                                    <label for="date-from">To</label>
                                    <p  class="form-control">{{\Carbon\Carbon::parse($data->end_date)->format('Y-m-d')}}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tableEvent").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>

<script type="text/javascript">
    //ajax mapping city
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="province_by_id"]').on('change', function() {
                        var provinceID = $(this).val();
                        var url = '{{ route("mappingCity", ":id") }}';
                        // console.log(url);
                        url = url.replace(':id', provinceID);
                        // alert(url);
                        if(provinceID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    $('select[name="city"]').empty();
                                    $('select[name="city"]').append(
                                            '<option class="text-center" value="">- Select City -</option>'
                                    );
                                    $.each(data, function(province, value) {
                                        $('select[name="city"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="city"]').empty('<option class="text-center" value="">- Select City -</option>');
                        }
                    });

            });
</script>
<script type="text/javascript">
    //ajax mapping district
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="city"]').on('change', function() {
                        var cityID = $(this).val();
                        var url = '{{ route("mappingDistrict", ":id") }}';
                        url = url.replace(':id', cityID);
                        // alert(url);
                        if(cityID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {

                                    $('select[name="district"]').empty();
                                    $('select[name="district"]').append(
                                            '<option class="text-center" value="">- Select District -</option>'
                                    );
                                    $.each(data, function(city, value) {
                                        $('select[name="district"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="district"]').empty('<option class="text-center" value="">- Select District -</option>');
                        }
                    });

            });
</script>
<script type="text/javascript">
    // ajax mapping subdistric
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="district"]').on('change', function() {
                        var districtID = $(this).val();
                        var url = '{{ route("mappingSubDistrict", ":id") }}';
                        url = url.replace(':id', districtID);

                        if(districtID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {

                                    $('select[name="subdistrict"]').empty();
                                    $('select[name="subdistrict"]').append(
                                            '<option class="text-center" value="">- Select Subdistrict -</option>'
                                    );
                                    $.each(data, function(district, value) {
                                        $('select[name="subdistrict"]').append(
                                            '<option class="text-center" value="'+ value.id +'">'+ value.nama +'</option>'
                                        );
                                    });

                                }
                            });
                        }else{
                            $('select[name="subdistrict"]').empty('<option class="text-center" value="">- Select Subdistrict -</option>');
                        }
                    });

            });
</script>

<script type="text/javascript">
    //ajax mapping postal code
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).ready(function () {
                $('select[name="subdistrict"]').on('change', function() {
                        var subdistrictID = $(this).val();
                        var url = '{{ route("mappingZipcode", ":id") }}';
                        url = url.replace(':id', subdistrictID);

                        if(subdistrictID) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                dataType: "json",
                                success:function(data) {
                                    $.each(data, function(subdistrict, value) {
                                        $('#zip_code').val(value.kodepos);
                                    });
                                }
                            });
                        }else{
                            $('#zip_code').val("");
                        }

                    });

            });
</script>

@endsection
