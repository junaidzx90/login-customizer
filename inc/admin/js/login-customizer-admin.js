jQuery(function ($) {
  'use strict';

  $('.range_input').each(function () {
    $(this).on('input', function () {
      let newVal =
        (($(this).val() - $(this).attr('min')) * 100) /
        ($(this).attr('max') - $(this).attr('min'));
      let newPos = 10 - newVal * 0.2;
      $(this)
        .parents('.range-wrap')
        .find('.range-value')
        .html(`<span>${$(this).val()}</span>`);
      $(this)
        .parents('.range-wrap')
        .find('.range-value')
        .css('left', `calc(${newVal}% + (${newPos}px))`);
    });
  });

  // Color plates
  $('#lc_body_bg_color').wpColorPicker();
  $('#lc_body_color').wpColorPicker();
  $('#lc_form_background_color').wpColorPicker();
  $('#lc_form_box_shadow_color').wpColorPicker();
  $('#lc_login_btn_background_color').wpColorPicker();
  $('#lc_login_btn_hover_bg_color').wpColorPicker();
  $('#lc_link_color').wpColorPicker();
  $('#lc_link_hover_color').wpColorPicker();
  $('#lc_input_focus_border_color').wpColorPicker();
  $('#lc_input_focus_shadow_color').wpColorPicker();
});
