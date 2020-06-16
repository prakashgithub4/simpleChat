@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach($users as $user)
                            <li class="user" id="{{ $user->id }}">
                                {{--will show unread count notification--}}
                                @if($user->unread)
                                    <span class="pending">{{ $user->unread }}</span>
                                @endif

                                <div class="media">
                                    <div class="media-left">
                                        <img src="https://thumbs.dreamstime.com/b/faceless-businessman-avatar-man-suit-blue-tie-human-profile-userpic-face-features-web-picture-gentlemen-85824471.jpg" alt="" class="media-object">
                                    </div>

                                    <div class="media-body">
                                        <p>{{ $user->name }}</p>
                                        <p>{{ $user->email }}</p>
                                        <p id="status_{{ $user->id }}">{{$user->is_online}}</p>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="messages">

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
$(document).ready(function(){
    let u_id = "{{Auth::id()}}";
      let url = "{{url('status/')}}"+"/"+u_id+"/"+'active';
     
      $.ajax({
                type: "get",
                url:url , // need to create this route
               
                cache: false,
                success: function (data) {
                 
                }
            });
      //   });
});
</script>
@endsection
