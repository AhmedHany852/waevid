<?php

namespace App\Http\Controllers\AppUser;

use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::guard('app_users')->user()->id;
        $accountType = $request->query('account_type');
        $accounts = AccountType::where('user_id', $userId)
                            ->when($accountType, function ($query) use ($accountType) {
                                return $query->where('account_type', $accountType);
                            })
                            ->get();
        return response()->json($accounts);
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
            $userId = Auth::guard('app_users')->user()->id;

            $data = $request->validate([
                'account_type' => 'required|string',
            ]);

            $data['user_id'] = $userId;

            // Conditional validation based on account type
            if ($request->account_type == 'social') {
                $data = array_merge($data, $request->validate([
                    'phone_number' => 'nullable|string',
                    'account_name' => 'nullable|string',
                    'account_link' => 'nullable|string',
                    'followers_count' => 'nullable|integer',
                    'notes' => 'nullable|string',
                ]));
            } elseif ($request->account_type == 'game') {
                $data = array_merge($data, $request->validate([
                    'game_type' => 'nullable|string',
                    'notes' => 'nullable|string',
                ]));
            } elseif ($request->account_type == 'service') {
                $data = array_merge($data, $request->validate([
                    'service_type' => 'nullable|string',
                    'notes' => 'nullable|string',
                ]));
            }

            $account = AccountType::create($data);
            return response()->json($account, 201);
        }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
