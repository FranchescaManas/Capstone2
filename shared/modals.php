<?php
if(isset($_GET['page'])){
    $role = $_GET['page'];

    if($role === 'students'){
        $role = 'student';
    }else if($role === 'faculty'){
        $role = 'faculty';
    }
}

?>
<div class="modal fade" id="import<?=$role?>" tabindex="-1" aria-labelledby="importFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <div class="d-flex flex-column justify-content-start">
                    <h5 class="modal-title" id="importFormLabel">Import Data</h5>
                    <p>Kindly upload the <?=$role?> data into the provided template.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form action="">
                    <input type="file" name="excel_file" accept=".xls, .xlsx">
                   
                </form>
            </div>
            <div class="modal-footer flex-end">
                <button type="button" class="red-btn small-btn rounded">Save</button>
                <button type="button" class="red-btn small-btn rounded" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>