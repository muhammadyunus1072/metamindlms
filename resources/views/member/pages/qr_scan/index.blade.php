@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <div id="reader" width="100%"></div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        var isSuccess = false;
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            },
            /* verbose= */
            false);

        $(() => {
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        })

        function onScanSuccess(decodedText, decodedResult) {
            if (!isSuccess) {
                isSuccess = true;
                console.log(`Code matched = ${decodedText}`, decodedResult);
                window.location.replace(decodedText);
            }
        }

        function onScanFailure(error) {

        }
    </script>
@endpush
