<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        header {
            background-color: #35424a;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            padding: 0;
        }

        .content {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        footer {
            background-color: #35424a;
            color: white;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Invoice untuk Transaksi {{ $transaction->no_transaction }}</h1>
        </header>
        <div class="content">
            <table>
                <tr>
                    <th>Detail Transaksi</th>
                </tr>
                <tr>
                    <td><strong>Nama Pengguna:</strong></td>
                    <td>{{ $getUser->firstname.' '.$getUser->lastname }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah:</strong></td>
                    <td>{{ $transaction->qty }}</td>
                </tr>
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td>{{ 'Rp ' . number_format($transaction->grand_total, 0, ',', '.') }}</td>
                </tr>
                
                <!-- Tambahkan atribut lain jika diperlukan -->
            </table>
        </div>
        
        <footer>
            [Tim MauKarcis]
        </footer>
    </div>
</body>
</html>
