<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified user profile.
     */
    public function edit()
    {
        return view('profile.edit');        
    }

    /**
     * Update the specified user profile in database.
     */
    public function update(Request $request)
    {
        //Validate request parameters.
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'password_req' => 'required|in:0,1',
            'password' => [
                'required_if:password_req,1',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), 
                'confirmed'
            ],
        ]);

        try{
            
            //Find user to update
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if(isset($request->password_req) && $request->password_req){
                $user->password = Hash::make($request->password);
            }
            $user->save();

            //Redirect if profile updated.
            return redirect()->route('profile.edit')->withSuccess(['Profile Updated.']);
        }
        catch(\Exception $e){
            //Throw exception if profile not updated.
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
