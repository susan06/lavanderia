<?php

namespace App\Http\Controllers;

use Auth;
use Settings;
use Illuminate\Http\Request;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Package\PackageRepository;

class ServiceController extends Controller
{
    /**
     * ServiceController constructor.
     * @param 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'delivery_address' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'locations_labels' => 'required',
            'details_address' => 'max:500',
            'date_search' => 'required',
            'time_search' => 'required',
            'date_delivery' => 'required',
            'time_delivery' => 'required',
            'packages' => 'required',
            'special_instructions' => 'max:500',
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ClientRepository $clientRepository, PackageRepository $packageRepository)
    {
        if(Settings::get('working_hours')) {
            $working_hours = json_decode(Settings::get('working_hours'), true);
        } else {
            $working_hours = array();
        }
        if(Settings::get('week')) {
            $week = explode(',', Settings::get('week'));
        } else {
            $week = array();
        }
        if(Settings::get('delivery_hours')) {
            $time_delivery = json_decode(Settings::get('delivery_hours'), true);
        } else {
            $time_delivery = array();
        }
        $categories = ['' => trans('app.select_category')] + $packageRepository->lists_categories_actives();
        $locations_labels = $clientRepository->lists_locations_labels(Auth::user()->id);
   
        return view('services.create', compact('locations_labels', 'working_hours', 'week', 'time_delivery', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($data);
        if ( $validator->passes() ) {
        } else {
            $messages = $validator->errors()->getMessages();

            return response()->json([
                'success' => false,
                'validator' => true,
                'message' => $messages
            ]);
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
