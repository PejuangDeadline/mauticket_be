<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your CSS styles here */
        .logo {
            max-width: 30%; /* Set the maximum width to 100% of the container */
            height: auto; /* Automatically adjust the height to maintain aspect ratio */
            display: block; /* Remove any extra space around the image */
            margin: 0 auto; /* Center the image horizontally */
        }
        .align-left {
            float: left; /* Float the image to the left */
            margin-right: 20px; /* Add some margin to separate the image from text */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="{{ $message->embed(public_path('assets/img/Logo Option 3 (1).png')) }}" alt="Logo MauKarcis" class="logo align-left">
            <div style="clear: both;"></div> 
            <hr>
        </header>
        <div class="content">
            <h3>Halo <strong>{{ $getUser->firstname }}</strong>,</h3>
            <p>Terima kasih telah memesan tiket {{ $getEvenetInfo->event_name }}.</p>
            <p>Berikut detail pemesanan:</p>

            <table>
                <tr>
                    <td><strong>Order ID</strong></td>
                    <td>: {{ $transaction->no_transaction }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Pengguna</strong></td>
                    <td>: {{ $getUser->firstname.' '.$getUser->lastname }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Karcis</strong></td>
                    <td>: {{ $transaction->qty }}</td>
                </tr>
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td>: {{ 'Rp ' . number_format($transaction->sub_total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Promo</strong></td>
                    <td>: ({{ 'Rp ' . number_format($transaction->discount, 0, ',', '.') }})</td>
                </tr>
                <tr>
                    <td><strong>Tax (10%)</strong></td>
                    <td>: {{ 'Rp ' . number_format($transaction->tax, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Biaya Layanan</strong></td>
                    <td>: {{ 'Rp ' . number_format($transaction->platform_fee, 0, ',', '.') }} <hr></td>
                </tr>
                <tr>
                    <td><strong>Total Pembayaran</strong></td>
                    <td>: {{ 'Rp ' . number_format($transaction->grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
