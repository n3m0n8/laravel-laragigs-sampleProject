{{--we will import the layout blade html template first via the extends directive--}}
@extends('../components/layout')
{{--Dont forget to wrap this blade view's contents into the appropriate section... and the section must be ended with a directive also--}}
@section('bladeViewContent')
@include('partials/_hero')
@include('partials/_search')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
@unless (count($listings) == 0)
@foreach ($listings as $listing) 
{{--Here, instead of cluttering the main views page, we inject the component using x-component-name. Then we clarify that the listing property(using : as a pointer) in that component's html is to be given the value of the $listing variable that we are importing for this blade view overlay.--}}
<x-listing-card :listing="$listing" />
@endforeach
@else
    <p>Sorry, no job listings found... Tough times in recession...</p>
@endunless 
</div>
{{--here we inject the links() illuminate function that allows us to deployed the paginated links for our database entries being brought in by ListingController--}}
<div class="mt-6 p-4">
    {{$listings->links()}}
</div>
@endsection 