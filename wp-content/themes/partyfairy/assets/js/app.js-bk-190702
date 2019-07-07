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
    $(".page-content").css("padding-top", headerHeight)
}
$(window).resize(function() {
    if ($(window).width() < 1200) {
        var e = $("header").height();
        $(".page-content").css("padding-top", e)
    } else {
        e = $("header").height();
        $(".page-content").css("padding-top", "0")
    }
}), $(".-opener").click(function() {
    $(this).next().toggleClass("active"), $(this).toggleClass("-opened-")
}), $(".-plus, .-minus").click(function(e) {
    var i = $(this),
        t = $(this).parent().find(".input-quantity"),
        s = parseInt($(this).parent().find(".input-quantity").val());
    NaN != s && i.hasClass("-plus") ? t.val(s + 1) : NaN != s && i.hasClass("-minus") && 2 <= s && t.val(s - 1)
}), $(".-pickdly").on("click", function() {
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
}), $(".-carousel-tabs").slick({
    infinite: !0,
    slidesToShow: 8,
    variableWidth: !0,
    swipeToSlide: !0
}), $(function() {
    $('[data-toggle="tooltip"]').tooltip()
}), $(".-my-paroller").paroller(), $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').not("[data-disable-scroll]").click(function(e) {
    if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
        var i = $(this.hash);
        (i = i.length ? i : $("[name=" + this.hash.slice(1) + "]")).length && (e.preventDefault(), $("html, body").animate({
            scrollTop: i.offset().top - 200
        }, 1e3, function() {
            var e = $(i);
            if (e.focus(), e.is(":focus")) return !1;
            e.attr("tabindex", "-1"), e.focus()
        }))
    }
}), $(window).scroll(function() {
    700 <= $(window).scrollTop() ? ($(".carousel-tabs").addClass("fixed-pos"), $(".fixed-pos").css("top", $("header").height() + "px"), $(".fixed-pos").css("margin-top", "0")) : $(".carousel-tabs").removeClass("fixed-pos")
}), $(".page-content").css("padding-top", $("header").height() + "px"), $(".-display-checkbox").change(function() {
    this.checked ? $(this).closest(".checkbox-wrap").find(".-display-target").show() : $(this).closest(".checkbox-wrap").find(".-display-target").hide()
});
//# sourceMappingURL=app.js.map