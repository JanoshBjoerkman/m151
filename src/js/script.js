$(document).ready(function() {
    // UI event: remove course day
    $('#remove_course_day').click(function() {
        remove_course_day();
    });
    // UI event: add course day
    $('#add_course_day').click(function() {
        add_course_day();
    });
});

function remove_course_day() {
    var course_days = $("*[id^='course_day_panel-']").length;
    var last_course_day_panel = '#course_day_panel-' + course_days;
    $(last_course_day_panel).hide('slow', function() {
        $(last_course_day_panel).remove();
    });
}

function add_course_day() {
    var course_days = $("*[id^='course_day_panel-']").length;
    var next_id = course_days + 1;
    $request = $.ajax({
        type: "POST",
        url: "manage/add_course_day",
        data: { next_course_day_id: next_id }
    });
    $request.done(function(response, textStatus, jqXHR) {
        var new_day = $(response).hide();
        $('#course_days').append(new_day);
        new_day.show('slow');
    });
}

function delete_event(event_id) {
    var dialog = confirm("Der Event und alle dazugehörigen Kurse (inklusive Teilnehmerlisten) werden gelöscht.\nWollen Sie wirklich fortfahren?");
    if (dialog == true) {
        $request = $.ajax({
            type: "POST",
            url: "manage/delete_event",
            data: { ID: event_id }
        });
        $request.done(function(response, textStatus, jqXHR) {
            refresh_events_table();
        });
        $request.fail(function(jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        });
    } else {
        alert("Vorgang abgebrochen.");
    }
}

function refresh_events_table() {
    $request = $.ajax({
        type: "POST",
        url: "manage/refresh_events_table"
    });
    $request.done(function(response, textStatus, jqXHR) {
        $('#tbl_all_events').children('tbody').html(response);
    });
}