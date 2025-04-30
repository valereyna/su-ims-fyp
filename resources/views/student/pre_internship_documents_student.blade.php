@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <h3 class="page-title">Pre Internship Documents</h3>
        <div class="row">
            <div class="col-md-12">
                @if($documents->isEmpty())
                    <p>No documents available for download.</p>
                @else
                    <div class="row">
                        @foreach($documents as $document)
                            <div class="col-md-4">
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="document-icon mr-3">
                                            <i class="fas fa-file-alt fa-3x text-primary"></i>
                                        </div>
                                        <div class="document-info flex-grow-1">
                                            <h5 class="card-title mb-1">{{ $document->document_name }}</h5>
                                            <a href="{{ route('preinternship.download', $document->id) }}" class="btn btn-sm btn-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.document-icon {
    width: 50px;
    text-align: center;
}
</style>
@endsection
