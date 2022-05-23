<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\CheckPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return view('user.index', [
            'user' => $user
        ]);
    }

    public function resetPasswordForm()
    {
        return view('user.resetpassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new CheckPassword],
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = auth()->user();
        // change Password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with("status", trans("Password changed successfully"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('services.myServicesShow', [
            'service' => $service,
            'user_id'=> $service->user_id,
            'auth_id'=> auth()->user()->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        $user = User::where('id', auth()->user()->id)
            ->first();
        $path = '/storage/images/users';
        $image = $request->file('image');
        $new_image_name = 'UIMG' . date('Ymd') . uniqid() . '.jpg';
        $image_db_url = 'images/users/' . $new_image_name;
        $upload = $image->move(public_path($path), $new_image_name);
        if ($upload) {
            $oldPicture = 'storage/'. $user->image;
            \File::delete(public_path($oldPicture));
            $user->update(['image' => $image_db_url]);
            return response()->json(['status' => 1, 'msg' => trans('Image has been updated successfully.')]);
        } else {
            return response()->json(['status' => 0, 'msg' => trans('Something went wrong, try again later')]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(User $user)
    {
        $oldPicture = 'storage/' . $user->image;
        \File::delete(public_path($oldPicture));
        $user->update(['image' => NULL]);

        return redirect()->back()
            ->with('status', trans('The photo was deleted sucessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Storage::delete('public/' . $user->image);

        $user->delete();

        return redirect()->route('/')
        ->with('status', trans('The user was deleted'));
    }
}
