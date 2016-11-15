<?php

namespace App\Http\Controllers;

use App\History;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        return compact('states');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $state = DB::transaction(function() use ($request) {
                $user_name = auth()->user()->name;
                $state = State::create($request->only(['name', 'short_name']));
                $entry = trans("User {$user_name} created State {$state->name} ({$state->short_name})");
                History::create(['state_id' => $state->id, 'entry'=>$entry]);
                return $state;
            });
            return compact('state');
        }
        catch(\Exception $e){
            return Response::json([
                'message' => $e->getMessage()
            ])->setStatusCode(200, 'Error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param State $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        try {
            $name = $request->get('name');
            $short_name = $request->get('short_name');
            $state = DB::transaction(function() use ($request, $state, $name, $short_name) {
                $user_name = auth()->user()->name;
                $entry = trans("User {$user_name} updated State from {$state->name} ({$state->short_name}) to ".
                    "{$name} ($short_name)");

                $state->name = $name;
                $state->short_name = $short_name;
                $state->save();

                History::create(['state_id' => $state->id, 'entry'=>$entry]);
                return $state;
            });
            return compact('state');
        }
        catch(\Exception $e) {
            return Response::json([
                'message' => $e->getMessage()
            ])->setStatusCode(200, 'Error');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, State $state)
    {

        DB::transaction(function() use ($request, $state) {
            $user_name = auth()->user()->name;
            $entry = trans("User {$user_name} deleted State {$state->name} ({$state->short_name})");
            History::create(['state_id' => $state->id, 'entry'=>$entry]);
            $state->delete();
        });

        return response()->json();
    }
}
