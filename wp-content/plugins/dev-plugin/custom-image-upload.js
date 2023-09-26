jQuery(document).ready(function ($) {
  $("#upload_custom_image_button").click(function (e) {
    e.preventDefault();
    var image = wp
      .media({
        title: "Upload Image",
        multiple: false,
      })
      .open()
      .on("select", function (e) {
        var uploadedImage = image.state().get("selection").first();
        var image_url = uploadedImage.toJSON().url;
        $("#custom_image_url").val(image_url);
      });
  });
});
