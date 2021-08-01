@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <a href="{{route('user.all')}}" class="btn btn-primary">All User</a>
                    <a href="{{route('user.create')}}" class="btn btn-dark">Create User</a>
                    <a href="{{route('user.changerole')}}" class="btn btn-secondary ">Change User Role</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            checkAuthFor(roles.admin);
        });
    </script>
@endpush



