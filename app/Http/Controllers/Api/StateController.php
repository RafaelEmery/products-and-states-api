<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\StateCollection;
use App\Models\State;

class StateController extends Controller
{
    private $states;

    public function __construct(State $states)
    {
        $this->states = $states;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed;
     */
    public function index()
    {
        try {
            if (($states = $this->states::all())->count() === 0) {
                return response()->json(['message' => 'No states on database!'], 404);
            }

            return new StateCollection($states);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
