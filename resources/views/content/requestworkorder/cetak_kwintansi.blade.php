<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kwitansi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin: 40px;
        }

        .kop-surat {
            display: flex;
            align-items: flex-start;
        }

        .kop-kiri {
            font-weight: bold;
            line-height: 1.3;
            white-space: pre-line;
        }

        .kop-garis {
            position: sticky;
            background-color: black;
            margin: 0 25px;
            border-left: solid 2px #000
        }

        .kop-kanan {
            line-height: 1.5;
        }

        .kop-kanan .nama {
            font-weight: bold;
        }

        .kop-kanan .alamat {
            margin-top: 2px;
        }

        hr {
            border: 1px solid #000;
            margin-top: 0px;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
            text-decoration: underline;
        }

        .info-pelanggan {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin-top: 20px;
        }

        .info-pelanggan table {
            border-collapse: collapse;
            border: none;
            text-transform: capitalize;
        }

        .info-pelanggan td {
            padding: 2px 8px 2px 0;
            vertical-align: top;
            border: none;
            /* HILANGKAN GARIS TABEL */
        }

        .info-pelanggan td.label {
            width: 140px;
        }

        .info-pelanggan td.titikdua {
            width: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-transform: capitalize;
            font-size: 10pt;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
            text-transform: uppercase;
        }

        .signature p {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>
    @php
        $total_biaya_layanan = $work_order->work_order_details->sum('harga') ?? 0;
        $total_biaya_lain_lain = array_sum(array_column($work_order_another_expenses, 'nominal')) ?? 0;
        $total_pembayaran = $work_order->work_order_payments->sum('nominal') ?? 0;

        $total_all = $total_biaya_layanan + $total_biaya_lain_lain;
        $sisa = $total_all - $total_pembayaran;
    @endphp
    <div class="kop-surat">
        <div class="kop-kiri">
            NOTARIS
            P P A T
            N P A K
            {{-- NOTARIS --}}
        </div>
        <div class="kop-garis" style="height: 100px;"></div>
        <div class="kop-kanan">
            <div class="nama">NAGHFIR, S.HI., S.H., M.Kn.</div>
            <div class="alamat">
                Jl. Jokotole–Perumahan Griya Berkat Regency Gg III No.24 (Lingkar Barat),<br>
                Kecamatan Batuan, Kabupaten Sumenep<br>
                Telp. 082-255-999-138
            </div>
        </div>
    </div>

    <hr>

    <h2>KWITANSI</h2>

    <div class="info-pelanggan">
        <table>
            <tr>
                <td class="label">Nama Pelanggan</td>
                <td class="titikdua">:</td>
                <td>{{ $work_order->client->nama }}</td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td>:</td>
                <td>{{ $work_order->client->no_telp }}</td>
            </tr>
            <tr>
                <td>No Invoice</td>
                <td>:</td>
                <td>{{ $work_order->no_wo }}</td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td>:</td>
                <td>{{ $work_order->status_pembayaran }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td>Rp {{ formatRupiah($total_all) }}</td>
            </tr>
            <tr>
                <td>Terbayar</td>
                <td>:</td>
                <td>Rp {{ formatRupiah($total_pembayaran) }}</td>
            </tr>
            <tr>
                <td>Sisa Tagihan</td>
                <td>:</td>
                <td>Rp {{ formatRupiah($sisa) }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Detail Layanan</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Layanan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($work_order->work_order_details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->keperluan }}</td>
                    <td class="text-right">Rp {{ formatRupiah($detail->harga) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total Biaya Layanan</strong></td>
                <td class="text-right"><strong>Rp {{ formatRupiah($total_biaya_layanan) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Biaya Lain-Lain</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Biaya</th>
                <th>Layanan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($work_order_another_expenses as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->keperluan }}</td>
                    <td class="text-right">Rp {{ formatRupiah($data->nominal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total Biaya Lain-lain</strong></td>
                <td class="text-right"><strong>Rp {{ formatRupiah($total_biaya_lain_lain) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Rincian Pembayaran</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>No Pembayaran</th>
                <th>Metode</th>
                <th>Catatan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($work_order->work_order_payments as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ dateFormatID($value->tgl_bayar, 'D MMMM Y') }}</td>
                    <td>{{ $value->no_pembayaran }}</td>
                    <td>{{ $value->metode_pembayaran }}</td>
                    <td>{{ $value->catatan }}</td>
                    <td class="text-right">Rp {{ formatRupiah($value->nominal) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5"><strong>Total Pembayaran</strong></td>
                <td class="text-right"><strong>Rp {{ formatRupiah($total_pembayaran) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Hormat Kami,</p>
        <strong>[{{ $work_order->admin->name }}]</strong>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script type="text/javascript">
    $(window).on('load', function() {
        window.print()
    });
</script>

</html>
