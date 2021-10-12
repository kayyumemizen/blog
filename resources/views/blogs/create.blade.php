<x-app-layout>
    <x-slot name="header">
        <img src="{{asset('blogimages/1634048140.jpg')}}" width="50" align="image not found">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->role_id==="1")
               Welcome! Admin
            @else
               Welcome!  User
            @endif
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        	<br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                	 <div class="py-12">
				    	@if($errors->any())
							    {{ implode('', $errors->all('<div>:message</div>')) }}
						@endif
                    <form method="POST" action="{{route('blogs.store')}}" enctype="multipart/form-data">
                    	@csrf
					  <div class="form-group">
					    <label for="exampleFormControlInput1">Title</label>
					    <input type="text" class="form-control" name="title" id="exampleFormControlInput1" placeholder="Enter title...">
					  </div>
					  <div class="form-group">
					    <label for="start_date">Start date</label>
					    <input type="date" name="start_date" value="{{old('start_date')}}" class="form-control" id="start_date" >
					  </div>
					  <div class="form-group">
					    <label for="end_date">End date</label>
					    <input type="date" name="end_date" value="{{old('end_date')}}" class="form-control" id="end_date" >
					  </div>
					  <div class="form-group">
					    <label for="exampleFormControlInput1">image</label>
					    <input type="file" name="image" class="form-control" id="image">
					  </div>

					  <div class="form-group">
					    <label for="Description">Description</label>
					    <textarea class="form-control" name="description" id="Description" rows="5">{{old('description')}}</textarea>
					  </div>
					  <button type="submit" class="btn">Save</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>