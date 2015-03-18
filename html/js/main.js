/**
 * Created by thienduc on 3/1/2015.
 */

$(document).ready(function() {
    $(".project-detail:gt(0)").hide();

    // Slider on Project Details page
    var $menuContainer = $(".sub-nav-project-detail");
    $menuContainer.find("a").click(function() {
        var $target = $(this);
        var $parent = $target.parent();
        if ($parent.hasClass("active")) {
            return;
        }
        $menuContainer.find("li.active").removeClass("active");
        $parent.addClass("active");
    });

});