@extends('layout.app')

@section('pageTitle','Edit Inventory Location')
@section('pageSubTitle','Create')

@section('content')

  <section id="multiple-column-form">
      <div class="row match-height">
          <div class="col-12">
              <div class="card">
                  <div class="card-content">
                      <div class="card-body">
                          <form class="form" method="post" action="{{route(currentUser().'.invloc.update',encryptor('encrypt',$invloc->id))}}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$invloc->id)}}">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <select class="form-control" name="country_id">
                                            <option value="">Select Inventory Location</option>
                                            @if(count($countries) > 0)
                                            @forelse($countries as $c)
                                            <option value="{{$c->id}}" {{ old('country_id',$invloc->country_id) == $c->id ? "selected" : "" }}>{{$c->name}}</option>
                                            @empty
                                            @endforelse
                                            @endif
                                        </select>
                                        @if($errors->has('name'))
                                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    
                                    
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                                    </div>
                                </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- // Basic multiple Column Form section end -->
</div>
@endsection