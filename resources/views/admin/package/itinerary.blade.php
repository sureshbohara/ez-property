@extends('layouts.app')
@section('title', 'Package Itinerary')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Package Management" subTitle="Itinerary" :breadcrumbItems="['Dashboard', 'Packages', 'Itinerary']" />
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">Itinerary For: {{ $data->name }}</h6>
            <a class="btn btn-light btn-sm" href="{{ route('admin.package.index') }}"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body bg-light p-3">
            <x-alert type="success" />
            <form action="{{ route('admin.trip.itinerary', $data->id) }}" method="POST">
                @csrf
                <div class="card shadow-none border bg-white">
                    <div class="card-body">
                        <div class="itineraryDisplay">
                            @foreach (old('title', $data->itinerary_data ?? []) as $index => $step)
                                <div class="row mb-3 itinerary-step border-bottom pb-3">
                                    <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="day-title mb-0 text-primary">Day {{ $index + 1 }}</h5>
                                        <button type="button" class="btn btn-sm btn-outline-danger removeItineraryStep"><i class="bi bi-trash"></i></button>
                                    </div>
                                    <div class="col-md-12 mb-2"><label class="form-label small">Title</label><input type="text" class="form-control" name="title[]" value="{{ $step['name'] ?? '' }}" required></div>
                                    <div class="col-md-12 mb-2"><label class="form-label small">Description</label><textarea class="form-control" name="content[]" rows="3" required>{{ $step['content'] ?? '' }}</textarea></div>
                                    <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="max_elevation[]" value="{{ $step['max_elevation'] ?? '' }}" placeholder="Max Elevation"></div>
                                    <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="duration[]" value="{{ $step['duration'] ?? '' }}" placeholder="Duration"></div>
                                    <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="distance[]" value="{{ $step['distance'] ?? '' }}" placeholder="Distance"></div>
                                    <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="meals[]" value="{{ $step['meals'] ?? '' }}" placeholder="Meals"></div>
                                    <div class="col-md-12"><input type="text" class="form-control form-control-sm" name="accommodation[]" value="{{ $step['accommodation'] ?? '' }}" placeholder="Accommodation"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-primary addItineraryStep"><i class="bi bi-plus-circle"></i> Add Day</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Itinerary</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        let stepCount = {{ count(old('title', $data->itinerary_data ?? [])) }};
        const template = (i) => `
        <div class="row mb-3 itinerary-step border-bottom pb-3">
            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h5 class="day-title mb-0 text-primary">Day ${i + 1}</h5>
                <button type="button" class="btn btn-sm btn-outline-danger removeItineraryStep"><i class="bi bi-trash"></i></button>
            </div>
            <div class="col-md-12 mb-2"><label class="form-label small">Title</label><input type="text" class="form-control" name="title[]" required></div>
            <div class="col-md-12 mb-2"><label class="form-label small">Description</label><textarea class="form-control" name="content[]" rows="3" required></textarea></div>
            <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="max_elevation[]" placeholder="Max Elevation"></div>
            <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="duration[]" placeholder="Duration"></div>
            <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="distance[]" placeholder="Distance"></div>
            <div class="col-md-3 mb-2"><input type="text" class="form-control form-control-sm" name="meals[]" placeholder="Meals"></div>
            <div class="col-md-12"><input type="text" class="form-control form-control-sm" name="accommodation[]" placeholder="Accommodation"></div>
        </div>`;

        $('.addItineraryStep').click(() => { $('.itineraryDisplay').append(template(stepCount++)); });
        $(document).on('click', '.removeItineraryStep', function () {
            $(this).closest('.itinerary-step').remove();
            $('.itinerary-step').each((i, el) => $(el).find('.day-title').text(`Day ${i + 1}`));
            stepCount--;
        });
    });
</script>
@endpush