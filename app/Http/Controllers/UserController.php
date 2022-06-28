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
     * Envia los datos del usuario a la vista de personalización del usuario.
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

    /**
     * Muestra el formulario para reestablecer la contraseña.
     */
    public function resetPasswordForm()
    {
        return view('user.resetpassword');
    }

    /**
     * Procesa el request para almacenar la nueva contraseña.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new CheckPassword],
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with("status", trans("Password changed successfully"));
    }

    /**
     * Procesa el request para actualizar la imagen del usuario.
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
     * Elimina la foto de perfil del usuario.
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
     * Elimina la cuenta del usuario.
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
