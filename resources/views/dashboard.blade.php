<x-app-layout>
    <x-slot name="header">
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
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                           <a href="{{route('blogs.create')}}">Create  </a>
                           <br>
                           <a href="{{route('blogs.index')}}">All Blogs </a>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
