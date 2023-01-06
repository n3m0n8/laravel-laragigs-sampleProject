@extends('../components/layout')
@section('bladeViewContent')

<x-card class="p-6">
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Manage Your Associated Job Listings:
        </h1>
    </header>
    <table class="w-full table-auto rounded-sm max-w-6xl ml-8">
        <tbody>
            {{--Unless conditional, if not empty associated lsitings to this passed user_id.--}}
        @unless($listings->isEmpty())
        {{--if we pass the unless test, then we list all of the relevant listings.--}}
            @foreach($listings as $listing)     
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="show.html">
                       {{$listing->title}}
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/listings/{{$listing->id}}/edit" class="text-blue-400 px-6 py-2 rounded-xl">
                        <i class="fa-solid fa-pen-to-square"
                        ></i>
                        Edit</a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form method="POST" action="/listings/{{$listing->id}}">
                        @csrf
                    {{--helper method for DELETE HTTP flag (we put POST in method because we can't use UPDATE/PUT/DELETE on the HTML side but elquent's helper allows us to tell the POST that this is for DELETE operation--}}
                        @method('DELETE')
                        <button class="text-red-600">
                            <i class="fa-solid fa-trash"></i>
                                Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            {{--if unless conditional is met (and therefore no listings are found, the else conditional kicks in andwe list no found listings in the table--}}
        @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <p class="text-center">No Listings Associated with your acocunt</p>
                </td>
            </tr>
            {{--end of the unless laravel directive --}}
        @endunless       
        </tbody>
    </table>
</x-card>



@endsection