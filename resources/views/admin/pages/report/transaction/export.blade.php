<!DOCTYPE html>
<html>

<head>
    <title>{{ $request['title'] }}</title>
    <style>
        .table-border {
            border-collapse: collapse;
            font-size: 10px;
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
    </style>
</head>

<body>
    <table class="table-border" style="width: 100%">
        <thead>
            <tr>
                <td colspan="9" style="text-align: center; font-weight: bold;">
                    {{ $request['title'] }}
                </td>
            </tr>

            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Tanggal :{{ Carbon\Carbon::parse($request['start_date'])->format('Y-m-d') }} s/d
                    {{ Carbon\Carbon::parse($request['end_date'])->format('Y-m-d') }}
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Kata Kunci :{{ $request['keyword'] }}
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Member : @forelse ($request['members'] as $member)
                        {{ $member['name'] . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Kursus Online : @forelse ($request['courses'] as $course)
                        {{ $course['title'] . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Kursus Offline : @forelse ($request['offline_courses'] as $offline_course)
                        {{ $offline_course['title'] . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Produk : @forelse ($request['products'] as $product)
                        {{ $product['name'] . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Metode Pembayaran : @forelse ($request['payment_methods'] as $payment_methods)
                        {{ $payment_methods['name'] . ' - ' . $payment_methods['description'] . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>
            <tr>
                <td colspan="9" style="font-weight: bold;">
                    Status : @forelse ($request['statuses'] as $status)
                        {{ $status . ', ' }}
                    @empty
                        -
                    @endforelse
                </td>
            </tr>

            <tr>
                <td colspan="9" style="border: 0px; padding:8px">
            </tr>

            <tr>
                <th style="font-weight: bold;">#</th>
                <th style="font-weight: bold;">Tanggal</th>
                <th style="font-weight: bold;">Nomor Invoice</th>
                <th style="font-weight: bold;">Member</th>
                <th style="font-weight: bold;">Produk</th>
                <th style="font-weight: bold;">Detail Produk</th>
                <th style="font-weight: bold;">Total</th>
                <th style="font-weight: bold;">Metode Pembayaran</th>
                <th style="font-weight: bold;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->number }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        @php
                            $products = '';
                            foreach ($item->transactionDetails as $indexTransactionDetail => $transactionDetail) {
                                $is_comma = $item->transactionDetails->count() - 1 > $indexTransactionDetail ? ', ' : '';
                                $products .= $transactionDetail->product_name . $is_comma;
                            }
                        @endphp
                        {{ $products }}
                    </td>
                    <td>
                        @php
                            $html = '';
                            foreach ($item->transactionDetails as $transactionDetail) {
                                foreach ($transactionDetail->courses as $course) {
                                    $html .= $course->course_title . ', ';
                                }
                                foreach ($transactionDetail->offlineCourses as $course) {
                                    $html .= $course->offline_course_title . ', ';
                                }
                            }
                        @endphp
                        {{ $html }}
                    </td>
                    <td>{{ $item->transaction_details_sum_product_price }}</td>
                    <td>{{ $item->payment_method_name . ' - ' . $item->payment_method_description }}</td>
                    <td>{{ $item->status->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
