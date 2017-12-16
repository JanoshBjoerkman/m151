// Eventlistener 
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

// help functions:
function show_dialog(message) {
    return confirm(message);
}

function refresh_manage_table(url, tbl_id) {
    $request = $.ajax({
        type: "POST",
        url: url
    });
    $request.done(function(response, textStatus, jqXHR) {
        $('#' + tbl_id).children('tbody').html(response);
    });
}

function reset_manage_alert() {
    $('#manage_alert').hide();
    $('#manage_alert').removeClass();
    $('#manage_alert').addClass('alert');
}

// courses functions:
function remove_course_day() {
    var course_days = $("*[id^='course_day_panel-']").length;
    if (course_days > 1) {
        var last_course_day_panel = '#course_day_panel-' + course_days;
        $(last_course_day_panel).hide('slow', function() {
            $(last_course_day_panel).remove();
        });
    }
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

function delete_course(course_id) {
    if (show_dialog("Der Kurs und alle dazugehörigen Kurstage, sowie Teilnehmer werden unwiederruflich gelöscht.\nWollen Sie wirklich fortfahren?")) {
        $request = $.ajax({
            type: "POST",
            url: "manage/delete_course",
            data: { ID: course_id }
        });
        $request.done(function(response, textStatus, jqXHR) {
            refresh_manage_table("manage/refresh_courses_table", "tbl_all_courses");
        });
        $request.fail(function(jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        });
    }
}

function show_course_info(course_id) {
    $request = $.ajax({
        type: "POST",
        url: "manage/show_course_info",
        data: { ID: course_id }
    });
    $request.done(function(response, textStatus, jqXHR) {
        $('#show_course_info_modal .modal-body').html(response);
        $('#show_course_info_modal').modal('show', { backdrop: 'static' });
        // fitt dynamic content in modal body (between the small grey lines)
        $('#show_course_info_modal .modal-body').css({
            'overflow-y': 'auto'
        });
    });
}

// event functions:
function delete_event(event_id) {
    if (show_dialog("Der Event und alle dazugehörigen Kurse (inklusive Teilnehmerlisten) werden gelöscht.\nWollen Sie wirklich fortfahren?")) {
        $request = $.ajax({
            type: "POST",
            url: "manage/delete_event",
            data: { ID: event_id }
        });
        $request.done(function(response, textStatus, jqXHR) {
            refresh_manage_table("manage/refresh_events_table", "tbl_all_events");
        });
        $request.fail(function(jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        });
    } else {
        alert("Vorgang abgebrochen.");
    }
}

function change_event_visibility(event_id, element) {
    var visibility = $(element).is(':checked');
    $request = $.ajax({
        type: "POST",
        url: "manage/change/event_visibility",
        data: {
            ID: event_id,
            visible: visibility
        }
    });
    $request.done(function(response, textStatus, jqXHR) {
        reset_manage_alert();
        if (response == "success") {
            $('#manage_alert').addClass('alert-success');
            $('#manage_alert_text').text("Die Sichtbarkeit wurde erfolgreich geändert.");
        } else {
            $('#manage_alert').addClass('alert-danger');
            $('#manage_alert_text').text("Konnte die Sichtbarkeit nicht ändern. Versuchen Sie es nochmals oder wenden Sie sich an den Administrator.");
        }
        refresh_manage_table("manage/refresh_courses_table", "tbl_all_courses");
        $('#manage_alert').show('slow');
    });
}