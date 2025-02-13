<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserInterface $userRepository;
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $users = $this->userRepository->all_items();
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            $users = null;
        }
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): object
    {
        try {
            $user->delete();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }

    public function restore(User $user): object
    {
        try {
            $user->restore();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }
}
