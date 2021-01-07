'use strict'

// Dépendances
import jQuery from 'jquery'
import 'presstify-framework/metabox/context/tab/js/scripts'
import 'presstify-framework/field/media-image/js/scripts'
import 'presstify-framework/field/text-remaining/js/scripts'
import 'presstify-framework/field/toggle-switch/js/scripts'

jQuery(document).ready(function ($) {
  $('#poststuff #SingleHeader-switcher').on('toggle-switch:change toggle-switch:init', function () {
    let $target = $($(this).data('target'))

    if ($(this).val() === 'on') {
      $target.show()
    } else {
      $target.hide()
    }
  })

  $('#poststuff #ArchiveBannerAdjust-switcher').on('toggle-switch:change toggle-switch:init', function () {
    let $target = $($(this).data('target'))

    if ($(this).val() === 'on') {
      $target.attr('data-format', 'contain')
    } else {
      $target.attr('data-format', 'cover')
    }
  })
})