function getRegions() {
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: "/fr/regionsJson",
        cache: false,
        success: function (regions) {
            $(".cities-search-area").html("");
            var _html = "";

            console.log(regions.length);
            
            for (var i=0; i<regions.length; i++) {
                _html += '<span class="types-property-item"><i class="fa fa-angle-right"></i> ' + regions[i]["label"] + '</span>';
                _html += '<div class="types-property-subitems hidden">';

                for (var j=0; j<regions[i]["cities"].length; j++) {
                    
                    _html += '<div class="form-group">';
                    _html += '<input class="cretaria-element" type="checkbox" id="1-0" value="Tous" data-type="city" data-label="' + regions[i]["cities"][j]["label"] + '" data-type="city"/><label>' + regions[i]["cities"][j]["label"] + '</label>';
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
                _html += '<span class="types-property-item"><i class="fa fa-angle-right"></i> ' + propertyTypesCategories[i]["label"] + '</span>';
                _html += '<div class="types-property-subitems hidden">';

                for (var j=0; j<propertyTypesCategories[i]["propertyTypes"].length; j++) {
                    
                    _html += '<div class="form-group">';
                    _html += '<input class="cretaria-element" type="checkbox" id="1-0" value="Tous" data-type="types_properties" data-label="' + propertyTypesCategories[i]["propertyTypes"][j]["label"] + '" data-type="types_properties"/><label>' + propertyTypesCategories[i]["propertyTypes"][j]["label"] + '</label>';
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

function searchPropertiesJson(region_id, city_id, bedrooms) {
    var url = "/fr/search?region_id="+region_id+"&city_id="+city_id+"&bedrooms="+bedrooms;
    document.location = url;

    /*$.ajax({
        type: 'GET',
        datatype: 'json',
        url: "/fr/searchJson?region_id="+region_id+"&city_id="+city_id+"&bedrooms="+bedrooms,
        cache: false,
        success: function (properties) {
            console.log(properties);

            return properties
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log('erreur');
        }
    });*/
}