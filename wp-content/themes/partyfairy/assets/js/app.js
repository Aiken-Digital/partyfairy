

var count = 1;
    

var inputQty= $('input[name=quantity]').val();

$('#add').click(function () {
        
    count++, inputQty.value = count;

    $('input[name=quantity]').val(count);

});


$('#sub').click(function () {
      
     1 < count && (count--, inputQty.value = count);
    
    $('input[name=quantity]').val(count); 

});








function plus() {
    
    count++, inputQty.value = count;
     console.log(count);

    inputQty.eq(i).val(count);
}

function minus() {
    1 < count && (count--, inputQty.value = count);

    inputQty.eq(i).val(count);
}

function myFunction(e) {
    $("#timerValue").val(e.target.value)
}
var filterHeight = $(".page-content").height(),
    breadcrumbHeight = $(".breadcrumb").height();
if ($(".filter-section").height(filterHeight - breadcrumbHeight), $(".close-filter").click(function() {
        $(".filter-section").hide()
    }), $(".-active-filter-by").click(function() {
        $(".filter-section").show()
    }), $(".-m-expand").click(function() {
        $(this).siblings().closest(".board").toggleClass("expanded"), $(this).toggleClass("active")
    }), $(".burger-menu").click(function() {
        $(".pf-navigation").addClass("active"), $(window).scrollTop(0)
    }), $(".m-close").click(function() {
        $(".pf-navigation").removeClass("active")
    }), $(window).width() < 1200) {
    var headerHeight = $("header").height();
    $(".page-content").css("margin-top", headerHeight)
}
$(window).resize(function() {
    if ($(window).width() < 1200) {
        var e = $("header").height();
        $(".page-content").css("margin-top", e)
    } else {
        e = $("header").height();
        $(".page-content").css("margin-top", "0")
    }
}), $(".-opener").click(function() {
    $(this).next().toggleClass("active"), $(this).toggleClass("-opened-")
});


$(".-pickdly").on("click", function() {
    $("#calendarValue").removeAttr("value"), $("#timerValue").removeAttr("value")
}), $(function() {
    $(".-jquery-tabs").tabs()
}), $(".-info-tab").hide(), $(".-info-tab").first().show(), $(".pf-tab--li").click(function() {
    var e = "#" + $(this).data("target");
    $(".-info-tab").not(e).hide(), $(e).show(), $(".pf-tab--li").removeClass("active"), $(this).addClass("active")
}), $(function() {
    $("#datepicker").datepicker({
        minDate: 0,
        dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
        todayHighlight: !1,
        onSelect: function(e, i) {
            $("#calendarValue").val(e)
        }
    })
}), $(".pf-form").validate({
    ignore: ":hidden:not(.hidden-validate)",
    rules: {
        userpassword: {
            required: !0,
            minlength: 8
        },
        userpasswordconfirm: {
            equalTo: "#userpassword"
        }
    },
    messages: {}
}), $(".-carousel").slick({
    infinite: !0,
    slidesToShow: 5,
    slidesToScroll: 1,
    prevArrow: "<div class='carousel-prev'></div>",
    nextArrow: "<div class='carousel-next'></div>",
    responsive: [{
        breakpoint: 1200,
        settings: {
            slidesToShow: 4,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 1
        }
    }, {
        breakpoint: 768,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 1
        }
    }]
}), $(".-carousel-testimonial").slick({
    infinite: !0,
    slidesToShow: 1,
    slidesToScroll: 1
}), $(function() {
    $('[data-toggle="tooltip"]').tooltip()
}), $(".-my-paroller").paroller();
//# sourceMappingURL=app.js.map