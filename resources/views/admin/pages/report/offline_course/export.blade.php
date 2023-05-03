<!DOCTYPE html>
<html>

<head>
    <title>Data Kursus Offline</title>
    <style>
        .table-border {
            border-collapse: collapse;
            font-size: 13px;
        }

        .table-border td {
            border: 1px solid;
            padding: 3px;
        }

        .table-border th {
            border: 1px solid;
            font-weight: bold;
            padding: 3px;
        }

        ul {
            padding-left: 16px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="7" style="text-align: center; font-weight: bold;">
                Data Kursus Offline
            </td>
        </tr>
    </table>
    <table class="table-border">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Judul</th>
                <th>Quota</th>
                <th>Jumlah Pendaftar</th>
                <th>Jumlah Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ Carbon\Carbon::parse($item->date_time_start)->format('d M Y, H:i') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->date_time_end)->format('d M Y, H:i') }}</td>
                    <td>{{ $item->title }}</td>
                    <td>
                        {{ $number_format ? number_format($item->quota, 0, ',', '.') : $item->quota }}
                    </td>
                    <td>
                        {{ $number_format ? number_format($item->registrars->count(), 0, ',', '.') : $item->registrars->count() }}
                    </td>
                    <td>
                        {{ $number_format ? number_format($item->attendances->count(), 0, ',', '.') : $item->attendances->count() }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
