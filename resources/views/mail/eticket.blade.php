<!DOCTYPE html>
<html>
<head>
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
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="{{ $message->embed(public_path('assets/img/Logo Option 3 (1).png')) }}" alt="Logo MauKarcis" class="logo align-left">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate($transactionHeader->id)) !!} ">
            <div style="clear: both;"></div> 
            <h1>{{ $getEventInfo->event_name }}</h1>
            <a href="{{url('pdfe-ticket/'.encrypt($transactionHeader->id))}}">Download E-Ticket</a>
            <hr>
        </header>
        <div class="content">
            <table>
                <tr>
                    <th colspan="2">Detail Pemesan</th>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $user->firstname }} {{ $user->lastname }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ $user->email }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="2">Info Penukaran</th>
                </tr>
                <tr>
                    <td colspan="2">{!! $getEventInfo->exchange_ticket_info !!}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="4">Info Penting</th>
                </tr>
                <tr>
                    <td>{!! $getEventInfo->tc_info !!}</td>
                    <td>{!! $getEventInfo->including_info !!}</td>
                    <td>{!! $getEventInfo->excluding_info !!}</td>
                    <td>{!! $getEventInfo->facility !!}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="3">Lainnya</th>
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

            <table>
                <tr>
                    <th>Seat Number</th>
                    <th>Price</th>
                </tr>
                @foreach ($transactionDetail as $ticketDetail)
                <tr>
                    <td>{{ $ticketDetail->no_seat }}</td>
                    <td>{{ 'Rp ' . number_format($ticketDetail->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>
