<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveServiceRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\User;
use App\Models\Survey;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{

    public function __construct()
    {
        // Utilización del middleware auth para dar acceso solo a los usuarios logeados.
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario para la creación de un servicio.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('services.create', [
            'service'=> New Service,
            'categories'=> Category::pluck('name', 'id'),
            'cities'=> City::pluck('name', 'id'),
            'user_id'=> auth()->user()->id

        ]);
    }

    /**
     * Recibe el request para almacenar el servicio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveServiceRequest $request)
    {
        $service = new Service($request->validated());

        $service->image = $request->file('image')->store('images/services', 'public');

        $service->save();

        $image = Image::make(Storage::get('public/'. $service->image))
        ->resize(250, 250)->limitColors(255)->encode();

        Storage::put('public/'. $service->image, $image);

        return redirect()->route('home')->with('status', __('The service has been created successfully'));
    }

    /**
     * Muestra el servicio seleccionado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('services.show', [
            'service' => $service,
            'user_id'=> $service->user_id,
            'auth_id'=> auth()->user()->id
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
        return view('services.edit', [
            'service'=>$service,
            'categories'=> Category::pluck('name', 'id'),
            'cities'=> City::pluck('name', 'id'),
            'user_id'=> auth()->user()->id
        ]);
    }

    /**
     * Actualiza el servicio modificado desde el formulario de edición.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Service $service, SaveServiceRequest $request)
    {

        if($request->hasFile('image'))
        {
            Storage::delete('public/'. $service->image);

            $service->fill($request->validated());

            $service->image = $request->file('image')->store('images', 'public');

            $service->save();

            $image = Image::make(Storage::get('public/'. $service->image))
            ->resize(250, 250)->limitColors(255)->encode();

            Storage::put('public/'. $service->image, (string) $image);

        } else {
            $service->update(array_filter($request->validated()));
        }

        return redirect()->route('service.show', $service)
        ->with('status', __('The service has been updated successfully'));
    }

    /**
     * Elimina el servicio de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        Storage::delete('public/'. $service->image);

        $service->delete();

        return redirect()->route('home')
        ->with('status', __('The service was deleted'));
    }

    /**
     * Muestra los servicios asociados al usuario logeado.
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex()
    {
        $user = auth()->user()->id;

        return view('services.myservices', [
            'services' => Service::where('user_id', '=', $user)->paginate(3)
        ]);
    }

    /**
     * Muestra un servicio especifico del usuario logeado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userShow(Service $service)
    {
        return view('services.myServicesShow', [
            'service' => $service,
            'user_id' => $service->user_id,
            'auth_id' => auth()->user()->id
        ]);
    }

    /**
     * Elimina un servicio del usuario logeado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(Service $service)
    {
        $service->delete();

        return redirect()->route('userServices.index')
        ->with('status', __('The service was deleted'));
    }

    /**
     * Muestra las encuestas de los servicios relacionados al usuario logeado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function surveyIndex()
    {
        $user = auth()->user()->id;
        $ids = Service::where('user_id', '=', $user)->get()->map(function ($services) {
            return $services->id;
        });

        $surveys = Survey::whereIn('service_id', $ids)->paginate(5);

        return view('surveys.index', [
            'surveys' => $surveys
        ]);
    }

    /**
     * Recibe el request del formulario de encuestas para almacenarla en la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function surveyCreate()
    {

        request()->validate([
            'comment' => 'required',
            'serviceQualification' => 'required',
            'filingQualification' => 'required',
        ]);

        $survey = new Survey();
        $survey->service_id = request('service_id');
        $survey->comments = request('comment');
        $survey->service_qualification = request('serviceQualification');
        $survey->filing_qualification = request('filingQualification');
        $survey->save();


        return redirect()->route('home')
        ->with('status', __('The service was qualificated'));
    }
}
