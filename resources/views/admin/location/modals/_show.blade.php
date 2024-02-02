<div class="modal fade" id="showLocationModal" tabindex="-1" aria-labelledby="showLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLocationModalLabel">Location Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="showLocationCity">City : </label>
                        <span id="showLocationCity"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showLocationState">State : </label>
                        <span id="showLocationState"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showLocationCountry">Country : </label>
                        <span id="showLocationCountry"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showLocationPincode">Pincode : </label>
                        <span id="showLocationPincode"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showLocationJobs">No of Available Jobs : </label>
                        <span id="showLocationJobs"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showLocationName">Jobs : </label>
                        <span id="showJobs"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
