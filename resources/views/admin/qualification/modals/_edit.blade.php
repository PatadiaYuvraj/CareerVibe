<div class="modal fade" id="editQualificationModal" tabindex="-1" aria-labelledby="editQualificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editQualificationForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQualificationModalLabel">Edit Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editQualificationName">Qualification Name</label>

                        <input type="text" class="form-control" id="editQualificationName"
                            name="editQualificationName" placeholder="Enter Qualification Name">
                        <span id="editNameError" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit Qualification</button>
                </div>
            </form>
        </div>
    </div>
</div>
