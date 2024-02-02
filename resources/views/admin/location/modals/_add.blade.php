<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <form id="addLocationForm"> --}}
            {{ Form::open([
                'id' => 'addLocationForm',
                'route' => 'admin.location.store',
                'method' => 'POST',
            ]) }}
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationModalLabel">
                    Add Location
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('addLocationCity', 'City', [
                        'class' => 'form-label',
                    ]) }}
                    {{ Form::text('addLocationCity', null, [
                        'class' => 'form-control',
                        'id' => 'addLocationCity',
                        'placeholder' => 'Enter Location City',
                    ]) }}
                    <span id="addCityError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    {{ Form::label('addLocationState', 'State', [
                        'class' => 'form-label',
                    ]) }}
                    {{ Form::text('addLocationState', null, [
                        'class' => 'form-control',
                        'id' => 'addLocationState',
                        'placeholder' => 'Enter Location State',
                    ]) }}
                    <span id="addStateError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    {{-- <label for="addLocationCountry">Country</label>

                        <input type="text" class="form-control" id="addLocationCountry" name="addLocationCountry"
                            placeholder="Enter Location Country">
                        <span id="addCountryError" class="text-danger"></span> --}}
                    {{ Form::label('addLocationCountry', 'Country', [
                        'class' => 'form-label',
                    ]) }}
                    {{ Form::text('addLocationCountry', null, [
                        'class' => 'form-control',
                        'id' => 'addLocationCountry',
                        'placeholder' => 'Enter Location Country',
                    ]) }}
                    <span id="addCountryError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    {{ Form::label('addLocationPincode', 'Pincode', [
                        'class' => 'form-label',
                    ]) }}
                    {{ Form::text('addLocationPincode', null, [
                        'class' => 'form-control',
                        'id' => 'addLocationPincode',
                        'placeholder' => 'Enter Location Pincode',
                    ]) }}
                    <span id="addPincodeError" class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Location</button>
            </div>
            {{-- </form> --}}
            {{ Form::close() }}
        </div>
    </div>
</div>
