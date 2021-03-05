"use strict";

jQuery(document).ready(function ($) {
  $("button.qty-button").click(function (e) {
    e.preventDefault();
    var step = parseInt($(this).attr("data-inc"), 10);
    var dec = $(this).hasClass("qty-minus");
    var input = $(this).siblings("input[type=number].qty");
    /*if(dec) {
        input = $(this).siblings("input[type=number].qty");
    }
    else {
        input = $(this).prev("input[type=number].qty");
    }*/
    var min = parseInt(input.attr("min"), 10);
    var max = parseInt(input.attr("max"), 10);
    var cur = parseInt(input.val(), 10);

    min = !isNaN(min) ? min : 1;
    max = !isNaN(max) ? max : Number.MAX_SAFE_INTEGER;

    if (dec) {
      if (cur > min) {
        cur -= step;
        cur = Math.max(cur, min);
      }
    } else {
      if (cur < max) {
        cur += step;
        cur = Math.max(cur, min);
      }
    }

    input.val(cur.toString());
  });
});
