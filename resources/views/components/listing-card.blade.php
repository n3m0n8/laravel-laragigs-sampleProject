{{--Define a prop in order import the $listing variable's value to the listing property used here. --}}
@props(['listing'])
<x-card >
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}" alt=""/>
        <div>
            <h3 class="text-2xl"><a href="/listings/{{$listing->id}}">{{$listing->title}}</a></h3>
            <div class="text-xl font-bold mb-4">{{$listing->company}} 
            </div>
            {{--1. inject the listing-tags blade view component. 2. use the pointer to direct that component to understand that tagsCSV within it is to be filled with the database array coming in under the $listing object created by $Listing model factory and specifying its $tags elements--}}
            <x-listing-tags :tagsCSV="$listing->tags" />
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i>{{$listing->location}}
            </div>
        </div>
    </div>
</x-card >