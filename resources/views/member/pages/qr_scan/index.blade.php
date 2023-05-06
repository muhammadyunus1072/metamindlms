@extends('member.layouts.index')

@section('content')
    <div class="page-section">
        <div class="container page__container">
            <h4 class="text-center">Scan QR Code Kegiatan</h4>
            <div id="reader" width="100%"></div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        var isSuccess = false;
        const html5QrCode = new Html5Qrcode("reader");
        const config = {
            fps: 10,
            qrbox: 250
        };

        $(() => {
            html5QrCode.start({
                facingMode: "environment"
            }, config, onScanSuccess);
        })

        function onScanSuccess(decodedText, decodedResult) {
            if (!isSuccess) {
                isSuccess = true;
                console.log(`Code matched = ${decodedText}`, decodedResult);
                window.location.replace(decodedText);
            }
        }
    </script>
@endpush
