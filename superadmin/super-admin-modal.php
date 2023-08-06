<!-- schedule form -->

<div class="modal fade" id="scheduleform" tabindex="-1" aria-labelledby="scheduleformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="scheduleformLabel">Schedule Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="">
                    <section class="flex-start">
                        <div class="form-group">
                            <label for="start-date">Start Date:</label>
                            <input type="date" name="start-date" id="">
                        </div>
                        <div class="form-group">
                            <label for="end-date">Start Date:</label>
                            <input type="date" name="end-date" id="">
                        </div>
                    </section>

                    <section class="d-flex flex-wrap m-3">
                        <h6>Select Forms:</h6>
                        <div class="w-100"></div>
                        
                        <div class="form-check my-2 me-5">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Default checkbox
                            </label>
                        </div>
                        
                        
                    </section>
                   
                </form>
            </div>
            <div class="modal-footer flex-end">
                <button type="button" class="red-btn small-btn rounded">Save</button>
                <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- form permission -->

<div class="modal fade" id="assignForm" tabindex="-1" aria-labelledby="assignFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="assignFormLabel">Assign Forms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="">
                    <section class="flex-start">
                        <div class="form-group">
                            <label for="form-select">Select Form:</label>
                            <select name="form-select" id="form-select">
                                <option value="1">{{form1}}</option>
                                <option value="1">{{form2}}</option>
                                <option value="1">{{form3}}</option>
                            </select>
                        </div>
                    </section>

                    <section class="d-flex flex-wrap m-3">
                        <h6>Respondents:</h6>
                        <div class="w-100"></div>
                        
                        <div class="form-check my-2 me-5">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{role}}
                            </label>
                        </div>
                        
                        
                    </section>
                   
                </form>
            </div>
            <div class="modal-footer flex-end">
                <button type="button" class="red-btn small-btn rounded">Save</button>
                <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>