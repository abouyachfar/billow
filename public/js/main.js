$(document).ready(function(){
    getRegions();
    getPropertyTypesCategories();

    // Start When Click on page, Hide creteria areas
    /*$("body").on("click", function(e){
        var container1 = $(".combo-cretaria-title");
        var container2 = $("#input_search_text");

        if (!container1.is(e.target) && !container2.is(e.target)) {
            $(".cities-search-area").addClass("hidden");
            $(".types-property-items").addClass("hidden");
        }
    });*/
    // End When Click on page, Hide creteria areas

    // Start Focus On Input Search Text
    $("#input_search_text").on("click", function(){
        if ($(".cities-search-area").hasClass("hidden")) {
            $(".cities-search-area").removeClass("hidden");
        } else {
            $(".cities-search-area").addClass("hidden");
        }
    });
    // End Focus On Input Search Text

    // Start Click on title of creteria combobox action
    $(".combo-cretaria-title").on("click", function(){
        if($(this).next(".types-property-items").hasClass("hidden")) {
            $(".types-property-items").each(function(){
                $(this).addClass("hidden");
            });

            $(this).next(".types-property-items").removeClass("hidden");
        }else{
            $(this).next(".types-property-items").addClass("hidden");
        }
    });

    $(".combo-cretaria-bedrooms-title").on("click", function(){
        if($(this).next(".bedrooms-items").hasClass("hidden")) {
            $(this).next(".bedrooms-items").removeClass("hidden");
        }else{
            $(this).next(".bedrooms-items").addClass("hidden");
        }
    });
    // End Click on title of creteria combobox action

    // Start Click on item of creteria
    $(".cities-search-area").on("click", ".types-property-item", function(){
        $(".types-property-subitems").each(function(){
            $(this).addClass("hidden");
        });

        if($(this).next(".types-property-subitems").hasClass("hidden")) {
            $(this).next(".types-property-subitems").removeClass("hidden");
        }else{
            $(this).next(".types-property-subitems").addClass("hidden");
        }
    });

    $(".cities-search-area").on("click", ".bedroom-item", function(){
        $(".bedroom-subitems").each(function(){
            $(this).addClass("hidden");
        });

        if($(this).next(".bedroom-subitems").hasClass("hidden")) {
            $(this).next(".bedroom-subitems").removeClass("hidden");
        }else{
            $(this).next(".bedroom-subitems").addClass("hidden");
        }
    });

    $(".combo-critaria").on("click", ".types-property-item", function(){
        $(".types-property-subitems").each(function(){
            $(this).addClass("hidden");
        });

        if($(this).next(".types-property-subitems").hasClass("hidden")) {
            $(this).next(".types-property-subitems").removeClass("hidden");
        }else{
            $(this).next(".types-property-subitems").addClass("hidden");
        }
    });
    // End Click on item of creteria

    // Start Click on subitem of creteria
    $(".cities-search-area").on("click", ".cretaria-element", function(){
        $(".cretaria-choice").removeClass("hidden");

        if ($(this).data("type") == "chambres") {
            $(".cretaria-element").each(function(){
                if ($(this).type="chambres") {
                    $(this).prop('checked', false);
                }
            });

            $(this).prop('checked', true);

            if ($("#cretaria-choices").find("#badrooms-cretaria").length) {
                var _html = "<div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='badrooms'>X</div>";
                $("#badrooms-cretaria").html(_html);
            } else {
                var _html = "<div id='badrooms-cretaria'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='badrooms'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
        } else if ($(this).data("type") == "types_properties") {
            $("#cretaria-choices").append("<div class='property-type'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='types_properties'>X</div></div>");
        } else if ($(this).data("type") == "city") {
            $("#cretaria-choices").append("<div class='cities-cretaria'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='city'>X</div></div>");
        }
    });

    $(".combo-critaria").on("click", ".cretaria-element", function(){
        $(".cretaria-choice").removeClass("hidden");

        if ($(this).data("type") == "chambres") {
            $(".cretaria-element").each(function(){
                if ($(this).type="chambres") {
                    $(this).prop('checked', false);
                }
            });

            $(this).prop('checked', true);

            if ($("#cretaria-choices").find("#badrooms-cretaria").length) {
                var _html = "<div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='badrooms'>X</div>";
                $("#badrooms-cretaria").html(_html);
            } else {
                var _html = "<div id='badrooms-cretaria'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='badrooms'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
        } else if ($(this).data("type") == "types_properties") {
            $("#cretaria-choices").append("<div class='property-type'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='types_properties'>X</div></div>");
        } else if ($(this).data("type") == "city") {
            $("#cretaria-choices").append("<div class='cities-cretaria'><div class='cretaria-text'>" + $(this).data("label") + "</div><div class='cretaria-remove' data-type='city'>X</div></div>");
        }
    });
    // End Click on subitem of creteria

    // Start Click on creteria remove bouton
    $("#cretaria-choices").on("click", ".cretaria-remove", function(){
        $(this).parent('div').remove();

        $(".cretaria-element").each(function(){
            if ($(this).data("type") == "chambres") {
                $(this).prop('checked', false);
            }
        });

        if ($(".property-type").length === 0) {
            $(".cretaria-element").each(function(){
                if ($(this).data("type") == "types_properties") {
                    $(this).prop('checked', false);
                }
            });
        }

        if ($("#cretaria-choices").text() == "") {
            $(".cretaria-choice").addClass("hidden");
        }
    });
    // End Click on creteria remove bouton

    // Start Click on button reset cretaria
    $(".btn-reset-cretaria").on("click", function(){
        $(".cretaria-choice").addClass("hidden");
        $("#cretaria-choices").html("");
    });
    // End Click on button reset cretaria

    $("#btn-user").on("click", function(){
        if ($(".user-links").hasClass("hidden")) {
            $(".user-links").removeClass("hidden");
        } else {
            $(".user-links").addClass("hidden");
        }
    });

    $(".btn-rechercher").on("click", function(){
        /*var region = $("#region").val();
        var city = $("#city").val();
        var type_of_property = $("#type_property").val();
        var bedrooms = $("#bedrooms").val();
        var price = $("#price").val();*/

        var properties = searchPropertiesJson(1, 1, 3);
    });
});