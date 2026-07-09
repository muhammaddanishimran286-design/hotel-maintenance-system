@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="page-title">
            <i class="fas fa-plus-circle text-white me-2"></i> New Maintenance Request
        </h2>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-heading text-primary me-1"></i> Title
                        </label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="e.g., Broken Air Conditioner" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-align-left text-primary me-1"></i> Description
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="4" placeholder="Describe the issue in detail..." required></textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i> Location
                        </label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                               placeholder="e.g., Room 301, Lobby, Elevator B" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-exclamation-triangle text-primary me-1"></i> Urgency Level
                        </label>
                        <select name="urgency" class="form-control @error('urgency') is-invalid @enderror" required>
                            <option value="low">🟢 Low</option>
                            <option value="medium" selected>🟡 Medium</option>
                            <option value="high">🟠 High</option>
                            <option value="critical">🔴 Critical</option>
                        </select>
                        @error('urgency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image text-primary me-1"></i> Image (Optional)
                        </label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Upload a photo of the issue (JPEG, PNG, max 2MB)</small>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i> Submit Request
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
