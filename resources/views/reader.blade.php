@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reader's Dashboard</div>

                <div class="card-body">

                    <a href="{{route('post.all')}}" class="btn btn-primary">All Post</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            checkForReader();
        });
    </script>
@endpush
