@extends('frontend.layouts.app')
@section('title', 'Scan To Pay')
@section('home_active', 'active')
@section('content')
    <div class="scan_to_pay mt-3">
        <div class="card mb-3 shadow">
            <div class="card-body">
                @include('frontend.layouts.flash')
                <div class="text-center m-3">
                    <img src="{{ asset('img/scan_to_pay.png') }}" alt="" style="width: 250px;">
                    <p class="mt-3">Click button, put QR code in the frame and pay.</p>
                </div>
                <div class="text-center">
                    <button class="btn btn-theme btn-sm" data-bs-toggle="modal" data-bs-target="#scan_to_pay">Scan</button>
                    <!--Scan Modal -->
                    <div class="modal fade" id="scan_to_pay" tabindex="-1" aria-labelledby="scan_to_payLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="scan_to_payLabel">Scan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <video id="scan_vd" style="width: 100%;"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('frontend/js/qr-scanner.umd.min.js') }}"></script>
    <script>
        const myModalEl = document.getElementById('scan_to_pay');
        const videoElem = document.getElementById('scan_vd');
        $(document).ready(function() {
            const qrScanner = new QrScanner(
                videoElem,
                function(result) {
                    if (result) {
                        $('#scan_to_pay').modal('hide');
                        qrScanner.stop();
                        window.location.replace(encodeURI(`transfer?to_phone=${result}`));
                    }
                }
            );
            myModalEl.addEventListener('show.bs.modal', event => {
                qrScanner.start();
            });
            myModalEl.addEventListener('hidden.bs.modal', event => {
                qrScanner.stop();
            });
        });
    </script>
@endsection
