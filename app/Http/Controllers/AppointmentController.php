<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Day;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\TempOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    public function index()
    {
        // get all the departments 

        $departments = Department::latest()->get();

        $orders = collect([]);

        if(session()->has('trx')){

            $orders = TempOrder::where('temp_trx', session('trx'))->latest()->with('department','doctor','schedule')->get();
        }


        return view('appointment',compact('departments','orders'));
    }


    public function findDoctor(Request $request)
    {
        // get all doctor list 

        $doctorsList = Doctor::where('department_id',$request->departmentId)->latest()->get();

        // if doctor is empty then response false
        if($doctorsList->isEmpty()){
            return response()->json(['success'=>false]);
        }

        return view('doctor',compact('doctorsList'));
    }

    public function findSchedule(Request $request)
    {
        // get the week name of selected date

       $weekName = Carbon::parse($request->searchDate)->format('l');

        // find the doctor 

       $doctor = Doctor::with('schedules','leaves')->findOrfail($request->doctorId);

    //    get the day column for requested date

       $day = Day::where('day',$weekName)->firstOrFail();

        // check is schedules is available 
       $isScheduleAvailable = $doctor->schedules->where('day_id',$day->id);


        // find the doctors schedule from schedule table   
       $schedules = $doctor->schedules->where('day_id',$day->id);

     // find doctors leave from leave table where date is the requested date   

       $isDoctorAvailable = $doctor->leaves()->whereDate('date', Carbon::parse($request->searchDate))->get();


    //    check Doctor collection is empty or not

       if($isDoctorAvailable->isNotEmpty()){

            return response()->json(['notAvailable'=>true]);

       }elseif($isScheduleAvailable->isEmpty()){

            return response()->json(['weekname' => $weekName ,'success'=>false]);

       }

       return view('schedule',compact('schedules'));
    }

    public function findTimeSchedule(Request $request)
    {
        // get the week name of requested date
        $weekName = Carbon::parse($request->searchDate)->format('l');

        // find the day form days table
        $day = Day::where('day',$weekName)->firstOrFail();

        // find schedule 
        $schedule = Schedule::where('id',$request->timeSchedule)->where('doctor_id',$request->doctorId)->where('day_id',$day->id)->first();


        $quota = $schedule->maximum_patient;

        // get the count of Appointemnt on requested date for a schedule 
        $appoitment = Appointment::where('doctor_id',$request->doctorId)->where('schedule_id', $schedule->id)->whereDate('appoint_date',$request->searchDate)->count();


        // if the appoinemnt is equal to the schedule maximum patiend then it response quota filled
        if($appoitment == $schedule->maximum_patient){
            return response()->json(['quotaFull'=> true,'quota'=> $quota]);
        }

        return response()->json(['notAvailable'=> false]);

    }


    public function appointment(Request $request)
    {
     
        if(!session()->has('trx')){

            $tempTrx = now()->format('YmdHis');

            session()->put('trx', $tempTrx);
        }

        $doctor = Doctor::find($request->doctor);
        
        $schedule = Schedule::find($request->timeSchedule);

        // create TempOrder for appointment
      TempOrder::create([
        'department_id' => $request->department,
        'schedule_id' => $schedule->id,
        'doctor_id' => $doctor->id,
        'order_date' => $request->datepicker,
        'amount' => $doctor->fee,
        'temp_trx' => session('trx')
      ]);

      $orders = TempOrder::where('temp_trx', session('trx'))->latest()->with('department','doctor','schedule')->get();


      return view('orders',compact('orders'));

       
    }

    public function delete (Request $request)
    {
        $order = TempOrder::findOrFail($request->orderId);

        $order->delete();

        // get all temporary orders and update the dom
        $orders = TempOrder::where('temp_trx', session('trx'))->latest()->with('department','doctor','schedule')->get();

        return view('orders',compact('orders'));
    }

    public function pay(Request $request)
    {
        // after hittind pay with paypal hit this method

        $trx = session('trx');

        $orders = TempOrder::where('temp_trx', $trx)->get();

        $totalAmount = $orders->sum('amount');

        $fee = 2.5;

        $controller = PayPalPaymentController::class;

       
       
        $data = $controller::process($totalAmount);
        $data = json_decode($data);

        Order::create([
            'order_id' => $trx,
            'patient_name' => $request->patient_name,
            'patient_mobile' => $request->patient_mobile,
            'paid_amount' => $totalAmount,
            'fee_amount' => $fee,
            'net_amount' => $totalAmount - $fee,
            'payment_status' => '',
            'transaction_id' => $data->id 
        ]);

        return redirect()->to($data->links[1]->href);

        
    }


    public static function orderBooked($trx)
    {
        $tempOrder = TempOrder::where('temp_trx', $trx)->get();

        foreach($tempOrder as $appointment){
           
            Appointment::create([
                'order_id' => $appointment->temp_trx,
                'doctor_id' => $appointment->doctor_id,
                'day_id' => $appointment->schedule->day->id,
                'schedule_id' => $appointment->schedule_id,
                'appoint_date' => $appointment->order_date,
                'fee' => $appointment->amount
            ]);

            $appointment->delete();
        }
        
        session()->forget('trx');
        
    }

    public function paymentSuccess()
    {
        return view('payment_success');
    }
}
