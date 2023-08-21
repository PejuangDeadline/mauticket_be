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
            <div style="clear: both;"></div> 
            <h1>{{ $getEventInfo->event_name }}</h1>
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
                    <td colspan="2">Tunjukkan eTicket yang telah diterima pada email atau halaman Order pada website maukarcis.com kepada petugas di lapangan</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="2">Info Penting</th>
                </tr>
                <tr>
                    <td colspan="2">{{ $event->important_info }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th colspan="2">Lainnya</th>
                </tr>
                <tr>
                    <td colspan="2">{{ $event->other_info }}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th>ID Event</th>
                    <th>Price</th>
                </tr>
                @foreach ($ticketDetails as $ticketDetail)
                <tr>
                    <td>{{ $ticketDetail->id_event }}</td>
                    <td>{{ 'Rp ' . number_format($ticketDetail->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>
