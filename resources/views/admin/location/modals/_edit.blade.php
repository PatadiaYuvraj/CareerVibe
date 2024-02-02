<div class="modal fade" id="editLocationModal" tabindex="-1" aria-labelledby="editLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editLocationForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLocationModalLabel">Edit Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editLocationCity">
                            City <span class="text-danger">*</span>
                        </label>

                        <input type="text" class="form-control" id="editLocationCity" name="editLocationCity"
                            placeholder="Enter Location City">
                        <span id="editCityError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="editLocationState">
                            State
                        </label>

                        <input type="text" class="form-control" id="editLocationState" name="editLocationState"
                            placeholder="Enter Location State">
                        <span id="editStateError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="editLocationCountry">
                            Country
                        </label>

                        <input type="text" class="form-control" id="editLocationCountry" name="editLocationCountry"
                            placeholder="Enter Location Country">
                        <span id="editCountryError" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="editLocationPincode">
                            Pincode
                        </label>

                        <input type="text" class="form-control" id="editLocationPincode" name="editLocationPincode"
                            placeholder="Enter Location Pincode">
                        <span id="editPincodeError" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Location</button>
                </div>
            </form>
        </div>
    </div>
</div>
