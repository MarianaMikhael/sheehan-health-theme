jQuery(function ($) {
  $('.sheehan-select-image').on('click', function (e) {
    e.preventDefault();
    var $button = $(this);
    var $wrap = $button.closest('.sheehan-image-field');
    var $input = $wrap.find('.sheehan-image-url');
    var frame = wp.media({ title: 'Select image', multiple: false });
    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      $input.val(attachment.url);
      $wrap.find('.sheehan-image-preview').html(
        '<img src="' + attachment.url + '" style="max-height:60px;margin-top:8px;display:block">'
      );
    });
    frame.open();
  });
});
