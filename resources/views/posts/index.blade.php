@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-6">
            <h1>All Posts</h1>
        </div>
    </div>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created On</th>
                    <th scope="col">View</th>
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
            populateTableFieldWithPosts($('#body'));
        });
    </script>
@endpush
