<!DOCTYPE html>
<html>

<head>
    <title>Data Pendaftar Kursus Offline</title>
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
                Data Pendaftar Kursus Offline
            </td>
        </tr>
    </table>
    <table class="table-border">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Kursus</th>
                <th>Nama Pengguna</th>
                <th>Email Pengguna</th>
                <th>Telepon</th>
                <th>Asal Perusahaan</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->offlineCourse->title }}</td>
                    <td>{{ $item->user_name }}</td>
                    <td>{{ $item->user_email }}</td>
                    <td>{{ $item->user_phone }}</td>
                    <td>{{ $item->user_company_name }}</td>
                    <td>
                        @if (!empty($item->offlineCourseAttendance))
                            Hadir
                        @else
                            Tidak Hadir
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
