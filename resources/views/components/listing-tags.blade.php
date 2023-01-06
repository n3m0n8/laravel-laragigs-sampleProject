{{--We create another component that will hold a wrapper to be deployed multiple times- in this case the search tags.
    The most efficient way to use the tags is to store them on the SQL database and then deploy them as relevant. we do this by destructuring the tags otu of their single container (on mysql they are held as array members of an array named 'tags'. We destructure by deploying the @props directive which will tell the blade template to await data coming in via the a custom %tagsCSV variable (named csv since it is made up of comma separated values)--}}
@props(['tagsCSV'])
{{--We then deploy the php tags as to deploy a method to iterate through the array to get each relevant tag to present for each relevant post)--}}
@php 
    // create a custom var that will represent the incoming data being brought in from mysql and then we will create the singular tag var element so  as to loop through each csv element. 
    //before looping, we need to destructure the CSV array using the explode() php method with arg1 bein[g the sepaparator, which in this case is simply the comma delimiter]
    $htmlTags = explode(',', $tagsCSV); 
@endphp
    <ul class="flex-wrap">
@foreach($htmlTags as $tag)
        <li class="inline-block items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs max-w-fit"
        >
        {{--note also we pass the relevant tag into the url redirect for when we create the further pages associated with searchs for tags--}}
            <a href="/?tag=%20{{$tag}}">{{$tag}}</a>
        </li>
@endforeach
    </ul>
