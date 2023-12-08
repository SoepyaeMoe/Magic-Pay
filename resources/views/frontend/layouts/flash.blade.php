@error('fail')
    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@enderror
