<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @auth
                @if(Auth::user()->role_id==="1")
                   Welcome! Admin
                @else
                   Welcome!  User
                @endif
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @endauth
            @guest
                <a href="{{route('login')}}">Login</a>
                <br>
                <a href="{{route('register')}}">Register</a>
            @endguest
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                       <div class="row">
                            @foreach($Blogs as $Blog)
                              <div class="row">
                                 <div class="col-xs-12 col-sm-9 col-md-9">
                                    <div class="list-group">
                                       <div class="list-group-item">
                                          <div class="row-picture">
                                             <a href="{{asset('blogimages/'.$Blog->image)}}" title="sintret">
                                             <img src="{{asset('blogimages/'.$Blog->image)}}" width="200" class="circle img-thumbnail img-box"  alt="image">
                                             </a>
                                          </div>
                                          <div class="row-content">
                                             <div class="list-group-item-heading">
                                                <a href="#" title="sintret">
                                                <small>{{$Blog->title}}</small>
                                                </a>
                                             </div>
                                             <small>
                                             <i class="glyphicon glyphicon-time"></i> {{ \Carbon\Carbon::parse($Blog->created_at)->diffForHumans() }} via <span class="twitter"> <i class="fa fa-twitter"></i> <a target="_blank" href="https://twitter.com/sintret" alt="sintret" title="sintret">{{@$Blog->User->first_name}}</a></span>
                                             <br>
                                             @auth
                                                <a href="{{route('blogs.edit',$Blog->id)}}">Edit</a>
                                                <br>
                                                <a href="{{route('blogstatuschange',$Blog->id)}}">  @if($Blog->status=='1')
                                                    Active
                                                   @else
                                                    InActive 
                                                  @endif                                              </a>
                                                <form action="{{route('blogs.destroy',$Blog->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit">Delete</button>
                                                </form>
                                             @endauth   
                                          </div>
                                       </div>
                                    </div>
                                    <h4>{{$Blog->title}}</h4>
                                    <p>{{$Blog->description}}</p>
                                 </div>
                              </div>
                            @endforeach
                            <hr>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>