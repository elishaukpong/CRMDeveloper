@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-5">
        <div class="col-8">
        </div>
    </div>

    <div class="row">
        <div class="col-8" id="post"> </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            loadPost($('#post'));

            $(document).on('submit','#comment',function(e){
                e.preventDefault();
                createNewPostComment('comment');
            });

            $(document).on('click','#like',function(e){
                likeUserPost();
            });
        });
    </script>
@endpush
