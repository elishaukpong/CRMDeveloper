@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-6">
            <h1>All Users</h1>
        </div>

        <div class="col-6">
            <div class="d-flex justify-content-end">
                <a href="{{route('user.create')}}" class="btn btn-primary">Create User</a>
            </div>
        </div>
    </div>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Created On</th>
                </tr>
            </thead>

            <tbody id="body">

            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){

            checkAuthFor(roles.admin);

            populateTableFieldWithUsers($('#body'));
        });
    </script>
@endpush
