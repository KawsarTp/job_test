 <h4>Added Appointment</h4>
 <form action="{{route('make.payment')}}" method="get" class="mt-4">
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