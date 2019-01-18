window.addEventListener('DOMContentLoaded', function () {
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;
    var minCroppedWidth = 100;
    var minCroppedHeight = 100;
    var maxCroppedWidth = 5000;
    var maxCroppedHeight = 5000;
    $('[data-toggle="tooltip"]').tooltip();
    input.addEventListener('change', function (e) {
      var files = e.target.files;
      var done = function (url) {
        input.value = '';
        image.src = url;
        $alert.hide();
        $modal.modal('show');
      };
      var reader;
      var file;
      var url;
      if (files && files.length > 0) {
        file = files[0];
        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) {
          reader = new FileReader();
          reader.onload = function (e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });
    $modal.on('shown.bs.modal', function () {
      cropper = new Cropper(image, {
          aspectRatio: 1 / 1,
          viewMode: 3,
          movable: false,
          zoomable: false,
          rotatable: false,
          scalable: false,
          dragMode: 'move',
          /*autoCropArea: 0.65,*/
          restore: false,
          guides: true,
          center: false,
          highlight: true,
          cropBoxMovable: true,
          cropBoxResizable: true,
          toggleDragModeOnDblclick: true,
        data: {
        width: (minCroppedWidth + maxCroppedWidth) / 2,
        height: (minCroppedHeight + maxCroppedHeight) / 2,
      },
      crop: function (event) {
        var width = event.detail.width;
        var height = event.detail.height;
        if (
          width < minCroppedWidth
          || height < minCroppedHeight
          || width > maxCroppedWidth
          || height > maxCroppedHeight
        ) {
          cropper.setData({
            width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
            height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
          });
        }
      },
        
      });
    }).on('hidden.bs.modal', function () {
      cropper.destroy();
      cropper = null;
    });
    document.getElementById('crop').addEventListener('click', function () {
      var initialAvatarURL;
      var canvas;
      $modal.modal('hide');
      if (cropper) {
        canvas = cropper.getCroppedCanvas(/*{
          width: 160,
          height: 160,
        }*/);
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        $progress.show();
        $alert.removeClass('alert-success alert-warning');
        canvas.toBlob(function (blob) {
          var formData = new FormData();
          formData.append('avatar', blob, 'avatar.jpg');
          $.ajax('./code/settings.php', {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
              var xhr = new XMLHttpRequest();
              xhr.upload.onprogress = function (e) {
                var percent = '0';
                var percentage = '0%';
                if (e.lengthComputable) {
                  percent = Math.round((e.loaded / e.total) * 100);
                  percentage = percent + '%';
                  $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                }
              };
              return xhr;
            },
            success: function () {
              $alert.show().addClass('alert-success').text('Upload success');
              //Reloads the avatar(puede recargarlo desde la cache del navegador en algunos casos)
              $("#avatar").attr("src", avatar.src);
              $("#image").attr("src", avatar.src);
              $("#av").attr("src", avatar.src);
            },
            error: function () {
              avatar.src = initialAvatarURL;
              $alert.show().addClass('alert-warning').text('Upload error');
            },
            complete: function () {
              $progress.hide();
            },
          });
        });
      }
    });
  });