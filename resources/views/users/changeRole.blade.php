@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-8 text-center">
            <h1>Change User's Role</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-8 mx-auto">
            <form method="POST" id="change-role">

                <div class="form-group row">

                    <div class="col-md-6">
                        <select class="custom-select" id="user-list" name="user_id">
                            <option value="" selected>Select User</option>
                        </select>
                    </div>
                </div>

                <p>Choose User Role</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Writer" checked>
                    <label class="form-check-label" for="inlineRadio1">Writer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Viewer">
                    <label class="form-check-label" for="inlineRadio2">Reader</label>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary form-control">
                            Change
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){

            populateSelectFieldWithUsers($('#user-list'));

            $('#change-role').submit(function(e){
                e.preventDefault();

                processUserRoleChange('change-role');
            });
        });
    </script>
@endpush
