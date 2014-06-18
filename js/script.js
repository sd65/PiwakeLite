$(document).ready(function () {

    // Menu
    $('.menu li a').on('click', function () {

        var newValue = $(this).text();

        if ($(this).closest('ul').hasClass("year")) {
            $.cookie('year', newValue, { expires: 365 });
        }

        if ($(this).closest('ul').hasClass("filiere")) {
            $.cookie('filiere', newValue, { expires: 365 });
        }

        getCalendar($.cookie('year'), $.cookie('week'), $.cookie('filiere'));
    });

    $('.menu select').on('change', function () {

        var newValue = $(this).val();

        $.cookie('week', newValue, { expires: 365 });

        getCalendar($.cookie('year'), $.cookie('week'), $.cookie('filiere'));
    });

    $('.menu .btn-toolbar button').on('click', function () {

        var value = $(this).data("action");

        switch (value) {
        case "prev":
            $.cookie('week', $.cookie('week', Number) - 1, { expires: 365 });
            break;
        case "next":
            $.cookie('week', $.cookie('week', Number) + 1, { expires: 365 });
            break;
        case "now":
            $.cookie('week', getWeek(), { expires: 365 });
            break;
        default:
            break;
        }

        getCalendar($.cookie('year'), $.cookie('week'), $.cookie('filiere'));
    });

    // Setting Cookies (if you want to change default values, it's here !)
    if (typeof $.cookie('cookiesHere') == "undefined") {
        $.cookie('cookiesHere', 'true', { expires: 365 });
        $.cookie('year', (new Date()).getFullYear(), { expires: 365 });
        $.cookie('week', getWeek(), { expires: 365 });
        $.cookie('filiere', 'MMI_S2', { expires: 365 });
    }

    // Calling calendar for first load on page
    getCalendar($.cookie('year'), $.cookie('week'), $.cookie('filiere'));
});


/* Functions below */

// Function to call...calendar
function getCalendar(year, week, filiere) {

    // Show loader bar and hide table
    $('#table').hide();
    $('#loader').show();

    $.ajax({
        type: 'GET',
        url: 'proxy.php',
        data: {
            year: year,
            week: week,
            filiere: filiere
        },
        success: function (raw) {

            // Create Jquery DOM Object (the wrapping div avoid problems)
            var $data = $('<div><table>' + $(raw).find("#entryform > table").html() + '</table></div>');

            // Remove img nodes
            $data.find('img').remove();

            // Remove Samedi
            $data.find('> table > tr:last').remove();

            // Remove a lot of useless sh*t
            $data.find('*').removeAttr('id class style cellspacing cellpadding nowrap border onmouseover onmouseout onclick width height title bgcolor align');

            // Remove hours on each row and add a new td
            $data.find('> table > tbody > tr').each(function (index) {
                if (index % 5 == 0) {
                    var dayArray = $(this).find('p').text().split(' ');
                    day = '<th class="day" colspan="1" rowspan="4">';
                    day += '<p class="dayName">' + dayArray[0] + '</p>';
                    day += '<p class="dayNumber">' + dayArray[1] + '</p>';
                    day += '<p class="dayMonth">' + dayArray[2] + '</p>';
                    day += '<p class="dayYear">' + dayArray[3] + '</p>';
                    day += '</th>';
                    $(this).next().prepend(day).addClass("trNewDay");
                    $(this).remove();
                }
            });

            // Create Course
            $data.find('tbody > tr > td > a > font').each(function () {
                var courseRaw = $(this).text();
                courseRaw = courseRaw.replace(/T([PD])\s([0-3])/g, "<b>T$1$2</b>"); //Bold the TP/TD
                var course = '<p class="course">' + courseRaw + '</p>';
                $(this).closest('td').html(course).addClass("hasCourse");
            });

            // Remove unused data now (but needed to create course)
            $data.find('a.edt').remove();

            // Remove loader bar and show table
            $('#loader').hide();
            $('#table').show();

            // Get content and check if empty
            var output = $data.find('tbody').children();
            if (output.length == 0) {
                output = "<tr><td>Rien à afficher ici ! Essayez une autre semaine !</td></tr>";
            }

            // Output it
            $('#table tbody').html(output);
        }
    });

    updateActive();
}

function updateActive() {
    $('.menu *').removeClass("active").prop('selected', false);;

    $('.menu li a').each(function () {
        switch ($(this).text()) {
        case $.cookie('year'):
            $(this).parent().addClass("active");
            break;
        case $.cookie('filiere'):
            $(this).parent().addClass("active");
            break;
        default:
            break;
        }
    });
    $('.menu select option[value=' + $.cookie('week') + ']').prop('selected', true);
}

Date.prototype.getWeek = function() {
    var onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
} 

function getWeek() {
  var today = new Date();
  return today.getWeek(); 
}
