{{-- injects the layout blade view template--}}
@extends('../components/layout')
{{-- section points to the layout blade view's yielded bladeViewContent section--}}
@section('bladeViewContent')
{{----}}
@include('partials/_search')
<a href="/" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back To All Jobs
</a>
            <div class="mx-4">
                {{--Note here that we have used the eloquent attributes accessor magic meth, based on __getAtttribute as well as the merge() collections methods and therefore we can deploy further custom tailwind classes that will be 'fetched' and merged into the card blade view for this wrapper.. in this case adding some padding 10pixels--}}
                <x-card >
                    <div class="flex flex-col items-center justify-center text-center">
                        <img class="w-48 mr-6 mb-6"
                            src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}"
                            alt=""/>
                        <h3 class="text-2xl mb-2">{{$listing->title}}</h3>
                        <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
                        <x-listing-tags :tagsCSV="$listing->tags" />
                        <div class="text-lg my-4">
                            <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
                        </div>
                        <div class="border border-gray-200 w-full mb-6"></div>
                        <div>
                            <h3 class="text-3xl font-bold mb-4">
                                Job Description
                            </h3>
                            <div class="text-lg space-y-6">
                                <p>{{$listing->description}}
                                </p>
                                <a href="mailto:test@test.com" class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80"><i class="fa-solid fa-envelope"></i>Contact Employer</a>
                                <a href="https://test.com" target="_blank" class="block bg-black text-white py-2 rounded-xl hover:opacity-80"><i class="fa-solid fa-globe"></i> Visit Website</a>
                            </div>
                        </div>
                    </div>
                </x-card >
                {{--<x-card class="mt-4 p-2 flex space-x-6">
                    <a href="/listings/{{$listing->id}}/edit">
                    <i class="fa-solid fa-pencil"></i>&nbsp Edit
                    </a>
                    <form method="POST" action="/listings/{{$listing->id}}">
                        @csrf
                        {{--helper method for DELETE HTTP flag (we put POST in method because we can't use UPDATE/PUT/DELETE on the HTML side but elquent's helper allows us to tell the POST that this is for DELETE operation--}
                        @method('DELETE')
                        <button class="text-red-600">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </x-card>--}}
            </div>
@endsection