@extends('layouts.app')

@section('title', 'Edit Writer')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-card icon="list" title="Edit Writer">
                    <form action="{{ route('admin.writers.update', $writer->id) }}" method="POST" id="formUpdateWriter">
                        @csrf
                        @method('PUT') <!-- Gunakan PUT untuk update data -->
                        
                        <input type="hidden" name="id" id="id" value="{{ $writer->id }}">
                        
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $writer->name }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $writer->email }}">
                        </div>
                    
                        <div class="mb-3">
                            <label for="registered_at">Registered At</label>
                            <input type="date" name="registered_at" id="registered_at" class="form-control" value="{{ $writer->created_at->format('Y-m-d') }}">
                        </div>
                    
                        <div class="float-end">
                            <a href="{{ route('admin.writers.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
                        </div>
                    </form>
                    
                </x-card>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/library/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src={{ asset('assets/backend/js/helper.js') }}></script>
    <script src={{ asset('assets/backend/js/writer.js') }}></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\WriterRequest', '#formUpdateWriter') !!}
@endpush
