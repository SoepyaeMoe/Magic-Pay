@extends('frontend.layouts.app')
@section('title', 'My QR')
@section('home_active', 'active')
@section('content')
    <div class="my_qr mt-3">
        <div class="card mb-3 shadow">
            <div class="card-body">
                <div class="visible-print text-center">
                    {!! QrCode::size(250)->generate($user->phone) !!}
                    <p class="m-0"><strong class="m-0">{{ $user->name }}</strong></p>
                    <p>{{ $user->phone }}</p>
                    <p>Scan me to transfer money.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
