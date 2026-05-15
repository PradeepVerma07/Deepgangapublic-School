@extends('admin.layouts.app')
@section('title', $title)
@section('comp', 'section')
@section('css')
<style>
    #editor-content, #images-pdf-fields {
        display: none;
    }
    .file-row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .file-row input[type="text"] {
        margin-right: 10px;
    }
    .file-row input[type="file"] {
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Create Section</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.sections.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="menu_id" class="form-label required">Menu</label>
                        <select class="form-control @error('menu_id') is-invalid @enderror" id="menu_id" name="menu_id">
                            <option value="">Select Menu</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>{{ $menu->title }}</option>
                            @endforeach
                        </select>
                        @error('menu_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="type" class="form-label required">Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">Select Type</option>
                            <option value="editor" {{ old('type') == 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="images_pdf" {{ old('type') == 'images_pdf' ? 'selected' : '' }}>Images/PDF</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mb-3" id="editor-content">
                    <div class="form-group">
                        <label for="content" class="form-label required">Content</label>
                        <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mb-3" id="images-pdf-fields">
                    <div class="form-group">
                        <label class="form-label required">Files</label>
                        <div id="file-rows">
                            <div class="file-row row">
                                <div class="col-lg-5">
                                    <input type="text" class="form-control @error('headings.0') is-invalid @enderror" name="headings[]" placeholder="Heading" value="{{ old('headings.0') }}">
                                </div>
                                <div class="col-lg-4">
                                    <input type="file" class="form-control @error('files.0') is-invalid @enderror" name="files[]" accept="image/*,.pdf">
                                </div>
                                <div class="col-lg-3">
                                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                    <button type="button" class="btn btn-primary btn-sm" id="add-row">Add More</button>
                                </div>
                            </div>
                        </div>
                        @error('headings.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('files.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', 0) }}" min="0">
                        @error('seq')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 300
        });

        function toggleFields() {
            var type = $('#type').val();
            if (type === 'editor') {
                $('#editor-content').show();
                $('#images-pdf-fields').hide();
            } else if (type === 'images_pdf') {
                $('#editor-content').hide();
                $('#images-pdf-fields').show();
            } else {
                $('#editor-content').hide();
                $('#images-pdf-fields').hide();
            }
        }

        function updateFileRowButtons() {
            var $fileRows = $('#file-rows .file-row');
            $fileRows.each(function(index) {
                var $buttonContainer = $(this).find('.col-lg-3');
                $buttonContainer.empty(); // Clear existing buttons

                // If this is the last row, show only "Add More" button
                if (index === $fileRows.length - 1) {
                    $buttonContainer.append('<button type="button" class="btn btn-primary btn-sm add-row">Add More</button>');
                } else {
                    // Otherwise, show only "Remove" button
                    $buttonContainer.append('<button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>');
                }
            });
        }

        toggleFields();
        $('#type').change(toggleFields);

        $(document).on('click', '.add-row', function() {
            var newRow = `
                <div class="file-row row mt-2">
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="headings[]" placeholder="Heading">
                    </div>
                    <div class="col-lg-4">
                        <input type="file" class="form-control" name="files[]" accept="image/*,.pdf">
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>`;
            $('#file-rows').append(newRow);
            updateFileRowButtons();
        });

        $(document).on('click', '.remove-row', function() {
            var $fileRows = $('#file-rows .file-row');
            if ($fileRows.length > 1) {
                $(this).closest('.file-row').remove();
                updateFileRowButtons();
            }
        });
        updateFileRowButtons();
    });
</script>
@endpush
