<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Arsip - {{ $kategori->nama_kategori }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h3 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f2f2f2; padding: 8px 5px; text-align: center; font-size: 11px; }
        td { padding: 6px 5px; vertical-align: top; font-size: 10px; }
        .text-center { text-align: center; }
        .badge { padding: 2px 4px; border-radius: 4px; font-size: 9px; font-weight: bold; background-color: #eee; }
    </style>
</head>
<body>

    <div class="header">
        <h3>REKAPITULASI DOKUMEN ARSIP</h3>
        <p>Gudang Folder: <strong>{{ $kategori->nama_kategori }}</strong> ({{ $kategori->deskripsi }})</p>
        <p>Subbagian: {{ Auth::user()->subbagian->nama_subbag ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">KODE KLASIFIKASI</th>
                <th width="30%">NAMA ARSIP</th>
                <th width="10%">TAHUN</th>
                <th width="10%">JUMLAH</th>
                <th width="15%">STATUS RETENSI</th>
                <th width="15%">LOKASI FISIK</th>
            </tr>
        </thead>
        <tbody>
            @forelse($arsips as $index => $arsip)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ Auth::user()->subbagian->kode_klasifikasi }}.{{ $arsip->nomor_dokumen }}</td>
                <td>{{ $arsip->nama_arsip }}</td>
                <td class="text-center">{{ $arsip->tahun_berkas ?? '-' }}</td>
                <td class="text-center">{{ $arsip->jumlah_berkas }} Lembar</td>
                <td class="text-center">
                    @if($arsip->status_retensi == 'Musnah')
                        Telah Musnah
                    @elseif($arsip->status_retensi == 'Permanen')
                        Permanen
                    @elseif($arsip->status_retensi == 'Inaktif')
                        Inaktif ({{ $arsip->retensi_inaktif }} Thn)
                    @elseif($arsip->status_retensi == 'Aktif')
                        Aktif ({{ $arsip->retensi_aktif }} Thn)
                    @else
                        Belum Diatur
                    @endif
                </td>
                <td class="text-center">{{ $arsip->lokasi_fisik ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada dokumen yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 10px;">
        Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}<br>
        Dicetak oleh: {{ Auth::user()->name }}
    </div>

</body>
</html>
