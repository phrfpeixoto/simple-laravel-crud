<?php

namespace App\Http\Controllers;

use App\History;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SimpleController extends Controller
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
        if(!auth()->check()){
            flash(trans('Please login to manage the State list'), 'info');
        }
        return view('state.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param State $state
     * @return \Illuminate\Http\Response
     */
    public function auditState(State $state)
    {
        $records = History::where('state_id', $state->id)->get();
        return view('state.audit', compact('state', 'records'));
    }

    public function audit()
    {
        $records = History::all();
        return view('general.audit', compact('records'));
    }

    public function users()
    {
        return view('general.users');
    }
}
