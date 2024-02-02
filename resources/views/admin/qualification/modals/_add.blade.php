<div class="modal fade" id="addQualificationModal" tabindex="-1" aria-labelledby="addQualificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addQualificationForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQualificationModalLabel">Add Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addQualificationName">Qualification Name</label>

                        <input type="text" class="form-control" id="addQualificationName" name="addQualificationName"
                            placeholder="Enter Qualification Name">
                        <span id="addNameError" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Qualification</button>
                </div>
            </form>
        </div>
    </div>
</div>
