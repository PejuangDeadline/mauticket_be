<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS styles here */
        .logo {
            max-width: 100%; /* Set the maximum width to 100% of the container */
            height: auto; /* Automatically adjust the height to maintain aspect ratio */
            display: block; /* Remove any extra space around the image */
            margin: 0 auto; /* Center the image horizontally */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>EMAIL INVOICE</h1>
            <p>Subject: [maukarcis.com-Invoice] Order ID {{ $transaction->no_transaction }} ({{ $getEvenetInfo->event_name }})</p>
            <hr>
        </header>
        <div class="content">
            <img src="{{ URL::asset('assets/img/Logo Option 3 (1).png') }}" alt="Logo MauKarcis" class="logo">

            <p>Halo {{ $getUser->firstname }},</p>
            <p>Terima kasih telah memesan tiket {{ $getEvenetInfo->event_name }}.</p>
            <p>Berikut detail pemesanan:</p>

            <table>
                <tr>
                    <td><strong>Order ID:</strong></td>
                    <td>{{ $transaction->no_transaction }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Pengguna:</strong></td>
                    <td>{{ $getUser->firstname.' '.$getUser->lastname }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Karcis:</strong></td>
                    <td>{{ $transaction->qty }}</td>
                </tr>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td>{{ 'Rp ' . number_format($transaction->grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
            <p>maukarcis.com</p>
        </div>
    </div>
</body>
</html>
