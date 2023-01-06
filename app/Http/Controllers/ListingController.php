<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

// this custom sub-class of the controller super-class takes several functions relating to uri validation and routing. Essentially, it acts as a (re)-deployable abstract class/interface that can be used to undertake the routing that was previously done with 'hard coded' routed via the routs directory. To do so we simply pass the routing actions that were previously written into the relevant route directory files into this more abstract controller that will then direct user URI requests to the relevant view (while fetching/updating the models/incoming data) for that view.

// NOTE however that we have to use the router anyways... the difference is that now, instead of hard coding into the router the routes we want to present to our user, we can instead deploy a reference to our custom controller class.
class ListingController extends Controller
{
    /* note the convention for route-paths: 
    - index for splash page/home
    - show to load up a single view from DB
    -Create 
    - Store
    - Update
    - Edit
    - Destroy   (for crud+ functionatility)   
    */
//SHOW ALL Listings
    public function index(){
          return view('listings.index', [
            "listings" => //Listing::all()
            //replace all() method with an inbuilt latest() function followed by further to get the latest database entry: 
            //Listing::latest()->get()
            //further construct now works with a tag filter in between the latest() and get() meths. in other words... database fetch the latest data() but then go through a filter(request which GETs an existing or new resources[then pass the tag/s array which can have one or more elements - therefore searching by hashtag produces relevant tagged database records])  with the passed tag in the case a tag has been passed and then finally fetch me the data via httpGET
            // note that using filter() will automatically be parsed by Laravel's Eloquent ORM into the filter method that we have defined in the Listing class...
            //note also that, alongside tag, we can now add a second arg to request() which is the 'search' uri ? arg parameter.
            Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
            // note this was previously done with ->get() but now we use ->paginate() to allow pagination. paginate eloquent meth takes a number in arg1 which is the number of elemens we expect to show per page.
            // bute note that we need to create a front end div with the next-page and previous and numbered page elements to navigate the paginated results. we can do so using in index blade view.
        ]);
    }
    // SHOW ONE
       //show one  lsting
       function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
          ]);
    }
//CRUD
    //Create a job  posting 
    public function create(Listing $listing){
        // return the listings.create view which is it's own blade view.
        return view('listings.create');
    }
    //Store a created posting to SQL
    // note that the Request object in arg1 inherits from request class and is a dependency injection of that class with $request  being the placeholder var for any call to the store() method. Note that that call has been made in the web router's POST route for '/listings' which was itself hailed when the user filled in the form (and on submission the form's action was to hail /listings which was routed to this ListingController::store() method)
    public function store(Request $request){
        //dd($request->all());
        // first use the validate helper method to validate the form input (we create a formFields custom var that will hold the incoming array of submitted data (that has been validated)):
            # we create a container var formFields which will contain the array that is being transmitted by POST. Not also the use of inbuild dependency injected validation methods via Illuminate's HTTP\Request superclass.
            // to accept iconest, we use the file() illuminate meth and then the store meth which takes the default storage disk to store uploaded http request file (in public since we have changed the default in confie storage setting)
        //dd($request->file('logo')->store());
        $formFields = $request->validate([
            // note that here we add two validation filtering conditions to the company field. required as usual but also the magicmethod/helper unique(requirement) in which we set the table (listings) and make this company key-column record a unique one ... this is done as part normalisation of the SQL data to avoid overlapping inputs (in this case only one company can post jobs per account to avoid confusion)
            //'id' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'title' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);
        // check if logo has been uploaded
        if($request->hasFile('logo')){
            // set the value of the formfields data field  as the path of the file that is being uploaded (this file path and the file itself as simultaenously given here by the file() method which takes a file upload via http and the store() method, which sets it into the designated folder (files) within the -now defaulted to public- storage directory of the laravel project directory)
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        // here we also ensure that every time a listing is created, it also has a record-row value inputted for the foreign-key user_id column on the SQL listings table which associates it to a given existing user in the users table (on the basis of that shared user_id key-column value)
        // we assign value of the formFields listings class object container var (filled in by incoming post data from form on front end). That assigned value uses the authenticable superclass authentication check method on the id() method which is a method within the guard class under the scope of the authenticable superclass
        $formFields['user_id']= auth()->id();
        // also deploy the inbuilt create instant (instantiation of an instance object of our Listing model) which is inherited from the Model.php superclass.
        // REMEMEBR TO INCLUDING THE formeField container var OR THE create() method will be empty of any input, throwing an SQL 1364 error
        Listing::create($formFields);
        // return back to home upon submission note the use of the ->with directive that specified that a session flash message should be shown on the index page upon redirect to show user that the new entry has correctly been placed in the db/website. Note that this just deals iwth the backend of generating this message...the front end aspect is dealwith in a component (flash-message) which is injected with this message and itself injects into the / index view
        return redirect('/')->with('message', 'Success! Listing Created.');
    }
// SHOW EDIT FORM
    public function edit(Listing $listing){
    if($listing->user_id != auth()->id()){
        abort(403, '403 Unauthorised');
    }
        return view('listings.edit', ['listing'=>$listing]);
    }
// UPDATE
public function update(Request $request, Listing $listing){
    // this auth guard check ensures that any logged in user is only able to update a listing that is associated to them via a foreign_key relationship to their account- thus blcoking them from updating/editing another account's listings.
    // we crate an if conditional check looking for the listing container var (which is a wrapper holding the post'd data, in this case relating to editing) and takes its user_id inputted data. if that data is not matching the auth() guard's id() fetching method then use illuminated abort( with a 403 http code and message)
    if($listing->user_id != auth()->id()){
        abort(403, '403 Unauthorised');
    }
    $formFields = $request->validate([
        'company' => 'required',
        'title' => 'required',
        'location' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required',
        'description' => 'required',
    ]);
    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos', 'public');
    }
    $listing->update($formFields);
    return back()->with('message', 'Listing Successfully Edited.');
    }

//DELETE
    public function destroy(Listing $listing){
        // as with update, we check for listing being FKeyd relationd with the particular user.
        if($listing->user_id != auth()->id()){
            abort(403, '403 Unauthorised');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing Deleted');
    }
    // manage lsitings controller
    // note that the listings.manage arg1 for the view will demonstrate all of the logged in user's asssociate (SQL foreignkey based association to listings table) listings items. To do this, we use the auth guard check, chained on folloed by a chained user() method which passes the authguard's related user id then chained followed by the Listing models' listings() method which this $listing object instance of the Listings class's related one-to-many listings found in the SQL FK user_id records and then fetched them with get() to display them in the route.
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
        // note intelephense doesnlt like the listings() method being chained on because it is looking for that method in the auth namespace. but actually we import it at the top of source code from the User Model which has this method fetching particular authenticated user's foreign-key associated listings on SQL listings table
    }
}
