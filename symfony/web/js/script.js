$(document).ready(function () {
    //range selector
    $('#range').on("change mousemove", function () {
        $value = $(this).val();
        $('#range-value').text($value);
    });

    //Form submit
    $('form').submit(function (event) {
        //show loading animation
        $('.result').empty();
        $(".result").append('<div class="progress"><div class="indeterminate"></div></div>');
        //get form data
        var formData = {
                'location': $('#location').val(),
                'range': $('span#range-value').text(),
                'weekend': $('#weekend:checked').length,
                'support': $('#support:checked').length
            },
            url = '/api/v1/offices';
        url += '?location=' + formData['location'] + '&range=' + formData['range'] + '&weekend=' + formData['weekend'] + '&support=' + formData['support'];

        //process the form
        $.ajax({
            type: 'POST',
            url: url,
            data: 'json',
            encode: true
        })
            .done(function (data) {
                showOffices(data);
            })
            .fail(function (data) {
                console.log(data);
            });

        // Prevent form from submitting (cause refresh).
        event.preventDefault();
    });


});

function showOffices(data) {
    $result = $('.result');

    $result.empty();
    $result.append('<ul class="collection with-header"></ul>');
    $collection = $('.result .collection');
    $collection.append('<li class="collection-header">'
        + '<h4>' + data.results.length + (data.results.length == 1 ? ' office' : ' offices') + ' found.' + '</h4>'
        + '</li>');


    var resultItem = "";

    $.each(data.results, function (index, office) {
        resultItem += '<li class="collection-item avatar">'
            + '<i class="material-icons circle">work</i>'
            + '<span class="title">' + office.street + ', ' + office.city + '</span>'
            + '<p>Open in the weekends:<i class="material-icons tiny">' + (office.isOpenInWeekends == "Y" ? "done" : "clear") + '</i><br>'
            + 'Has support desk:<i class="material-icons tiny">' + (office.hasSupportDesk == "Y" ? "done" : "clear") + '</i><br>'
            + 'Distance: ' + parseFloat(office.distance).toFixed(2) + ' km.</p>'
            + '</li>';
    });

    $collection.append(resultItem);
    officesMap(data.curLoc, data.results);
}

function officesMap(curLoc, data) {
    initMap();
    var myLatLng = curLoc;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: myLatLng
    });
    $.each(data, function (index, value) {
        var myLatLng = {lat: value.latitude, lng: value.longitude}
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    })
}

function initMap() {
    var myLatLng = {lat: -30.363, lng: 131.044};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: myLatLng
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Hello World!'
    });

    // To add the marker to the map, call setMap();
    marker.setMap(map);
}