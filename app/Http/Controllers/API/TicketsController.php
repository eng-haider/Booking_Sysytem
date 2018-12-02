<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\cars_type;
use App\tickets;
use App\cars;
class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('tickets')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'tickets.car_type_id')
        ->get(array('tickets.*','cars_types.*'));
        return $data;
    }

    public function carstype()
    {
            return cars_type::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'tenant_name'=>'required',
        ]);


      
        return tickets::create([
            'tenant_name'=>$request['tenant_name'],
            'tenant_phone'=>$request['tenant_phone'],
            'car_type_id'=>$request['car_type_id'],
            'trip_date'=>$request['trip_date'],           
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('tickets')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'tickets.car_type_id')
        ->where('ticket_status_id', '=', $id)
        ->select('tickets.*', 'cars_types.car_type')
        ->get();
        return $data;
    }


    public function tickets_booked()
    {
        $data = DB::table('tickets')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'tickets.car_type_id')
        ->leftjoin('cars', 'cars.id', '=', 'tickets.car_id')
        ->leftjoin('drivers', 'drivers.id', '=', 'tickets.driver_id')
        ->where('ticket_status_id', '=', 1)
        ->select('tickets.*','cars.*', 'cars_types.car_type','drivers.name','drivers.phone')
        ->get();
        return $data;
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
       
    
        $tickets=tickets::findOrFail($id);

        $car_id=$request['car_id'];
      
        $this->validate($request,[
            'car_id'=>'required',       
         ]);

        
        tickets::find($id)->update([
            'car_id'=>$request['car_id'],
            'driver_id'=>$request['driver_id'],
            'ticket_status_id'=>'1'
          ]);

          cars::find($car_id)->update([
            'car_status_id'=>'1',
           
          ]);
         

        
    
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
