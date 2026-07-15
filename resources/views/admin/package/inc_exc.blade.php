@extends('layouts.app')
@section('title', 'Inclusions & Exclusions')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Package Management" subTitle="Inclusions & Exclusions" :breadcrumbItems="['Dashboard', 'Packages', 'Inc/Exc']" />
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">Features For: {{ $data->name }}</h6>
            <a class="btn btn-light btn-sm" href="{{ route('admin.package.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body bg-light p-3">
            <x-alert type="success" />
            <form action="{{ route('admin.trip.incexc', $data->id) }}" method="POST">
                @csrf
                <div class="row g-4">
                    <!-- Inclusions -->
                    <div class="col-md-6">
                        <div class="card h-100 border-success">
                            <div class="card-header bg-success bg-opacity-10 text-success"><h6 class="mb-0">✅ Inclusions</h6></div>
                            <div class="card-body">
                                <div class="includedDisplay">
                                    @foreach($data->included_data ?? [] as $item)
                                        <div class="row mb-2 inc-item">
                                            <div class="col-10"><input type="text" name="included[content][]" class="form-control form-control-sm" value="{{ $item['content'] ?? '' }}" placeholder="What's included?"></div>
                                            <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeInc"><i class="bi bi-trash"></i></button></div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-success addInc mt-2"><i class="bi bi-plus-circle"></i> Add Inclusion</button>
                            </div>
                        </div>
                    </div>
                    <!-- Exclusions -->
                    <div class="col-md-6">
                        <div class="card h-100 border-danger">
                            <div class="card-header bg-danger bg-opacity-10 text-white"><h6 class="mb-0">❌ Exclusions</h6></div>
                            <div class="card-body">
                                <div class="excludedDisplay">
                                    @foreach($data->excluded_data ?? [] as $item)
                                        <div class="row mb-2 exc-item">
                                            <div class="col-10"><input type="text" name="excluded[content][]" class="form-control form-control-sm" value="{{ $item['content'] ?? '' }}" placeholder="What's excluded?"></div>
                                            <div class="col-2"><button type="button" class="btn btn-danger btn-sm removeExc"><i class="bi bi-trash"></i></button></div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger addExc mt-2"><i class="bi bi-plus-circle"></i> Add Exclusion</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Features</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.addInc').click(() => $('.includedDisplay').append(`<div class="row mb-2 inc-item"><div class="col-10"><input type="text" name="included[content][]" class="form-control form-control-sm" placeholder="What's included?"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeInc"><i class="bi bi-trash"></i></button></div></div>`));
        $(document).on('click', '.removeInc', function() { $(this).closest('.inc-item').remove(); });

        $('.addExc').click(() => $('.excludedDisplay').append(`<div class="row mb-2 exc-item"><div class="col-10"><input type="text" name="excluded[content][]" class="form-control form-control-sm" placeholder="What's excluded?"></div><div class="col-2"><button type="button" class="btn btn-danger btn-sm removeExc"><i class="bi bi-trash"></i></button></div></div>`));
        $(document).on('click', '.removeExc', function() { $(this).closest('.exc-item').remove(); });
    });
</script>
@endpush