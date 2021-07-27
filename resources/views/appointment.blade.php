@extends('master')

@section('content')

 <div class="col-md-5 col-lg-5">
                <h4>Create Appointment</h4>
                <form action="" method="post" id="reset-form">
                @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Select Department</label>
                            <select name="department" class="form-select department">
                                @foreach ($departments as $department) 
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-md-12 mb-3 department-doc d-none">
                            <div class="text-danger">No Doctor is found under this department</div>
                        </div>
                        <div class="col-md-12 mb-3 doctors d-none">
                           
                        </div>
                        <div class="col-md-12 mb-3 date-calander d-none">
                            <label>Select Date</label>
                            <input type="text" name="date" class="form-control datepicker">
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-danger schedule-not-available d-none"></div>
                            <div class="text-danger doctor-not-available d-none">Doctor is unavailable on that particular day</div>
                        </div>
                        <div class="col-md-12 mb-3 schedule-time d-none">
                           
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-success d-none available">Available</div>
                            <div class="text-danger d-none quota"></div>
                        </div>
                    </div>
                    <button class="w-100 btn btn-primary btn-sm form-submit d-none" type="submit">Add This</button>
                </form>
            </div>



            <div class="col-md-7 col-lg-7 orders">
                
                <h4>Added Appointment</h4>
 <form action="{{route('make.payment')}}" method="post" class="mt-4">
 @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Department</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Schedule</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($orders as $order)
                                
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$order->department->name}}</td>
                                <td>{{$order->doctor->name}}</td>
                                <td>{{$order->order_date}}</td>
                                <td>{{$order->schedule->start_time .' - '. $order->schedule->end_time}}</td>
                                <td><a data-id="{{$order->id}}" class="btn btn-danger btn-sm delete">Delete</a></td>
                            </tr>
                            @empty

                                <tr>
                                
                                    <td class="text-center" colspan="100%">No Order Has been Made</td>
                                
                                </tr>

                            @endforelse
                           
                        </table>
                    </div>

                    @if($orders->isNotEmpty())
                    <h4>Patient Information</h4>

                    <div class="col-md-12 mb-3">
                        <input type="text" name="patient_name" class="form-control" placeholder="Patient Name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <input type="text" name="patient_mobile" class="form-control" placeholder="Patient Mobile">
                    </div>

                    <button class="w-100 btn btn-primary btn-sm" type="submit">Pay with PayPal</button>

                    @endif
                </form>
               
            </div>


@endsection

@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('custom-script')

<script>


    $(function(){
        $('.department').on('change',function(){
           let departmentId = $(this).val();
           
           $.ajax({
               url:"{{route('find')}}",
               method:"GET",
               data:{departmentId : departmentId},
               success:function(response){
                   
                 if(response.success == false){
                    $('.department-doc').removeClass('d-none');
                    $('.doctors, .date-calander , .schedule-time,.available, .form-submit').addClass('d-none');
                    $('.doctor').val('');
                   $('.time-schedule').val('');
                   $('.datepicker').val('');
                    return false;
                 }

                    $('.doctors').removeClass('d-none');
                    $('.doctors').html(response);
                    $('.department-doc').addClass('d-none');

               }
           })
        })


        $(document).on('change','.doctor',function(){
            if($(this).val() == ''){
                
                $('.date-calander, .schedule-time, .doctor-not-available, .schedule-not-available , .available, .form-submit').addClass('d-none');
                 $('.time-schedule').val('');
                   $('.datepicker').val('');
                return false;
            }

            $('.date-calander').removeClass('d-none');
        })


        $(document).on('change','.datepicker',function(){

           let searchDate = $(this).val();
           let doctorId  = $('.doctor option:selected').val();
            $.ajax({
               url:"{{route('schedule')}}",
               method:"GET",
               data:{searchDate : searchDate,doctorId: doctorId},
               success:function(response){
                   
                 if(response.success == false){

                    $('.schedule-not-available').removeClass('d-none');
                    $('.schedule-not-available').text('Schedule Not Found for '+ response.weekname)
                    $('.doctor-not-available, .schedule-time, .available, .form-submit').addClass('d-none');
                    
                    return false;

                 }else if(response.notAvailable){

                    $('.schedule-not-available, .schedule-time, .available, .form-submit').addClass('d-none');
                    $('.doctor-not-available').removeClass('d-none');

                    return false;
                    
                 }


                    $('.schedule-time').removeClass('d-none')
                    $('.schedule-not-available, .doctor-not-available').addClass('d-none');
                    $('.schedule-time').html(response)
                   

               }
           })

        })

        $(document).on('change','.time-schedule',function(){

            let timeSchedule = $(this).val();
            if(timeSchedule == ''){
                $('.form-submit, .available, .quota').addClass('d-none')
                return false;
            }
            let doctorId  = $('.doctor option:selected').val();
            let searchDate = $('.datepicker').val();

            $.ajax({
               url:"{{route('time')}}",
               method:"GET",
               data:{searchDate : searchDate,doctorId: doctorId,timeSchedule:timeSchedule},
               success:function(response){
                   if(response.quotaFull){
                       $('.quota').text('Maximum Quota ('+ response.quota +') is Filled')
                       $('.quota').removeClass('d-none')
                        $('.form-submit , .available').addClass('d-none')
                       return false;
                   }else{
                       $('.available').removeClass('d-none');
                       $('.quota').addClass('d-none')

                   }    

                   $('.form-submit').removeClass('d-none')
               }
            })

        })

        $(document).on('click','.form-submit',function(e){

            e.preventDefault();

            let department = $('.department option:selected').val();

            let doctor = $('.doctor option:selected').val();

            let timeSchedule = $('.time-schedule option:selected').val();

            let datepicker = $('.datepicker').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

             $.ajax({
               url:"{{route('appointment')}}",
               method:"POST",
               data:{department : department,doctor: doctor,timeSchedule:timeSchedule,datepicker:datepicker},
               success:function(response){
                  
                   $('.department').val('');
                   $('.doctor').val('');
                   $('.time-schedule').val('');
                   $('.datepicker').val('');

                   $('.doctors , .date-calander , .schedule-time , .available , .form-submit ').addClass('d-none');
                   

                  $('.orders').html(response)
               }
            })
            
            

        })


        $(document).on('click', '.delete', function(){
            let orderId = $(this).data('id');
          
            $.ajax({
                 url: "{{route('delete')}}",
               method:"GET",
               data:{orderId : orderId},
               success:function(response){
                   $('.orders').html(response)
               }
            })
        })

    })


</script>

@endpush