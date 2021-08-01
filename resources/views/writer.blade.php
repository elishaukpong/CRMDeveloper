@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Writer's Dashboard</div>

                <div class="card-body">

                    <a href="{{route('post.all')}}" class="btn btn-primary">All Post</a>
                    <a href="{{route('post.create')}}" class="btn btn-dark">Create Post</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function (){
            checkAuthFor(roles.writer);
        });
    </script>
@endpush
