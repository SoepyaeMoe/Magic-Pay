@extends('frontend.layouts.app')
@section('title', 'Notification')
@section('home_active', 'active')
@section('content')
    <div class="notification mt-3">
        <div class="infinite-scroll">
            @foreach ($notifications as $notification)
                <div class="card mb-2">
                    <a href="{{ route('notification-detail', $notification->id) }}">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <h6>{{ Str::limit($notification->data['title'], 20, '...') }}</h6>
                                @if ($notification->read_at == null)
                                    <div style="width: 5px; height: 5px; border-radius: 50%; background-color: red;"></div>
                                @endif
                            </div>
                            <p class="text-muted mb-0">{{ Str::limit($notification->data['message'], 100, '...') }}</p>
                            <small class="text-muted mb-0">
                                {{ $notification->created_at->format('d-M-Y H:i:s') }}
                            </small>
                        </div>
                    </a>
                </div>
            @endforeach
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div><small class="ms-2">Loading.....</small>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endsection
