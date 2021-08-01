@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-6 text-center">
            <h1>Create Post</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-8 mx-auto">
            <form method="POST" id="create-post">

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control" name="title" placeholder="Post Title" required >
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="content" type="text" class="form-control" name="content" placeholder="Post Details" required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary form-control">
                            Create Post
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

            checkAuthFor(roles.writer);

            $('#create-post').submit(function(e){
                e.preventDefault();

                $(`form[id=create-post]`).append(`<input name='user_id' hidden value="${getCookie('auth_id')}">`);

                createNewPost('create-post');

            });
        });
    </script>
@endpush
