<script src="./static/js/cropper.js"></script>
  <div class="container">
    <label class="label" data-toggle="tooltip" title="Change your avatar">
      <img class="rounded avatar" id="avatar" src=<?php echo('"'.getAvatar($_SESSION["user_id"]).'"');?> alt="avatar">
      <input type="file" class="sr-only" id="input" name="image" accept="image/*">
    </label>
    <div class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
    <div class="alert" role="alert"></div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Recorte a su gusto la imagen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src=<?php echo('"'.getAvatar($_SESSION["user_id"]).'"');?>>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="crop">Crop</button>
          </div>
        </div>
      </div>
    </div>
  </div>