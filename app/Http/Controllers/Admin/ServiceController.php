<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveServiceRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    /**
     * Permite el acceso solo a usuarios autentificados y con el rol administrador.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Muestra todos los servicios existentes.
     */
    public function index()
    {
        return view('admin.services.index', [
            'services' => Service::paginate(10)
        ]);
    }

    /**
     * Muestra el formulario para crear un servicio.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create', [
            'service' => new Service,
            'categories' => Category::pluck('name', 'id'),
            'cities' => City::pluck('name', 'id'),
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * Recibe el request para almacenar el nuevo servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveServiceRequest $request)
    {
        $service = new Service($request->validated());

        $service->image = $request->file('image')->store('images', 'public');

        $service->save();

        $image = Image::make(Storage::get('public/' . $service->image))
            ->widen(600)->limitColors(255)->encode();

        Storage::put('public/' . $service->image, $image);

        return redirect()->route('admin.services.index')->with('status', __('The service has been created successfully'));
    }

    /**
     * Muestra el servicio seleccionado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('admin.services.show', [
            'service' => $service,
            'user_id' => $service->user_id,
            'auth_id' => auth()->user()->id
        ]);
    }

    /**
     * Muestra el formulario para editar un servicio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', [
            'service' => $service,
            'categories' => Category::pluck('name', 'id'),
            'cities' => City::pluck('name', 'id'),
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * Recibe el request para actualizar un servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Service $service, SaveServiceRequest $request)
    {

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $service->image);

            $service->fill($request->validated());

            $service->image = $request->file('image')->store('images', 'public');

            $service->save();

            $image = Image::make(Storage::get('public/' . $service->image))
                ->widen(600)->limitColors(255)->encode();

            Storage::put('public/' . $service->image, (string) $image);
        } else {
            $service->update(array_filter($request->validated()));
        }

        return redirect()->route('admin.services.show', $service)
            ->with('status', __('The service has been updated successfully'));
    }

    /**
     * Elimina un servicio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        Storage::delete('public/' . $service->image);

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('status', __('The service was deleted'));
    }
}
