@extends('frontend.layouts.app')
@section('title', 'Notification Detail')
@section('home_active', 'active')
@section('content')
    <div class="notification_datail mt-3">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('img/notification.png') }}" alt="" style="width: 220px;">
                <h6>{{ $notification->data['title'] }}</h6>
                <p class="text-muted mb-1">{{ $notification->data['message'] }}</p>
                <small class="text-muted">{{ $notification->created_at->format('d-M-Y h:i:s') }}</small>
                <div class="mt-3">
                    <a href="{{ $notification->data['web_link'] }}" class="btn btn-theme btn-sm">Continute</a>
                </div>
            </div>
        </div>
    </div>
@endsection
