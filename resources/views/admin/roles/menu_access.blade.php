@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
<style>
    input[type="checkbox"] {
        width: 19px;
        height: 19px;
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }
    .menuaccess .switchery {
        width: 19px;
        height: 19px;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6"><h5>{{ $title }}</h5></div>
                <div class="col-lg-6 text-end">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-danger">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-wrap col-md-12">
                <table class="table table-striped table-bordered base-styl menuaccess">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Menu</th>
                            <th>Add/Update</th>
                            <th>Delete</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody id="propaccess">
                        @foreach($menus as $menu)
                            @if($menu->parent == 0)
                            <tr>
                                <td>
                                    <input type="checkbox" class="switchery" data-size="sm" name="" value="{{ $menu->id }}" id="amenu{{ $menu->id }}"
                                        {{ isset($permissions[$menu->id]) ? 'checked' : '' }}>
                                    <label for="amenu{{ $menu->id }}"></label>
                                </td>
                                <td><span>{{ $menu->title }}</span></td>
                                <td>
                                    <input type="checkbox" class="switchery permissions" data-size="sm" name="add_update" value="{{ $menu->id }}" id="cmenu{{ $menu->id }}"
                                        {{ isset($permissions[$menu->id]) && $permissions[$menu->id]->add_update ? 'checked' : '' }}>
                                    <label for="cmenu{{ $menu->id }}"></label>
                                </td>
                                <td>
                                    <input type="checkbox" class="switchery permissions" data-size="sm" name="trash" value="{{ $menu->id }}" id="umenu{{ $menu->id }}"
                                        {{ isset($permissions[$menu->id]) && $permissions[$menu->id]->trash ? 'checked' : '' }}>
                                    <label for="umenu{{ $menu->id }}"></label>
                                </td>
                                <td>
                                    <input type="checkbox" class="switchery permissions" data-size="sm" name="view" value="{{ $menu->id }}" id="dmenu{{ $menu->id }}"
                                        {{ isset($permissions[$menu->id]) && $permissions[$menu->id]->view ? 'checked' : '' }}>
                                    <label for="dmenu{{ $menu->id }}"></label>
                                </td>
                            </tr>
                            @foreach($menu->children as $child)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="switchery" data-size="sm" name="" value="{{ $child->id }}" id="amenu{{ $child->id }}"
                                            {{ isset($permissions[$child->id]) ? 'checked' : '' }}>
                                        <label for="amenu{{ $child->id }}"></label>
                                    </td>
                                    <td>&nbsp;&nbsp;<span><i class="fas fa-arrow-right"></i> {{ $child->title }}</span></td>
                                    <td>
                                        <input type="checkbox" class="switchery permissions" data-size="sm" name="add_update" value="{{ $child->id }}" id="cmenu{{ $child->id }}"
                                            {{ isset($permissions[$child->id]) && $permissions[$child->id]->add_update ? 'checked' : '' }}>
                                        <label for="cmenu{{ $child->id }}"></label>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switchery permissions" data-size="sm" name="trash" value="{{ $child->id }}" id="umenu{{ $child->id }}"
                                            {{ isset($permissions[$child->id]) && $permissions[$child->id]->trash ? 'checked' : '' }}>
                                        <label for="umenu{{ $child->id }}"></label>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="switchery permissions" data-size="sm" name="view" value="{{ $child->id }}" id="dmenu{{ $child->id }}"
                                            {{ isset($permissions[$child->id]) && $permissions[$child->id]->view ? 'checked' : '' }}>
                                        <label for="dmenu{{ $child->id }}"></label>
                                    </td>
                                </tr>
                                @foreach($child->children as $grandchild)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="switchery" data-size="sm" name="" value="{{ $grandchild->id }}" id="amenu{{ $grandchild->id }}"
                                                {{ isset($permissions[$grandchild->id]) ? 'checked' : '' }}>
                                            <label for="amenu{{ $grandchild->id }}"></label>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<span><i class="fas fa-arrow-right ml-5"></i> {{ $grandchild->title }}</span></td>
                                        <td>
                                            <input type="checkbox" class="switchery permissions" data-size="sm" name="add_update" value="{{ $grandchild->id }}" id="cmenu{{ $grandchild->id }}"
                                                {{ isset($permissions[$grandchild->id]) && $permissions[$grandchild->id]->add_update ? 'checked' : '' }}>
                                            <label for="cmenu{{ $grandchild->id }}"></label>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="switchery permissions" data-size="sm" name="trash" value="{{ $grandchild->id }}" id="umenu{{ $grandchild->id }}"
                                                {{ isset($permissions[$grandchild->id]) && $permissions[$grandchild->id]->trash ? 'checked' : '' }}>
                                            <label for="umenu{{ $grandchild->id }}"></label>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="switchery permissions" data-size="sm" name="view" value="{{ $grandchild->id }}" id="dmenu{{ $grandchild->id }}"
                                                {{ isset($permissions[$grandchild->id]) && $permissions[$grandchild->id]->view ? 'checked' : '' }}>
                                            <label for="dmenu{{ $grandchild->id }}"></label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.menuaccess .switchery').on('change', function(event) {
            var $this = $(this);
            var id = $this.val();
            var name = $this.attr('name');
            var type = event.currentTarget.checked ? 'set' : 'remove';
            var roleId = {{ $role->id }};

            $.ajax({
                url: '{{ route("admin.roles.menu_access.save", $role->id) }}',
                type: 'POST',
                data: {
                    m_id: id,
                    type: type,
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    if (data.res === 'success') {
                        toastr.success(data.msg);
                        if (name === '') {
                            var row = $this.closest('tr');
                            if (type === 'set') {
                                row.find('.permissions').prop('checked', true);
                            } else {
                                row.find('.permissions').prop('checked', false);
                            }
                        }
                    } else {
                        toastr.error(data.msg);
                        if (type === 'set') {
                            $this.prop('checked', false);
                        } else {
                            $this.prop('checked', true);
                        }
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while saving permissions.');
                    if (type === 'set') {
                        $this.prop('checked', false);
                    } else {
                        $this.prop('checked', true);
                    }
                }
            });
        });
    });
</script>
@endpush
