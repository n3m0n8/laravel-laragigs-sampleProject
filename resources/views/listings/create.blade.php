{{-- layout blade wrapper component followed by the job post view --}}
@extends('../components/layout')
@section('bladeViewContent')
    
    <div class="bg-gray-100 border border-gray-400 p-10 rounded max-w-6xl mx-auto mt-8">
        <a href="/" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back To All Jobs
        </a>
    <header>
        <h2 class="text-2xl font-bold uppercase mb-1">Post a new job listing</h2>
        <p class="mb-4">Post a new job here using the form below.</p>
    </header>
        {{--form with a file upload needs enctype--}}
        <form method="POST" action="/listings" enctype="multipart/form-data">
            {{--this csrf magic helper function is inbuilt and automatically validated/sanities incoming post data from cross-site scripting attacks--}}
            @csrf
            <div class="mb-6">
                <label for="company" class="inline-block text-lg mb-2">Company Name</label>
                <input type="text" class="border border-gray-400 rounded p-4 w-full" name="company" {{--this value old construct allows whatever has been inputted into the form to stay if there is an error in submission, so user doesnt have to fill out EVERY field all over again--}}value="{{old('company')}}"/>
                </div>
                @error('company')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Job Title</label>
                <input type="text" class="border border-gray-400 rounded p-4 w-full" name="title" value="{{old('title')}}" placeholder="Example: Senior Laravel Developer"/>
                </div>
                @error('title')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6">
                <label for="location" class="inline-block text-lg mb-2">Job Location</label>
                <input type="text" class="border border-gray-400 rounded p-4 w-full" name="location" value="{{old('location')}}" placeholder="Example: Remote, Boston MA, etc"/>
                </div>
                @error('location')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Contact Email</label>
                <input type="email" class="border border-gray-400 rounded p-4 w-full" name="email" value="{{old('email')}}"/>
                </div>
                @error('email')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6"> <label for="tags" class="inline-block text-lg mb-2"> Tags (Comma Separated)
                </label>
                <input type="text" class="border border-gray-400 rounded p-4 w-full" name="tags" value="{{old('tags')}} "placeholder="Example: Laravel, Backend, Postgres, etc"/>
                </div>
                @error('tags')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">
                      Company Logo
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />
                @error('logo')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
                </div>
                {{--
                <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2"> Company Logo
                </label>
                <input type="file"
                class="border border-gray-400 rounded p-8 w-full" name="logo"/></div>
                @error('logo')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                --}}
                <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">Job Description
                </label>
                <textarea class="border border-gray-400 rounded p-2 w-full"  name="description" rows="10" placeholder="Include tasks, requirements, salary, etc">{{old('description')}}</textarea>
                </div>
                @error('description')
                <p class="text-red-300 text-s m-1">{{$message}}</p> 
                @enderror
                <div class="mb-6"><button class="bg-laravel text-white rounded py-4 px-6 hover:bg-black">Create Gig
                </button>
                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </div>
@endsection