<?php require_once("includes/header.php"); ?>
<?php require_once("includes/classes/videoDetailsFormProvider.php"); ?>

<div class="column">
<?php
$formObj = new VideoDetailsProvider($con);
echo $formObj->createUploadForm();


?>
</div>
 

<div class="modal" id ="loadingModal" data-backdrop="static" data-keyboard = false>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body d-flex flex-column align-items-center">
                <p>Please wait. This might take a while</p>
                <div class="spinner-border text-primary " role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once("includes/footer.php"); ?>
<script>
    $("form").submit(()=>{
        $("#loadingModal").modal("show");
    })
</script>
