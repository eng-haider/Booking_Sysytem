<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\cars;
use App\cars_colors;
use App\cars_status;
use App\drivers;
use App\tickets;
use Illuminate\support\Facades\Hash;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       $data = DB::table('cars')
        ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')

      //  ->leftjoin('tickets', 'cars.id', '=', 'tickets.car_id')



       // ->leftjoin('drivers', 'drivers.id', '=', 'tickets.driver_id')

       
       ->leftjoin('tickets', function ($leftjoin) {
            $leftjoin->on('cars.id', '=', 'tickets.car_id')
             ->where('tickets.ticket_status_id', '!=',3);
           ;
       })
        

        ->leftjoin('drivers', function ($leftjoin) {
            $leftjoin->on('drivers.id', '=', 'tickets.driver_id')
            ->where('cars.car_status_id', '=', 1)
            ->select('drivers.name');
                })

        ->select('cars.*', 'cars_status.status_name', 'cars_status.css_color', 'cars_types.car_type','tickets.trip_date','drivers.name','tickets.id as ticket_id')
        
        ->get();
        return $data;
        /*
        $cars=cars::get();

        return response()->json($cars);
*/
       
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
            'car_num'=>'required',
            'car_type_id'=>'required',
            'car_color_id'=>'required',
            'seats_num'=>'required',
        ]);

        return cars::create([
            'car_num'=>$request['car_num'],
            'car_type_id'=>$request['car_type_id'],
            'car_color_id'=>$request['car_color_id'],
            'notes'=>$request['notes'],
            'seats_num'=>$request['seats_num'],

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
             
       $data = DB::table('cars')
       ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
       ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')
       ->where('cars_status.id', '=', $id)->get(array('cars.*', 'cars_status.*', 'cars_types.*'));
       return $data;
    }


    public function updatestatus(Request $request,$id)
    {
       // echo $request['driver_id'] ;
        
        cars::find($id)->update([
            'car_status_id'=>$request['car_status_id'],
            'notes'=>$request['notes'],     
          ]);
          
          

         $ticket_id=$request['ticket_id'];

         
         tickets::find($ticket_id)->update([
           'ticket_status_id'=>'3',
         ]);


          /*
          $driver_id=$request['driver_id'];
          drivers::find($driver_id)->update([
            'driver_status_id'=>'1',
          ]);
          */
        
          

          
    }



    public function cars_orders(Request $request)
    {
        $car_type=$request['car_type'];
             
       $data = DB::table('cars')
       ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
       ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')
       ->where('cars_status.id', '=', 2)
       ->where('car_type_id', '=',  $car_type)
       ->select(DB::raw("CONCAT(cast(cars_types.car_type  as CHAR),'// ' ,cast(car_num as CHAR))  as ptx"),'cars.*', 'cars_types.car_type','cars_status.status_name')
       ->get(array('cars.*', 'cars_status.*', 'cars_types.*'));
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
        //
    }

    public function carscolor()
    {
            return cars_colors::get();
    }

    public function carstatus()
    {
        return cars_status::get();
    }

    public function CarsByStatusId($id)
    {
        $data = DB::table('cars')
        ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')
        ->where('cars_status.id', '=', $id)
        ->get(array('cars.*', 'cars_status.status_name','cars_status.css_color', 'cars_types.car_type',));
        return $data;

    }
    

    public function CarsByTypeId($id)
    {
        $data = DB::table('cars')
        ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')
        ->where('cars_types.id', '=', $id)
        ->get(array('cars.*', 'cars_status.status_name','cars_status.css_color', 'cars_types.car_type',));
        return $data;

    }


    public function Serch($serch_key)
    {
        $data = DB::table('cars')
        ->leftjoin('cars_status', 'cars_status.id', '=', 'cars.car_status_id')
        ->leftjoin('cars_types', 'cars_types.id', '=', 'cars.car_type_id')
        ->where('cars.car_num', 'LIKE', "%$serch_key%")
        ->get(array('cars.*', 'cars_status.status_name','cars_status.css_color', 'cars_types.car_type',));
        return $data;

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
