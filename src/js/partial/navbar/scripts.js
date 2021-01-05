'use strict'

// Dépendances
import jQuery from 'jquery'
import * as inViewport from 'presstify-framework/in-viewport/js/scripts'

// Personnalisation
jQuery(document).ready(function ($){
  let $target = $('.Navbar'),
      $viewport = $('.ArticleHeader'),
      changeColors = function () {
        if (inViewport($target, 70, $viewport)) {
          $target.addClass('inViewport')
        } else {
          $target.removeClass('inViewport')
        }
      }

  $(window).on('scroll resize', changeColors)
  changeColors()
})
