<div class="modal fade" id="showQualificationModal" tabindex="-1" aria-labelledby="showQualificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showQualificationModalLabel">Qualification Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="showQualificationName">Qualification Name : </label>
                        <span id="showQualificationName"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showQualificationName">No of Available Jobs : </label>
                        <span id="showQualificationJobs"></span>
                    </div>
                    <div class="col-md-12">
                        <label for="showQualificationName">Jobs : </label>
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
