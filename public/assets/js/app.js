var ajaxURL="/actions/"
  ,helper={createProject:'<span class="helper">Create a new project</span>'
  ,createGroup:'<span class="helper">Create a new group</span>'
  ,addToProject:'<span class="helper addImg">Add image to this project</span>'
  ,addToGroup:'<span class="helper">Add to this group</span>'
  ,tooManyImages:"You can only upload 15 images at once"
  ,mustBeImage:"Your upload must be an image"
  ,fileTooBig:"Images must be less than 3Mb"}
  ,newImgTmp='<li class="image draggable droppd"><a href="javascript://" draggable="false" class="dropzone single thumb"><img draggable="false" data-dz-thumbnail /></a><div class="toolbar"><a href="javascript://" draggable="false" class="title" data-dz-name></a><a href="javascript://" draggable="false" title="Edit this image" class="contextmenu">Edit</a><ul class="optMenu"></ul><span data-dz-uploadprogress></span><span class="filesize" data-dz-size></span><span data-dz-errormessage></span></div></li>'
;
$(function() {
  var c = new Dropzone(document.body, {
    url: $("#images").attr("data-submit"),
    clickable: ".filechoose",
    previewsContainer: "#images",
    thumbnailWidth: 250,
    thumbnailHeight: 140,
    acceptedFiles: "image/jpg,image/jpeg,image/png,image/gif",
    previewTemplate: newImgTmp,
    maxFiles: 15,
    maxFilesize: 3,
    dictInvalidFileType: helper.mustBeImage,
    dictFileTooBig: helper.fileTooBig,
    dictMaxFilesExceeded: helper.tooManyImages,
    dictFallbackText: null,
    dictFallbackMessage: null,
    fallback: function() {
      /*$(".filechoose").click(function(b) {
        window.location.assign($("#uploadSingle a").attr("href"))
      });*/
      $(".dz-fallback").hide()
    },
    error: function(b, a, d) {
      $(b.previewTemplate).remove();
      a == c.options.dictMaxFilesExceeded ? !1 === done && (done = !0, showerror(helper.tooManyImages, !0)) : "limit" == a ? $("#upgradePrompt").modal("show") : d && d.hasOwnProperty("status") && d.status ? (showerror(b.name + " couldn't be uploaded. Please try again."), console.log(b.name + " failed with response: " + d)) : showerror(a)
    }
  });
  c.on("dragenter", function() {
    $("body").prepend('<div id="ddPrompt"><a href="./" id="closeddPrompt">&#215;</a><p><strong>Drop here</strong><br /><em>Drag up to ' +
      c.options.maxFiles + " images at once</em></p></div>");
    $("html, body").animate({
      scrollTop: $("#uploadSingle").offset().top
    }, 500)
  });
  c.on("dragleave", function() {
    $("#ddPrompt").remove()
  });
  c.on("addedfile", function() {
    $("#ddPrompt").remove()
  });
  c.on("processing", function(b) {
    $("html, body").animate({
      scrollTop: $("#uploadSingle").offset().top
    }, 500);
    $("#ddPrompt").remove();
    $("#uploadSingle").appendTo("#images");
    $("#images").removeClass("inactive");
    $("#myImages").removeClass("hidden");
  });
  c.on("success", function(b, a, c) {
    a ? ($(b.previewTemplate).addClass("complete").attr("rel", a.id).find(".dropzone").attr("rel", a.id), $(b.previewTemplate).find("a.thumb,a.title").attr("href", a.html), $(b.previewTemplate).find("a.title").text(a.title), $(b.previewTemplate).find("a.edit").attr("href", a.edit), $(b.previewTemplate).find("ul").html(a.menu), $("#percent").stop().animate({
        width: a.percent + "%"
      }, 300), 80 <= a.percent && $("#percent").addClass("low")) : ($(b.previewTemplate).remove(), showerror(b.name + " couldn't be uploaded. Please try again."))
  })
});
