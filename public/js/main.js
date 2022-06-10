$(document).ready(function(){
    getRegions();
    getPropertyTypesCategories();

    // Start When Click on page, Hide creteria areas
    $(document).on("click", function(e){
        var clicked = $(e.target);

        if(!clicked.hasClass("combo-cretaria-title") 
            && !clicked.hasClass("types-property-items")
            && !clicked.hasClass("types-property-item")
            && !clicked.hasClass("types-property-subitems")
            && !clicked.hasClass("cretaria-element")
            && !clicked.parent().hasClass("types-property-subitems")
            && !clicked.parent().parent().hasClass("types-property-subitems")){
            $(".types-property-items").addClass("hidden");
        }

        if (!clicked.hasClass("combo-cretaria-more-title")
            &&!clicked.hasClass("other-criterias-items")
            && !clicked.hasClass("other-criteria-item")
            && !clicked.hasClass("more-criterias-label")
            && !clicked.hasClass("combo-cretaria-bathrooms-title")
            && !clicked.hasClass("bathrooms-items")
            && !clicked.parent().hasClass("bathrooms-items")
            && !clicked.parent().parent().hasClass("bathrooms-items")
            && !clicked.parent().parent().parent().hasClass("bathrooms-items")
            && !clicked.hasClass("combo-cretaria-living-area-title")
            && !clicked.hasClass("living-area-items")
            && !clicked.hasClass("living-area-min")
            && !clicked.hasClass("combo-cretaria-living-area-title")
            && !clicked.hasClass("living-area-max")
            && !clicked.hasClass("combo-cretaria-lot-size-title")
            && !clicked.hasClass("lot-size-items")
            && !clicked.hasClass("lot-size-min")
            && !clicked.hasClass("lot-size-max")
            && !clicked.parent().hasClass("combo-cretaria-bathrooms-title")
            && !clicked.parent().hasClass("combo-cretaria-living-area-title")
            && !clicked.parent().hasClass("combo-cretaria-lot-size-title")) {
            $(".other-criterias-items").addClass("hidden");
        }

        if(!clicked.hasClass("search-bar-text")
            && !clicked.hasClass("types-property-item")
            && !clicked.hasClass("types-property-subitems")
            && !clicked.hasClass("cretaria-element")
            && !clicked.parent().hasClass("types-property-subitems")
            && !clicked.parent().parent().hasClass("types-property-subitems")){
            $(".cities-search-area").addClass("hidden");
        }

        if(!clicked.hasClass("address-search-area")
            && !clicked.hasClass("address-search-item")){
            $("#address-search-area").addClass("hidden");
        }

        if(!clicked.hasClass("combo-cretaria-bedrooms-title")
            && !clicked.hasClass("bedrooms-items")
            && !clicked.hasClass("cretaria-element")
            && !clicked.parent().hasClass("bedrooms-items")
            && !clicked.parent().parent().hasClass("bedrooms-items")){
            $(".bedrooms-items").addClass("hidden");
        }

        if(!clicked.hasClass("address-autocomplete-class") 
            && !clicked.hasClass("address-autocomplete-item")
            && !clicked.hasClass("street-class")){
            $("#address-autocomplete").addClass("hidden");
        }
    });
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

    // Start change On Input Search Text
    $("#input_search_text").on("keyup", function(){
        var text = jQuery(this).val();

        if (text.length >= 3) {
            $(".cities-search-area").addClass("hidden");
            $("#address-search-area").removeClass("hidden");
            $("#address-search-area").html("<p class='loading'>loading...</p>");

            var _html = "";

            $.ajax({
                type: 'GET',
                url: "/en/seacheAddressesJSON?text=" + text,
                cache: false,
                success: function (result) {
                    $("#address-search-area").html("");

                    result.forEach( property => {
                        _html += "<div class='address-search-item pointer' data-id='" + property.id + "'>" + property.street + "</div>";
                    });

                    jQuery("#address-search-area").html(_html);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('erreur');
                }
            });
        }
    });

    $(".address-search-area").on("click", ".address-search-item", function(){
        var id = $(this).data("id");
        location.href = "/en/details/" + id + "/list";
    });
    // End change On Input Search Text

    // Start Cities Filter
    /*$("#input_search_text").on("change", function(){
        var key = $(this).val();

        if (key.length >= 3) {
            getCities(key);
            $(".cities-search-area").removeClass("hidden");
            $(".types-property-subitems").removeClass("hidden");
        } else if (key.length == 0) {
            getRegions();
            $(".cities-search-area").removeClass("hidden");
            $(".types-property-subitems").removeClass("hidden");
        }
    });*/
    // End Cities Filter

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

    // Start Click on title of more criterias
    $(".combo-cretaria-more-title").on("click", function(){
        if($(this).next(".other-criterias-items").hasClass("hidden")) {
            $(this).next(".other-criterias-items").removeClass("hidden");
        }else{
            $(this).next(".other-criterias-items").addClass("hidden");
        }
    });
    // End Click on title of more criterias

    // Start Click on Bathrooms
    $(".combo-cretaria-bathrooms-title").on("click", function(){
        if($(this).next(".bathrooms-items").hasClass("hidden")) {
            $(this).next(".bathrooms-items").removeClass("hidden");
        }else{
            $(this).next(".bathrooms-items").addClass("hidden");
        }
    });
    // end Click on Bathrooms

    // Start Click on combo-cretaria-living-area-title
    $(".combo-cretaria-living-area-title").on("click", function(){
        if($(this).next(".living-area-items").hasClass("hidden")) {
            $(this).next(".living-area-items").removeClass("hidden");
        }else{
            $(this).next(".living-area-items").addClass("hidden");
        }
    });
    // End Click on combo-cretaria-living-area-title

    // Start Click on combo-cretaria-living-area-title
    $(".combo-cretaria-lot-size-title").on("click", function(){
        if($(this).next(".lot-size-items").hasClass("hidden")) {
            $(this).next(".lot-size-items").removeClass("hidden");
        }else{
            $(this).next(".lot-size-items").addClass("hidden");
        }
    });
    // End Click on combo-cretaria-living-area-title

    // Start Click on living-area-items
    $(".living-area-min").on("click", function(){
        $(".living-area-min").each(function(){
            $(this).removeClass("active");
        });

        $(this).addClass("active");

        var _html = $(this).data("label") + ' <i class="fa fa-angle-down"></i>';
        $(this).parent().prev('.combo-cretaria-living-area-title').html(_html);

        var min = jQuery(".living-area-min.active").text();
        var max = jQuery(".living-area-max.active").text();
        var message = "";

        if ((min == "" || min == "Min") && (max == "" || max == "Max")) {
            $("#living-area-cretaria").remove();
        } else {
            if (min == "" || min == "Min") {
                message = _trans("Max ") + max;
            } else if (max == "" || max == "Max") {
                message = _trans("Min ") + min;
            } else {
                message = min + " - " + max;
            }

            if ($("#cretaria-choices").find("#living-area-cretaria").length > 0) {
                var _html = "<div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. area</div><div class='cretaria-remove' data-type='living-area'>X</div>";
                $("#living-area-cretaria").html(_html);
            } else {
                var _html = "<div id='living-area-cretaria'><div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. area</div><div class='cretaria-remove' data-type='living-area'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
    
            $(".cretaria-choice").removeClass("hidden");
        }

        if ($(".cretaria-text").length == 1) {
            $(".cretaria-choice").addClass("hidden");
        }

        $(this).parent().addClass("hidden");
    });

    jQuery(".living-area-max").on("click", function(){
        jQuery(".living-area-max").each(function(){
            jQuery(this).removeClass("active");
        });

        jQuery(this).addClass("active");

        var _html = jQuery(this).data("label") + ' <i class="fa fa-angle-down"></i>';
        jQuery(this).parent().prev('.combo-cretaria-living-area-title').html(_html);

        var min = jQuery(".living-area-min.active").text();
        var max = jQuery(".living-area-max.active").text();
        var message = "";

        if ((min == "" || min == "Min") &&  (max == "" || max == "Max")) {
            $("#living-area-cretaria").remove();
        } else {
            if (min == "" || min == "Min") {
                message = _trans("Max ") + max;
            } else if (max == "" || max == "Max") {
                message = _trans("Min ") + min;
            } else {
                message = min + " - " + max;
            }

            if ($("#cretaria-choices").find("#living-area-cretaria").length > 0) {
                var _html = "<div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. area</div><div class='cretaria-remove' data-type='living-area'>X</div>";
                $("#living-area-cretaria").html(_html);
            } else {
                var _html = "<div id='living-area-cretaria'><div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. area</div><div class='cretaria-remove' data-type='living-area'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
    
            $(".cretaria-choice").removeClass("hidden");
        }

        if ($(".cretaria-text").length == 1) {
            $(".cretaria-choice").addClass("hidden");
        }

        jQuery(this).parent().addClass("hidden");
    });
    // End Click on living-area-items

    // Start Click on lot-size-items
    jQuery(".lot-size-min").on("click", function(){
        jQuery(".lot-size-min").each(function(){
            jQuery(this).removeClass("active");
        });

        jQuery(this).addClass("active");

        var _html = jQuery(this).data("label") + ' <i class="fa fa-angle-down"></i>';
        jQuery(this).parent().prev('.combo-cretaria-lot-size-title').html(_html);

        var min = jQuery(".lot-size-min.active").text();
        var max = jQuery(".lot-size-max.active").text();
        var message = "";

        if ((min == "" || min == "Min") &&  (max == "" || max == "Max")) {
            $("#lot-size-cretaria").remove();
        } else {
            if (min == "" || min == "Min") {
                message = _trans("Max ") + max;
            } else if (max == "" || max == "Max") {
                message = _trans("Min ") + min;
            } else {
                message = min + " - " + max;
            }

            if ($("#cretaria-choices").find("#lot-size-cretaria").length > 0) {
                var _html = "<div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. lot</div><div class='cretaria-remove' data-type='lot-size'>X</div>";
                $("#lot-size-cretaria").html(_html);
            } else {
                var _html = "<div id='lot-size-cretaria'><div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. lot</div><div class='cretaria-remove' data-type='lot-size'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
    
            $(".cretaria-choice").removeClass("hidden");
        }

        if ($(".cretaria-text").length == 1) {
            $(".cretaria-choice").addClass("hidden");
        }

        jQuery(this).parent().addClass("hidden");
    });

    jQuery(".lot-size-max").on("click", function(){
        jQuery(".lot-size-max").each(function(){
            jQuery(this).removeClass("active");
        });

        jQuery(this).addClass("active");

        var _html = jQuery(this).data("label") + ' <i class="fa fa-angle-down"></i>';
        jQuery(this).parent().prev('.combo-cretaria-lot-size-title').html(_html);

        var min = jQuery(".lot-size-min.active").text();
        var max = jQuery(".lot-size-max.active").text();
        var message = "";

        if ((min == "" || min == "Min") &&  (max == "" || max == "Max")) {
            $("#lot-size-cretaria").remove();
        } else {
            if (min == "" || min == "Min") {
                message = _trans("Max ") + max;
            } else if (max == "" || max == "Max") {
                message = _trans("Min ") + min;
            } else {
                message = min + " - " + max;
            }

            if ($("#cretaria-choices").find("#lot-size-cretaria").length > 0) {
                var _html = "<div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. lot</div><div class='cretaria-remove' data-type='lot-size'>X</div>";
                $("#lot-size-cretaria").html(_html);
            } else {
                var _html = "<div id='lot-size-cretaria'><div class='cretaria-text' data-min='"+min+"' data-max='"+max+"' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + message + " sq. ft. lot</div><div class='cretaria-remove' data-type='lot-size'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
    
            $(".cretaria-choice").removeClass("hidden");
        }

        if ($(".cretaria-text").length == 1) {
            $(".cretaria-choice").addClass("hidden");
        }

        jQuery(this).parent().addClass("hidden");
    });
    // End Click on lot-size-items

    // Start Click on item of creteria
    $(".cities-search-area").on("click", ".types-property-item", function(){
        $(this).find(".types-property-subitems").each(function(){
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

        var trv = false;
        var val = $(this).data("value");
        var label = $(this).data("label");

        $(".cretaria-text").each(function(){
            if ($(this).data("label") === label) {
                trv = true;
            }
        });

        if ($(this).prop('checked') == true) {
            if (!trv) {
                if ($(this).data("type") == "chambres") {
                    $(".cretaria-element").each(function(){
                        if ($(this).type="chambres") {
                            $(this).prop('checked', false);
                        }
                    });
        
                    $(this).prop('checked', true);
        
                    if ($("#cretaria-choices").find("#badrooms-cretaria").length > 0) {
                        var _html = "<div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='badrooms'>X</div>";
                        $("#badrooms-cretaria").html(_html);
                    } else {
                        var _html = "<div id='badrooms-cretaria'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-label='"+$(this).data("label")+"'data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='badrooms'>X</div></div>";
                        $("#cretaria-choices").append(_html);
                    }
                } else if ($(this).data("type") == "types_properties") {
                    $("#cretaria-choices").append("<div class='property-type'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='types_properties'>X</div></div>");
                } else if ($(this).data("type") == "city") {
                    $("#cretaria-choices").append("<div class='cities-cretaria'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='city'>X</div></div>");
                }
            }
        } else {
            // Remove element from your cretarias
            $("#cretaria-choices").find(".cretaria-text").each(function(){
                if ($(this).data("label") == label) {
                    $(this).parent().remove();
                }
            });

            if ($(".cretaria-text").length == 1 && $(".cretaria-text").parent().hasClass("hidden")) {
                $(".cretaria-choice").addClass("hidden");
                
                $(".cretaria-element").each(function(){
                   $(this).prop( "checked", false ); 
                });
            }
        }
    });

    $(".other-criterias-items").on("click", ".cretaria-element", function(){
        if ($(this).data("type") == "bathrooms") {
            $(".cretaria-element").each(function(){
                if ($(this).type="bathrooms") {
                    $(this).prop('checked', false);
                }
            });

            $(this).prop('checked', true);

            if ($("#cretaria-choices").find("#bathrooms-cretaria").length > 0) {
                var _html = "<div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + $(this).data("label") + " " + _trans('bathrooms') + "</div><div class='cretaria-remove' data-type='badrooms'>X</div>";
                $("#bathrooms-cretaria").html(_html);
            } else {
                var _html = "<div id='bathrooms-cretaria'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-label='"+$(this).data("label")+"'data-value='"+$(this).data("value")+"'>" + $(this).data("label") + " " + _trans("bathrooms") + "</div><div class='cretaria-remove' data-type='badrooms'>X</div></div>";
                $("#cretaria-choices").append(_html);
            }
        }
    });

    $(".combo-critaria").on("click", ".cretaria-element", function(){
        $(".cretaria-choice").removeClass("hidden");

        var trv = false;
        var val = $(this).data("value");
        var label = $(this).data("label");

        $(".cretaria-text").each(function(){
            if ($(this).data("label") == label) {
                trv = true;
            }
        });
        
        if ($(this).prop('checked') == true) {
            if (!trv) {
                if ($(this).data("type") == "chambres") {
                    $(".cretaria-element").each(function(){
                        if ($(this).type="chambres") {
                            $(this).prop('checked', false);
                        }
                    });
        
                    $(this).prop('checked', true);
        
                    if ($("#cretaria-choices").find("#badrooms-cretaria").length) {
                        var _html = "<div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='badrooms'>X</div>";
                        $("#badrooms-cretaria").html(_html);
                    } else {
                        var _html = "<div id='badrooms-cretaria'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='badrooms'>X</div></div>";
                        $("#cretaria-choices").append(_html);
                    }
                } else if ($(this).data("type") == "types_properties") {
                    $("#cretaria-choices").append("<div class='property-type'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='types_properties'>X</div></div>");
                } else if ($(this).data("type") == "city") {
                    $("#cretaria-choices").append("<div class='cities-cretaria'><div class='cretaria-text' data-label='"+$(this).data("label")+"' data-value='"+$(this).data("value")+"'>" + _trans($(this).data("label")) + "</div><div class='cretaria-remove' data-type='city'>X</div></div>");
                }
            }
        } else {
            // Remove element from your cretaria
            $("#cretaria-choices").find(".cretaria-text").each(function(){
                if ($(this).data("label") == label) {
                    $(this).parent().remove();
                }
            });

            if ($(".cretaria-text").length == 1 && $(".cretaria-text").parent().hasClass("hidden")) {
                $(".cretaria-choice").addClass("hidden");

                $(".cretaria-element").each(function(){
                    $(this).prop( "checked", false ); 
                 });
            }
        }
    });
    // End Click on subitem of creteria

    // Start Click on creteria remove bouton
    $("#cretaria-choices").on("click", ".cretaria-remove", function(){
        $(this).parent('div').remove();

        if ($(this).data("type") == "chambres") {
            $(".cretaria-element").each(function(){
                $(this).prop('checked', false);
            });
        }else if ($(this).data("type") == "living-area") {
            $(".living-area-min").each(function(){
                $(this).removeClass("active");
            });

            $(".living-area-max").each(function(){
                $(this).removeClass("active");
            });

            $(".combo-cretaria-living-area-title").each(function(){
                if ($(this).hasClass("min")) {
                    var m = _trans("Min ") + '<i class="fa fa-angle-down"></i>';
                    $(this).html(m);
                } else if ($(this).hasClass("max")) {
                    var m = _trans("Max ") + '<i class="fa fa-angle-down"></i>'
                    $(this).html(m);
                }
            });
        } else if ($(this).data("type") == "lot-size") {
            $(".lot-size-max").each(function(){
                $(this).removeClass("active");
            });

            $(".lot-size-max").each(function(){
                $(this).removeClass("active");
            });

            $(".combo-cretaria-lot-size-title").each(function(){
                if ($(this).hasClass("min")) {
                    var m = _trans("Min ") + '<i class="fa fa-angle-down"></i>';
                    $(this).html(m);
                } else if ($(this).hasClass("max")) {
                    var m = _trans("Max ") + '<i class="fa fa-angle-down"></i>';
                    $(this).html(m);
                }
            });
        }
        

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

        if ($(".cretaria-text").length <= 1) {
            $(".cretaria-choice").addClass("hidden");

            $(".cretaria-element").each(function(){
                $(this).prop( "checked", false ); 
            });
        }
    });
    // End Click on creteria remove bouton

    // Start Click on button reset cretaria
    $(".btn-reset-cretaria").on("click", function(){
        $(".cretaria-choice").addClass("hidden");
        $("#cretaria-choices").html("");

        $(".cretaria-element").each(function(){
            $(this).prop( "checked", false ); 
        });
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
        var price_min = jQuery("#cretaria-choices").find("#range-price-lbl").find(".cretaria-text").find("#price_min").text();
        var price_max = jQuery("#cretaria-choices").find("#range-price-lbl").find(".cretaria-text").find("#price_max").text();
        var bedrooms = jQuery("#badrooms-cretaria").find(".cretaria-text").data("value");
        var property_types = [0];
        var cities = [0];
        var bathrooms = jQuery("#bathrooms-cretaria").find(".cretaria-text").data("value");
        var living_area_min = jQuery("#living-area-cretaria").find(".cretaria-text").data("min");
        var living_area_max = jQuery("#living-area-cretaria").find(".cretaria-text").data("max");
        var lot_size_min = jQuery("#lot-size-cretaria").find(".cretaria-text").data("min");
        var lot_size_max = jQuery("#lot-size-cretaria").find(".cretaria-text").data("max");
        var page_name = $(this).data("pagename");

        jQuery("#cretaria-choices").find(".property-type").find(".cretaria-text").each(function(){
            property_types.push(jQuery(this).data("value"));
        });

        jQuery("#cretaria-choices").find(".cities-cretaria").find(".cretaria-text").each(function(){
            cities.push(jQuery(this).data("value"));
        });

        if(cities == '0'){
            cities = "";
        }

        if(property_types == '0'){
            property_types = "";
        }

        if(bedrooms == undefined || bedrooms == '0'){
            bedrooms = "";
        }

        if(price_min == undefined){
            price_min = 0;
        }

        if(price_max == undefined){
            price_max = "";
        }

        if(bathrooms == undefined){
            bathrooms = "";
        }

        if(living_area_min == undefined) {
            living_area_min = "";
        }

        if(living_area_max == undefined) {
            living_area_max = "";
        }

        if(lot_size_min == undefined) {
            lot_size_min = "";
        }

        if(lot_size_max == undefined) {
            lot_size_max = "";
        }

        var properties = searchPropertiesJson(page_name, cities, bedrooms, price_min, price_max, property_types, bathrooms, living_area_min, living_area_max, lot_size_min, lot_size_max);
    });

    // Start Page Pricing - Show Modal
    jQuery("ul.pricing-options li").on("click", function(){
        jQuery(".modal-title").text(jQuery(this).data("title"));
    });
    // End Page Pricing - Show Modal

    // Start Add Favorites
    jQuery("#result-section").on("click", ".add_favorites", function(){
        var property_id = jQuery(this).data("id");
        var elem = jQuery(this);

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/profile/add_favorites",
            data: {"property_id": property_id},
            cache: false,
            success: function (result) {
                if (result == 1) {
                    jQuery(elem).removeClass("add_favorites");
                    jQuery(elem).addClass("remove_favorites");
                    jQuery(elem).addClass("active");
                    jQuery(elem).attr("title", "Remove from my favorites");

                    alert("Succesfully added.");
                } else if(result == -1) {
                    alert("Property already exists in your favorites!");
                } else if (result == 3) {
                    alert("You should be logged in");
                }

                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End Add Favorites

    // Start Remove favorite
    jQuery("#result-section").on("click", ".remove_favorites", function(){
        var property_id = jQuery(this).data("id");
        var elem = jQuery(this);

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/pofile/favorites/delete",
            data: {"property_id": property_id},
            cache: false,
            success: function (result) {
                if (result == 1) {
                    jQuery(elem).removeClass("remove_favorites");
                    jQuery(elem).removeClass("active");
                    jQuery(elem).addClass("add_favorites");
                    jQuery(elem).attr("title", "Add to my favorites");

                    alert("Successfully removed.");
                } else if (result == 3) {
                    alert("You should be logged in");
                }

                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End Remove Favorite

    // Start Remove Property Validation Modal
    jQuery(".remove-property").on("click", function(){
        var id = jQuery(this).data("id");

        jQuery("#btn-delete-property").data("id", id);
    });
    // End Remove Property Validation Modal

    // Start click on btn delete property
    jQuery("#btn-delete-property").on("click", function(){
        var id = jQuery(this).data("id");

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/profile/property/delete",
            data: {"id": id},
            cache: false,
            success: function (result) {
                document.location = "/en/profile/property/myListing";
                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End click on btn delete property

    // Start Refresh Cities if the region is changer
    jQuery("#region").on("change", function(){
        var region_id = jQuery("#region").find(":selected").data("id");

        $.ajax({
            type: 'GET',
            url: "/en/citiesByRegionJson?region_id="+region_id,
            data: {"region_id": region_id},
            cache: false,
            success: function (cities) {
                _html = "";

                for (var i=0; i<cities.length; i++) {
                    _html += "<option value='"+cities[i].id+"'>"+cities[i].label+"</option>";
                }

                jQuery("#city").html(_html);

                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End Refresh Cities if the region is changer

    // Start add new picture
    jQuery("#add-new-picture").on("click", function(){
        var l = jQuery('.div-picture').length;

        if ( l < 8) {
            var _html = "";
            _html += "<div class='div-picture'>";
            _html += "<span class='picture-delete' title='Delete picture'><i class='fa fa-trash'></i></span>";
            _html += "<div class='div-picture-content-img'></div>";
            _html += "<a class='btn btn-primary choose-picture'><i class='fa fa-camera'></i> Add picture file</a>";
            _html += "<input type='file' id='picture-"+(l+1)+"' name='picture-"+(l+1)+"' class='choose-picture-hidden hidden' onchange='previewFile(this);'/>";
            _html += "</div>";

            jQuery("#div-pictures").append(_html);
        } else {
            alert("You have reached the number of photos allowed!")
        }
    });
    // End add new picture

    // Start choose picture
    jQuery("#div-pictures").on("click", ".choose-picture", function(){
        jQuery(this).next(".choose-picture-hidden").click();
    });
    // End choose picture

    // Start Click on Button Delete Picture
    jQuery("#div-pictures").on("click", ".picture-delete", function(){
        var picture_id = jQuery(this).data("id");

        if (picture_id == undefined || picture_id == "") {
            jQuery(this).parent().remove(); 
        } else {
            jQuery("#btn-delete-property-picture").data("id", jQuery(this).data("id"));
            jQuery(this).parent().addClass("toDelete");
        }
    });

    jQuery("#btn-delete-property-picture").on("click", function(){
        var picture_id = jQuery(this).data("id");

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/profile/property/delete_picture",
            data: {"picture_id": picture_id},
            cache: false,
            success: function (result) {
                jQuery(".toDelete").remove();
                jQuery("#btn-close-modal").click();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End Click on Button Delete Picture

    // Start Click on pack option element
    jQuery(".pack-option-elem").on("click", function(){
        var title = jQuery(this).next(".option-title").text();
        var description = jQuery(this).next(".option-title").next(".option-description").text();

        jQuery(".modal-title").html(title);
        jQuery(".modal-body").html("<p>"+description+"</p>");
    });
    // End Click on pack option element

    // Start Click on create_my_alert button
    jQuery("#create_my_alert").on("click", function(){
        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/profile/create_my_alert",
            cache: false,
            success: function (result) {
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });
    // End Click on create_my_alert button

    // Start Address autocomplate
    jQuery("#street").on("keyup", function(){
        jQuery("#address-autocomplete").addClass("hidden");
        _html = "";

        var street = jQuery("#street").val();
        var region = jQuery("#region option:selected").text();
        var text = street + "," + region + ".json";
        var params = text + "?language=fr&access_token=sk.eyJ1IjoiYWJvdXlhY2hmYXIiLCJhIjoiY2t6azIzc2k0MGM5ZjJ1bnowb3dod3d4YiJ9.GU0AVkLTkYscMAf_PBOq_Q";

        $.ajax({
            type: 'GET',
            url: "https://api.mapbox.com/geocoding/v5/mapbox.places/" + params,
            cache: false,
            success: function (result) {
                result.features.forEach( feature => {
                    _html += "<div class='address-autocomplete-item' data-address='" + feature.place_name + "' data-latitude='" + feature.center[1] + "' data-longitude='" + feature.center[0] + "'>" + feature.place_name + "</div>";
                });

                jQuery("#address-autocomplete").html(_html);
                jQuery("#address-autocomplete").removeClass("hidden");

                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });

    // address-autocomplete-item
    jQuery("#address-autocomplete").on("click", ".address-autocomplete-item", function(){
        var address = jQuery(this).data("address");
        var latitude = jQuery(this).data("latitude");
        var longitude = jQuery(this).data("longitude");

        jQuery("#street").val(address);
        jQuery("#latitude").val(latitude);
        jQuery("#longitude").val(longitude);

        jQuery("#address-autocomplete").html(_html);
        jQuery("#address-autocomplete").addClass("hidden");
    });
    // End Address autocomplate

    jQuery("#region").on("change", function(){
        jQuery("#longitude").val("");
        jQuery("#latitude").val("");
    });

    jQuery("#city").on("change", function(){
        jQuery("#longitude").val("");
        jQuery("#latitude").val("");
    });

    jQuery("#street").on("input", function(){
        jQuery("#longitude").val("");
        jQuery("#latitude").val("");
    });
});