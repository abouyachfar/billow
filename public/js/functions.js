function getRegions(key) {
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: "/fr/regionsJson?key="+key,
        cache: false,
        success: function (regions) {
            $(".cities-search-area").html("");
            var _html = "";
            
            for (var i=0; i<regions.length; i++) {
                _html += '<span class="types-property-item"><i class="fa fa-angle-right"></i> ' + regions[i]["label"] + '</span>';
                _html += '<div class="types-property-subitems hidden">';

                for (var j=0; j<regions[i]["cities"].length; j++) {
                    
                    _html += '<div class="form-group">';
                    _html += '<input id="city_'+regions[i]["cities"][j]["id"]+'" class="cretaria-element" type="checkbox" data-value="'+regions[i]["cities"][j]["id"]+'" data-type="city" data-label="' + regions[i]["cities"][j]["label"] + '" data-type="city"/><label for="city_'+regions[i]["cities"][j]["id"]+'">' + regions[i]["cities"][j]["label"] + '</label>';
                    _html += '</div>';
                }

                _html += '</div>';
            }

            $(".cities-search-area").html(_html);

            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('erreur');
        }
    });
}

function getCities(key) {
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: "/fr/citiesJson?key="+key,
        cache: false,
        success: function (cities) {
            $(".cities-search-area").html("");
            var _html = "";
            
            _html += '<div class="types-property-subitems hidden">';

            for (var i=0; i<cities.length; i++) {
                
                _html += '<div class="form-group">';
                _html += '<input id="city_'+cities[i]["id"]+'" class="cretaria-element" type="checkbox" data-value="'+cities[i]["id"]+'" data-type="city" data-label="' + cities[i]["label"] + '" data-type="city"/><label for="city_'+cities[i]["id"]+'">' + cities[i]["label"] + '</label>';
                _html += '</div>';
            }

            _html += '</div>';

            $(".cities-search-area").html(_html);

            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('erreur');
        }
    });
}

function getPropertyTypesCategories() {
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: "/fr/propertyTypesCategoriesJson",
        cache: false,
        success: function (propertyTypesCategories) {
            $(".types-property-items").html("");
            var _html = "";
            
            for (var i=0; i<propertyTypesCategories.length; i++) {
                //_html += '<span class="types-property-item"><i class="fa fa-angle-right"></i> ' + propertyTypesCategories[i]["label"] + '</span>';
                if (i==0) {
                    _html += '<div class="types-property-subitems">';
                } else {
                    _html += '<div class="types-property-subitems hidden">';
                }

                for (var j=0; j<propertyTypesCategories[i]["propertyTypes"].length; j++) {
                    
                    _html += '<div class="form-group">';
                    _html += '<input id="property_type_'+propertyTypesCategories[i]["propertyTypes"][j]["id"]+'" class="cretaria-element" type="checkbox" data-value="'+propertyTypesCategories[i]["propertyTypes"][j]["id"]+'" data-type="types_properties" data-label="' + propertyTypesCategories[i]["propertyTypes"][j]["label"] + '" data-type="types_properties"/><label for="property_type_'+propertyTypesCategories[i]["propertyTypes"][j]["id"]+'">' + propertyTypesCategories[i]["propertyTypes"][j]["label"] + '</label>';
                    _html += '</div>';
                }

                _html += '</div>';
            }

            $(".types-property-items").html(_html);

            return false;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('erreur');
        }
    });
}

function searchPropertiesJson(page_name, cities, bedrooms, price_min, price_max, property_types, bathrooms, living_area_min, living_area_max, lot_size_min, lot_size_max) {
    price_min = price_min.replace(/\s/g, "");
    price_max = price_max.replace(/\s/g, "");

    var url = page_name;

    if (bathrooms != null) {
        url += "&bathrooms="+bathrooms;
    }

    if (living_area_min != null) {
        url += "&living_area_min="+living_area_min;
    }

    if (living_area_max != null) {
        url += "&living_area_max="+living_area_max;
    }

    if (lot_size_min != null) {
        url += "&lot_size_min="+lot_size_min;
    }

    if (lot_size_max != null) {
        url += "&lot_size_max="+lot_size_max;
    }

    var lang = $('html').attr('lang');

    $.ajax({
        type: 'POST',
        datatype: 'json',
        url: "/"+lang+"/list",
        data: {"pagename": page_name, "cities": cities, "bedrooms": bedrooms, "price_min": price_min, "price_max": price_max,
                "property_types": property_types, "bathrooms": bathrooms, "living_area_min": living_area_min,
                "living_area_max": living_area_max, "lot_size_min": lot_size_min, "lot_size_max": lot_size_max},
        cache: false,
        success: function (result) {
            document.location = "/"+lang+"/"+page_name;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('erreur');
        }
    });
}

function previewFile(input) {
    var file = jQuery(input).get(0).files[0];

    if(file){
        var reader = new FileReader();

        reader.onload = function(){
            jQuery(input).parent().find(".div-picture-content-img").html("");
            jQuery(input).parent().find(".div-picture-content-img").append("<img src='"+reader.result+"' width='100%' height='100%' />");
        }

        reader.readAsDataURL(file);
    }
}

/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
    x.style.display = "none";
    } else {
    x.style.display = "block";
    }
}