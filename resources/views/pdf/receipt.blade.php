<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran Sewa Kendaraan</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #333;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            position: relative;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        /* Solusi menggunakan gambar logo yang sudah digabung dengan background */
        .logo-image {
            width: 180px;
            height: auto;
            margin-bottom: 5px;
        }

        .receipt-title {
            font-size: 22px;
            margin: 25px 0;
            text-align: center;
            color: #1F2937;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-section {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            padding: 5px 15px;
            border-left: 4px solid #4F46E5;
            /* Indigo primary color */
        }

        .info-section h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin-bottom: 12px;
            font-size: 16px;
            color: #4F46E5;
            /* Indigo primary color */
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: 600;
            padding: 6px 0;
            width: 40%;
            color: #4B5563;
        }

        .info-value {
            display: table-cell;
            padding: 6px 0;
        }

        .vehicle-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #F3F4F6;
            border-radius: 8px;
            border-left: 4px solid #4F46E5;
            /* Indigo primary color */
        }

        .vehicle-details h3 {
            color: #4F46E5;
            /* Indigo primary color */
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .payment-details {
            margin: 20px 0;
            border-top: 1px solid #E5E7EB;
            padding: 15px;
            background-color: #F3F4F6;
            border-radius: 8px;
            border-left: 4px solid #4F46E5;
            /* Indigo primary color */
        }

        .payment-details h3 {
            color: #4F46E5;
            /* Indigo primary color */
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 15px;
            padding: 10px;
            background-color: #EEF2FF;
            border-radius: 5px;
            color: #1F2937;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #6B7280;
            padding-top: 20px;
            border-top: 1px dashed #E5E7EB;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-paid {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-confirmed {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-completed {
            background-color: #D1FAE5;
            color: #0F5132;
        }

        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .stamp {
            position: absolute;
            top: 30px;
            right: 30px;
            transform: rotate(15deg);
            font-size: 24px;
            font-weight: bold;
            color: rgba(220, 38, 38, 0.7);
            border: 3px solid rgba(220, 38, 38, 0.7);
            padding: 10px 20px;
            border-radius: 8px;
        }

        .qr-code-container {
            text-align: center;
            margin: 30px 0;
            padding: 15px;
            background-color: #F9FAFB;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }

        .qr-code-text {
            font-size: 14px;
            color: #4B5563;
            margin-top: 10px;
            font-weight: 600;
        }

        .qr-code-info {
            font-size: 12px;
            color: #6B7280;
            margin-top: 5px;
        }

        .barcode {
            text-align: center;
            margin-top: 10px;
        }

        .barcode-text {
            font-family: 'Libre Barcode 39', cursive;
            font-size: 42px;
            letter-spacing: -1px;
            margin: 10px 0;
        }

        /* Styling untuk QR code SVG */
        .qr-code-svg {
            width: 200px;
            height: 200px;
            margin: 0 auto;
            background-color: white;
            padding: 10px;
            border: 1px solid #E5E7EB;
            border-radius: 5px;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .container {
                box-shadow: none;
                margin: 0;
                padding: 15px;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <!-- Menggunakan gambar logo yang sudah digabung dengan background dan teks -->
            <div style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo/gorent_logo_with_text.png'))) }}"
                    alt="GoRent Logo"
                    class="logo-image">
            </div>

            @if($rental->payment_status == 'confirmed' || $rental->payment_status == 'completed')
            <div class="stamp">LUNAS</div>
            @elseif($rental->payment_status == 'paid')
            <div class="stamp">MENUNGGU KONFIRMASI</div>
            @endif
        </div>

        <h1 class="receipt-title">Bukti Pembayaran</h1>

        <div class="info-section">
            <h3>Informasi Pemesanan</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nomor Kuitansi:</div>
                    <div class="info-value">GR-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Pemesanan:</div>
                    <div class="info-value">{{ $rental->created_at->format('d F Y, H:i') }} WIB</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status Pembayaran:</div>
                    <div class="info-value">
                        @if($rental->payment_status == 'pending')
                        <span class="status status-pending">Menunggu Pembayaran</span>
                        @elseif($rental->payment_status == 'paid')
                        <span class="status status-paid">Sudah Dibayar</span>
                        @elseif($rental->payment_status == 'confirmed')
                        <span class="status status-confirmed">Dikonfirmasi</span>
                        @elseif($rental->payment_status == 'completed')
                        <span class="status status-completed">Selesai</span>
                        @elseif($rental->payment_status == 'cancelled')
                        <span class="status status-cancelled">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Informasi Pelanggan</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nama:</div>
                    <div class="info-value">{{ $rental->customer_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor KTP:</div>
                    <div class="info-value">{{ $rental->customer_nik }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor Telepon:</div>
                    <div class="info-value">{{ $rental->customer_phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Alamat:</div>
                    <div class="info-value">{{ $rental->customer_address ?? 'Tidak tersedia' }}</div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>Detail Penyewaan</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Tanggal Pengambilan:</div>
                    <div class="info-value">{{ $rental->rental_date->format('d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Pengembalian:</div>
                    <div class="info-value">{{ $rental->return_date->format('d F Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Durasi:</div>
                    <div class="info-value">{{ $rental->duration }} {{ $rental->duration > 1 ? 'hari' : 'hari' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lokasi Pengambilan:</div>
                    <div class="info-value">{{ $rental->pickup_location ?? 'Kantor Pusat GoRent' }}</div>
                </div>
            </div>
        </div>

        <div class="vehicle-details">
            <h3>Informasi Kendaraan</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Kendaraan:</div>
                    <div class="info-value">{{ $rental->vehicle->brand }} {{ ucfirst($rental->vehicle->type) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor Plat:</div>
                    <div class="info-value">{{ $rental->vehicle->no_plat }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Warna:</div>
                    <div class="info-value">{{ ucfirst($rental->vehicle->color) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tahun:</div>
                    <div class="info-value">{{ $rental->vehicle->year }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tarif Harian:</div>
                    <div class="info-value">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }} / hari</div>
                </div>
            </div>
        </div>

        <div class="payment-details">
            <h3>Ringkasan Pembayaran</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Tarif Harian:</div>
                    <div class="info-value">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jumlah Hari:</div>
                    <div class="info-value">{{ $rental->duration }}</div>
                </div>
                @if(isset($rental->additional_features) && count($rental->additional_features) > 0)
                <div class="info-row">
                    <div class="info-label">Fitur Tambahan:</div>
                    <div class="info-value">
                        @foreach($rental->additional_features as $feature)
                        <div>{{ $feature->name }}: Rp {{ number_format($feature->price, 0, ',', '.') }}</div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if(isset($rental->discount) && $rental->discount > 0)
                <div class="info-row">
                    <div class="info-label">Diskon:</div>
                    <div class="info-value">- Rp {{ number_format($rental->discount, 0, ',', '.') }}</div>
                </div>
                @endif
            </div>
            <div class="total">
                Total Pembayaran: Rp {{ number_format($rental->total_payment, 0, ',', '.') }}
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah memilih GoRent Rental Mobil Terpercaya!</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi layanan pelanggan kami di +62 812-3456-7890</p>
            <p>Bukti pembayaran ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
</body>

</html>
