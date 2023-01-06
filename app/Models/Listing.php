<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    //Note, when we allow user input via a form into the database, Illuminate\eloquent excersises a guard on the mass assignment of inputs into a database The term use here for 'exceptions' to this rule is that the variables that are considered acceptable to be 'filled in' or POSTd to the database are to be designated as such .There are different ways to achieve this. We can manually do so uing an array within a special $fillable variable where we list the fields/inputs that are acceptable for mass assignment like so: 
    // protected $fillable = ['title', 'company', 'location', 'email', 'description', 'tags'];

    //alternatively, we can turn off guard mode by going to the App/Providers/AppServiceProvider and adding to the boot function() a disclaimed of the guard method. This is the option used by Traversy in this tutorial.

    // create the hashtag filter query function
    public function scopeFilter($query, array $filters){
        // construct to destructure the tags [array] as it comes in from the database and then check if a relevant tag has been passed into the url query so as to throw up relevant hits. 
        // 1 create empty array called filters.
        // conditional if, if we hava hit on the destructure tags array incoming from DB  then ...
        //second op of the terneray operator redirect with tag valu 
        // or third operation of the ternary which just does null since value is false
        if($filters['tag'] ?? false ){
            // now we are in SQL instructions querying our database. We are saying where in the tags column we find values LIKE anything that regexp starts (%) and ends(%). Within the regexp we are passing laravel's request() method which r etrieves the specified url element in this case the bit of the query under a ?tag%= identifier (that identifier is already hard coded on the listing-tags.blade.php view i.e. it generates a webpage on basis of tag passed after %20)
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }
    // now we can also add the search scopeFilter, which will basically do the parallel job of the tag filter above although now we use SQL WHERE TITLE: 
        if($filters['search'] ?? false ){
            $query->where('title', 'like', '%' . request('search') . '%')
            // but we don't need to search only title. we can OR WHERE for other key/column records to fetch:
                ->orWhere('location', 'like', '%' . request('search') . '%') 
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('company', 'like', '%' . request('search') . '%');
        }
    }
    // function creating a BELONGS TO SQL relationship between the listings items in listings table and the users records/rows.
    // uses the Eloquent belongsTo helper ()
    // $this refers to this instance of a listing object under the scope of this present Listing.php class
    // belongs to attachs this instance to the instance ofthe User Model class's that is passed in via the SQL user_id foreignkey-column record/row that has been fetched.
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
