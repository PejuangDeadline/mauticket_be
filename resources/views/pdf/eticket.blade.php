<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <title>Mau Karcis</title>
</head>
<body>
    <style>
        /* Add your CSS styles here */
        .logo {
            max-width: 30%; /* Set the maximum width to 30% of the container */
            height: auto; /* Automatically adjust the height to maintain aspect ratio */
            display: block; /* Remove any extra space around the image */
            margin: 0 auto; /* Center the image horizontally */
        }
        .align-left {
            float: left; /* Float the image to the left */
            margin-right: 20px; /* Add some margin to separate the image from text */
        }
        table {
            width: 100%; /* Make the table take up the full width of the container */
            margin-bottom: 20px; /* Add some spacing between tables */
        }
        th, td {
            padding: 10px; /* Add padding to table cells */
            border: 1px solid #ccc; /* Add border to table cells */
        }
        th {
            background-color: #f2f2f2; /* Add background color to table headers */
        }
        .text-right {
            text-align: right; /* Align text to the right */
        }
    </style>
    <div class="row">
        <div class="col-md-6">
            <img src="{{ public_path('assets/img/Logo Option 3 (1).png') }}" alt="Logo MauKarcis" class="logo align-left">
            <div style="clear: both;"></div> 
            <p>Order Id : {{ $eventInfo->no_transaction }}</p>
        </div>
        <div class="col-md-6 text-right">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate($eventInfo->no_transaction)) !!} ">
        </div>
    </div>
    
    <h2>{{ $eventInfo->event_name }}</h2>
    <p>{{ $eventInfo->showtime_start }} - {{ $eventInfo->ticket_category }}</p>
    
    <table>
        <tr>
            <th colspan="2">Detail Pemesan</th>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $eventInfo->firstname }} {{$eventInfo->lastname}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $eventInfo->email }}</td>
        </tr>
        <tr>
            <th>Nomor Telepon</th>
            <td>{{ $eventInfo->phonenumber }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th>Info Penukaran</th>
        </tr>
        <tr>
            <td>{!! $eventInfo->exchange_ticket_info !!}</td>
        </tr>
    </table>
    
    <table>
        <tr>
            <th colspan="4" >Info Penting</th>
        </tr>
        <tr>
            <td>{!! $eventInfo->tc_info !!}</td>
            <td>{!! $eventInfo->including_info !!}</td>
            <td>{!! $eventInfo->excluding_info !!}</td>
            <td>{!! $eventInfo->facility !!}</td>
        </tr>
    </table>
    
    <table>
        <tr>
            <th>Lainnya</th>
        </tr>
        <tr>
            <td>Transaksi maukarcis.com yang resmi hanya dilakukan melalui website. Kami tidak bertanggungjawab atas transaksi yang terjadi diluar website</td>
        </tr>
        <tr>
            <td>Maukarcis.com berperan sebagai agen penjualan karcis yang hanya bertanggungjawab terhadap penjualan karcis, jika terjadi hal-hal yang timbul diluar penjualan karcis merupakan tanggungjawab antara pembeli dan promotor acara atau penyelenggara acara</td>
        </tr>
        <tr>
            <td>Terkait dengan pengembalian dana, maukarcis.com berperan sebagai agen penjualan karcis sehingga jika terjadi proses refund sepenuhnya tunduk kepada kebijakan promotor atau penyelenggara acara</td>
        </tr>
    </table>
    
</body>
</html>
