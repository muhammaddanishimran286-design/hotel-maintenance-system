@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="page-title">
            <i class="fas fa-edit text-white me-2"></i> Edit Request
        </h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('maintenance.update', $maintenanceRequest->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-heading text-primary me-1"></i> Title
                        </label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $maintenanceRequest->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-align-left text-primary me-1"></i> Description
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" required>{{ old('description', $maintenanceRequest->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i> Location
                        </label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location', $maintenanceRequest->location) }}" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-exclamation-triangle text-primary me-1"></i> Urgency
                                </label>
                                <select name="urgency" class="form-control @error('urgency') is-invalid @enderror">
                                    <option value="low" {{ $maintenanceRequest->urgency == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium" {{ $maintenanceRequest->urgency == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high" {{ $maintenanceRequest->urgency == 'high' ? 'selected' : '' }}>🟠 High</option>
                                    <option value="critical" {{ $maintenanceRequest->urgency == 'critical' ? 'selected' : '' }}>🔴 Critical</option>
                                </select>
                                @error('urgency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-info-circle text-primary me-1"></i> Status
                                </label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="pending" {{ $maintenanceRequest->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="in_progress" {{ $maintenanceRequest->status == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                    <option value="on_hold" {{ $maintenanceRequest->status == 'on_hold' ? 'selected' : '' }}>⏸️ On Hold</option>
                                    <option value="completed" {{ $maintenanceRequest->status == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image text-primary me-1"></i> Image
                        </label>
                        @if($maintenanceRequest->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $maintenanceRequest->image) }}"
                                 style="max-height: 100px;" class="rounded-3 border">
                        </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Upload a new image to replace the current one (optional)</small>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                        <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
