@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-6 text-center">
            <h1>Create Users</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-8 mx-auto">
            <form method="POST" id="create-user">

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" placeholder="Enter Name" required autocomplete="name" autofocus>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" placeholder="Enter Email Address" required autocomplete="email">
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password" required autocomplete="new-password">
                    </div>
                </div>

                <p>Choose User Role</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Writer" checked>
                    <label class="form-check-label" for="inlineRadio1">Writer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" value="Viewer">
                    <label class="form-check-label" for="inlineRadio2">Viewer</label>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary form-control">
                            Create User
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

            checkAuthFor(roles.admin);

            $('#create-user').submit(function(e){
                e.preventDefault();

                createNewUser('create-user');
            });
        });
    </script>
@endpush
