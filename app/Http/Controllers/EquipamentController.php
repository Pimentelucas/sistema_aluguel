<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Equipament;
use App\Models\EquipamentAvailability;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        $equipament->value = $request->value;
        $equipament->user_id = Auth::user()->id;
    

        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            
            $requestImage->move(public_path('img/equipaments'), $imageName);

            $equipament->image = $imageName;
        }

        $equipament->save();

        return redirect('/')->with('msg', 'equipamento criado com sucesso!');
    }

    public function show($id)
    {
        $equipament = Equipament::findOrFail($id);

        $user = Auth::user();
        $hasUserJoined = false;

        $reservations = EquipamentAvailability::where('equipament_id', $equipament->id)->get();

        $reservedDates = [];
            foreach ($reservations as $reservation) {
                $period = CarbonPeriod::create(
                    Carbon::parse($reservation->start_date),
                    Carbon::parse($reservation->end_date)
                );                
                foreach ($period as $date) {
                    $reservedDates[] = $date->format('Y-m-d');
                }
                
            }

        if ($user) {
            $hasUserJoined = $equipament->users()->where('user_id', $user->id)->exists();
        }
        

        $equipamentOwner = User::where('id', $equipament->user_id)->first()->toArray();

        return view('equipaments.show', ['equipament' => $equipament, 'equipamentOwner' => $equipamentOwner, 'hasUserJoined' => $hasUserJoined, 'reservedDates' => $reservedDates]);

      
    }

    public function destroy($id)
    {
        $equipament = Equipament::findOrFail($id);
        
        if(Auth::user()->id !== $equipament->user_id) {
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para excluir este equipamento!');
        }
        $equipament->delete();
        
        return redirect('/dashboard')->with('msg', 'Equipamento excluído com sucesso!');
    }

    public function update(Request $request)
    {
        $data = $request->all();

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/equipaments'), $imageName);

            $data['image'] = $imageName;

        }

        Equipament::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Equipamento editado com sucesso!');
    }
    public function edit($id)
    {
        $equipament = Equipament::findOrFail($id);

        if(Auth::user()->id !== $equipament->user_id) {      
            return redirect('/dashboard')->with('msg', 'Você não tem permissão para editar este equipamento!');
        }
        return view('equipaments.edit', ['equipament' => $equipament]);

    }

        
    

    public function reserve(Request $request) {
        // Validação básica
        $request->validate([
            'equipament_id' => 'required|exists:equipaments,id',
            'data_range' => 'required|string'
        ]);

        // Dividir intervalo (ex: "2025-08-10 to 2025-08-13")
        [$startDate, $endDate] = explode(' to ', $request->data_range);

        $start = Carbon::createFromFormat('d/m/Y', trim($startDate));
        $end = Carbon::createFromFormat('d/m/Y', trim($endDate));

        // Verifica se já existe reserva com sobreposição de datas para o mesmo equipamento
        $hasConflict = EquipamentAvailability::where('equipament_id', $request->equipament_id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return redirect()->back()->with('error', 'Este equipamento já está reservado nesse período.');
        }

        // Criar nova indisponibilidade
        EquipamentAvailability::create([
            'equipament_id' => $request->equipament_id,
            'user_id' => auth()->id(),
            'start_date' => $start,
            'end_date' => $end,
        ]);

        return redirect()->back()->with('success', 'Reserva realizada com sucesso!');
    }

    public function getReservations($id) {
        $reservations = EquipamentAvailability::where('equipament_id', $id)
            ->get(['start_date as start', 'end_date as end']);

        $equipaments = $reservations->map(function ($reservation) {
            return [
                'title' => 'Reservado',
                'start' => $reservation->start,
                'end' => Carbon::parse($reservation->end)->addDay(), // FullCalendar exige end exclusivo
                'color' => 'red',
            ];
        });

        return response()->json($equipaments);
    }
    public function dashboard() {
        $user = Auth::user();

        $equipaments = $user->equipaments;
        $equipaments = Equipament::all();

        return view('dashboard', compact('equipaments'));

    }

    public function render()
    {
        $userId = Auth::id();

        // Equipamentos criados pelo usuário
        $createdEquipaments = Equipament::where('user_id', $userId)->get();

        // Equipamentos alugados pelo usuário
        $rentedEquipaments = Equipament::whereHas('availabilities', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return view('dashboard', [
            'equipaments' => $createdEquipaments->merge($rentedEquipaments)
        ]);
    }



    
}
