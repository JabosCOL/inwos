<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Permite el acceso solo a usuarios autentificados y con el rol administrador.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Muestra todos los usuarios existentes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::paginate(10),
            'auth' => Auth::user()->role,
        ]);
    }

    /**
     * Muestra el formulario para editar un usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    /**
     * Recibe el request para modificar un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, SaveUserRequest $request)
    {
        $user->update($request->validated());
        Return redirect()->route('admin.users.index')
        ->with('status', __('The user has been updated successfully'));
    }

    /**
     * Elimina un usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
        ->with('status', __('The user was deleted successfully'));
    }
}
