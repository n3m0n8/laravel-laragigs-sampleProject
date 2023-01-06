{{--if conditional checks that a session helper has deployed - in this case the specific 'message' session object created on the backend ListingController's store methd--}}
@if(session()->has('message'))
{{--Note use of alpine JS functionality here... the library has been imported into the layout view and now we can use it to set a time out for this session message. We put the property of show to true but have timeout condition on it to make it disappear and not clog the index page (upon a successful form entry)--}}
    <div {{--x-data (i.e. laravel component x's data - in this case relating to that x component's show property is set to a starting condition of TRUE)--}}x-data="{show: true}" {{--we create a timeout function that starts the count upon x component being initialised. it has a callback function that has a timeout on the show property value changing it to false after 3 seconds--}} x-init="setTimeout(()=> show = false, 3000)" {{--we set the state of the show property to be whatever show is. Upon first loading state, the data is set at true. but after 3 seconds its changed to false--}} x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py-3">
        {{--session object is deployed here.--}}
        <p>{{session('message')}}
        </p>
    </div>
@endif




{{----}}
