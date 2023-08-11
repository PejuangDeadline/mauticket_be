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
                                    <h3 class="card-title">List of Referral Code</h3>
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
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modal-add-label">Add Referral Code</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url('/ref-code/store') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <input class="form-control" id="ref_code" name="ref_code" type="text" placeholder="Input Code" />
                                                                </div>
                                                                {{-- <div class="mb-3">
                                        <select class="form-control" name="ref_type" id="ref_type">
                                            <option class="text-center" value="" selected>- Select Referral Type -</option>
                                            @foreach ($refTypes as $refType)
                                            <option class="text-center" value="{{ $refType['name_value'] }}">{{ $refType['name_value'] }}</option>
                                                                @endforeach
                                                                </select>
                                                        </div> --}}
                                                        <div class="mb-3">
                                                            <input class="form-control" id="ref_value" name="ref_value" type="text" placeholder="Input Value Ref Code in Percentage" />
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
                                        <table id="tablePartner" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Code</th>
                                                    <th>Type</th>
                                                    <th>Value</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no=1;
                                                @endphp
                                                @foreach ($refCodes as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $data->code }}</td>
                                                    <td>{{ $data->type }}</td>
                                                    <td>{{ $data->value }}</td>
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
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-add-user{{ $data->id }}" href="#"><i class="fas fa-plus"></i> Add User</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->id }}" href="#"><i class="fas fa-edit"></i> Edit Partner</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-showContract{{ $data->id }}" href="#"><i class="fas fa-eye"></i> Show Contract</a>
                                                                </li>
                                                                <li>
                                                                    @if ($data->start_date == null)
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-addContract{{ $data->id }}" href="#"><i class="fas fa-plus"></i> Add Contract</a>
                                                                    @else
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-editContract{{ $data->id }}" href="#"><i class="fas fa-calendar-alt"></i> Edit Contract</a>
                                                                    @endif
                                                                </li>
                                                                <li>
                                                                    @if ($data->is_active == '0')
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-active{{ $data->id }}" href="#"><i class="fas fa-check"></i> Activate Partner</a>
                                                                    @else
                                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-inactive{{ $data->id }}" href="#"><i class="fas fa-times"></i> Inactive Partner</a>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                        </div>
                                    </div>
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
<!-- For Datatables -->
<script>
    $(document).ready(function() {
        var table = $("#tablePartner").DataTable({
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
    $(document).ready(function() {
        $('select[name="province_by_id"]').on('change', function() {
            var provinceID = $(this).val();
            var url = '{{ route("mappingCity", ":id") }}';
            // console.log(url);
            url = url.replace(':id', provinceID);
            // alert(url);
            if (provinceID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').append(
                            '<option class="text-center" value="">- Select City -</option>'
                        );
                        $.each(data, function(province, value) {
                            $('select[name="city"]').append(
                                '<option class="text-center" value="' + value.id + '">' + value.nama + '</option>'
                            );
                        });

                    }
                });
            } else {
                $('select[name="city"]').empty('<option class="text-center" value="">- Select City -</option>');
            }
        });

    });
</script>
<script type="text/javascript">
    //ajax mapping district
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('select[name="city"]').on('change', function() {
            var cityID = $(this).val();
            var url = '{{ route("mappingDistrict", ":id") }}';
            url = url.replace(':id', cityID);
            // alert(url);
            if (cityID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        $('select[name="district"]').empty();
                        $('select[name="district"]').append(
                            '<option class="text-center" value="">- Select District -</option>'
                        );
                        $.each(data, function(city, value) {
                            $('select[name="district"]').append(
                                '<option class="text-center" value="' + value.id + '">' + value.nama + '</option>'
                            );
                        });

                    }
                });
            } else {
                $('select[name="district"]').empty('<option class="text-center" value="">- Select District -</option>');
            }
        });

    });
</script>
<script type="text/javascript">
    // ajax mapping subdistric
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('select[name="district"]').on('change', function() {
            var districtID = $(this).val();
            var url = '{{ route("mappingSubDistrict", ":id") }}';
            url = url.replace(':id', districtID);

            if (districtID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        $('select[name="subdistrict"]').empty();
                        $('select[name="subdistrict"]').append(
                            '<option class="text-center" value="">- Select Subdistrict -</option>'
                        );
                        $.each(data, function(district, value) {
                            $('select[name="subdistrict"]').append(
                                '<option class="text-center" value="' + value.id + '">' + value.nama + '</option>'
                            );
                        });

                    }
                });
            } else {
                $('select[name="subdistrict"]').empty('<option class="text-center" value="">- Select Subdistrict -</option>');
            }
        });

    });
</script>

<script type="text/javascript">
    //ajax mapping postal code
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('select[name="subdistrict"]').on('change', function() {
            var subdistrictID = $(this).val();
            var url = '{{ route("mappingZipcode", ":id") }}';
            url = url.replace(':id', subdistrictID);

            if (subdistrictID) {
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(subdistrict, value) {
                            $('#zip_code').val(value.kodepos);
                        });
                    }
                });
            } else {
                $('#zip_code').val("");
            }

        });

    });
</script>

@endsection