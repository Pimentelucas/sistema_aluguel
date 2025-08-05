<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipament;

class EquipamentController extends Controller
{
    public function index()
    {
        $search = request('search');

        if($search) {
            $equipaments = Equipament::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        }else{
            $equipaments = Equipament::all();
        }    

        return view('welcome', ['equipaments' => $equipaments, 'search' => $search]);
    }

    public function create()
    {
        return view('equipaments.create');
    }

    public function store(Request $request)
    {
        $equipament = new Equipament;

        $equipament->title = $request->title;
        $equipament->private = $request->private;
        $equipament->description = $request->description;
        //$equipament->items = $request->items;
        $equipament->value = $request->value;
        $equipament->user_id = Auth::user()->id;
        //$equipament->user()->associate(Auth::user());

        
    

        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            
            $requestImage->move(public_path('img/equipaments'), $imageName);

            $equipament->image = $imageName;
        }
        // Save the equipament to the database
        //$equipament->items = $request->items ? json_encode($request->items) : null;
        //$equipament->status = 'available'; // Default status
        //$equipament->price = $request->price; // Optional price

        $equipament->save();

        return redirect('/')->with('msg', 'equipamento criado com sucesso!');
    }

    public function show($id)
    {
        $equipament = Equipament::findOrFail($id);

        $user = Auth::user();
        $hasUserJoined = false;

        if($user) {
            $hasUserJoined = $user->equipamentsAsParticipant->contains($equipament);
        }

        $equipamentOwner = User::where('id', $equipament->user_id)->first()->toArray();

        return view('equipaments.show', ['equipament' => $equipament, 'equipamentOwner' => $equipamentOwner, 'hasUserJoined' => $hasUserJoined]);
       /* $equipament = Equipament::findOrFail($id);

        $user = Auth::user();
        $hasUserJoined = false;

       // if ($user) {
            $hasUserJoined = $equipament->users()->where('user_id', $user->id)->exists();
        }
        if (!$equipament) {
            return redirect('/')->with('msg', 'Equipamento não encontrado!');
        }

        // Optionally, you can also load related data, such as availabilities
        $availabilities = $equipament->availabilities;

        // Return the view with the equipament data
        //return view('equipaments.show', ['equipament' => $equipament, 'availabilities' => $availabilities, 'hasUserJoined' => $hasUserJoined]);
        // For now, just return the equipament data
        // You can create a view for showing the equipament details
        // Example: return view('equipaments.show', compact('equipament'));
        
        // Assuming you have a view named 'equipaments.show'
        // You can create this view to display the equipament details
        // For now, just return the equipament data
        // Example:
        // return view('equipaments.show', ['equipament' => $equipament]);
        
        // If you have a specific view for showing equipaments, use that
        // Otherwise, you can create a simple view to display the equipament details    
        
        //return view('equipaments.show', ['equipament' => $equipament]);*/
    }

    public function destroy($id)
    {
        // Logic to delete a specific equipment
    }

    public function edit($id)
    {
        // Logic to edit a specific equipment
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific equipment
    }
}
