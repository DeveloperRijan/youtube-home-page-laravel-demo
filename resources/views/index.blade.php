@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush
@section('content')

    <div class="videos">
        <h1>Media</h1>
        <div class="videos__container">
            @if (count($media) > 0)
                <!-- Single Video starts -->
                    @foreach ($media as $file)
                        <div class="video me-4">
                            <div class="video__thumbnail">
                            <img
                                src="https://img.youtube.com/vi/d2na6sCyM5Q/maxresdefault.jpg"
                                alt=""
                            />
                            </div>
                            <div class="video__details">
                            <div class="title">
                                <h3>{{ $file->name }}</h3>
                                <div class="spec d-flex justify-content-between">
                                    <span>{{ $file->created_at->diffForHumans() }}</span>
                                    <span>{{ $file->humanFileSize() }}</span>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                <!-- Single Video Ends -->
            @else
                <p class="d-flex justify-content-center align-items-center">No media found</p>
            @endif
        </div>
    </div>

@include('modals.modal_upload')
@endsection
@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="{{ asset('assets/js/file_upload.js') }}" defer></script>

<script>
    var home_url = "{{env('APP_URL') }}";
    var deleteAction = '{{ route("file-delete") }}';
    var generalTS =  document.getElementById('dataTS').value;
    var generalDATE = document.getElementById('dataDATE').value;
    var token = '{!! csrf_token() !!}';
</script>
@endpush
