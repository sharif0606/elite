@extends('layout.app')
@section('pageTitle','Biometric')
@section('pageSubTitle','Biometric')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <h5 class="text-center m-0">এলিট সিকিউরিটি সার্ভিস লিমিটেড</h5>
                            <h6 class="m-0">{{$employee->bn_applicants_name}}</h6>
                            <p class="m-0">{{$employee->admission_id_no}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">{{__('#SL')}}</th>
                        <th scope="col">{{__('Type')}}</th>
                        <th scope="col">{{__('Finger')}}</th>
                        <th scope="col">{{__('Image')}}</th>
                        <th class="white-space-nowrap">{{__('ACTION')}}</th>
                    </tr>
                <tbody>
                    @foreach($employee->biometrics as $index => $biometric)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($biometric->hand_type == 1)
                            Left
                            @else
                            Right
                            @endif
                        </td>
                        <td>
                            @switch($biometric->finger_type)
                            @case(1)
                            Thumb
                            @break
                            @case(2)
                            Index Finger (Pointer Finger)
                            @break
                            @case(3)
                            Middle Finger
                            @break
                            @case(4)
                            Ring Finger
                            @break
                            @case(5)
                            Little Finger (Pinky)
                            @break
                            @default
                            Unknown Finger
                            @endswitch
                        </td>
                        <td>
                            <img src="{{ asset('uploads/fingerprints/' . $biometric->img) }}" alt="Fingerprint Image" width="100">
                        </td>
                        <td>
                            <!-- Add your action buttons (e.g., edit, delete) here -->
                            {{--<a href="{{ route('employee-biometrics.edit', $biometric->id) }}" class="btn btn-warning">Edit</a>--}}
                            <form action="{{ route('employee-biometrics.destroy', $biometric->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
            <form class="form" method="post" action="{{route('employee-biometrics.store')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-center my-3">Add Finger Print</h6>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="hand_type">Hand</label>
                            <select class="form-select" id="hand_type" name="hand_type">
                                <option value="" disabled selected>Choose a Hand Type</option>
                                <option value="1">Left</option>
                                <option value="2">Right</option>
                            </select>
                            @error('hand_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="finger_type">Select Finger Type</label>
                            <select class="form-select" id="finger_type" name="finger_type">
                                <option value="" disabled selected>Choose a Finger</option>
                                <option value="1">Thumb</option>
                                <option value="2">Index Finger (Pointer Finger)</option>
                                <option value="3">Middle Finger</option>
                                <option value="4">Ring Finger</option>
                                <option value="5">Little Finger (Pinky)</option>
                            </select>
                            @error('finger_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label for="file">Upload Finger Photo</label>
                        <input type="file" class="" name="img">
                        @error('img')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')


@endpush