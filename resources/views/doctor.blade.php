 <label>Select Doctor</label>
                            <select name="doctors" class="form-select doctor">
                                <option value="">--select Doctor--</option>
                             @foreach ($doctorsList as $doctor )
                                <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                             @endforeach
                                
                            </select>