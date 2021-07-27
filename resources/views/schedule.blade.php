 <label>Select Schedule</label>
                            <select name="schedule" class="form-select time-schedule">
                              <option value="">--select Schedule --</option>
                               @foreach ($schedules as $schedule)
                                    <option value="{{$schedule->id}}">{{$schedule->start_time .' To '. $schedule->end_time}}</option>
                               @endforeach
                            </select>