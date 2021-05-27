"use strict";
var agendas = (typeof agendaList === 'undefined') ? [] : JSON.parse(agendaList);

var eventDates = {};

if (agendas.length > 0) {
    $.each(agendas, function(index, agenda) {
        let dateTime = agenda.ReservationDateTime.split(' ');
        let day = dateTime[0];
        eventDates[day] = [
            agenda.id
        ];
    });
}



// set maxDates
var maxDate = {
    1: new Date(new Date().setMonth(new Date().getMonth() + 11)),
    2: new Date(new Date().setMonth(new Date().getMonth() + 10)),
    3: new Date(new Date().setMonth(new Date().getMonth() + 9))
};


var flatpickr = $('#calendar .placeholder').flatpickr({
    inline: true,
    minDate: 'today',
    maxDate: maxDate[3],

    showMonths: 1,
    enable: Object.keys(eventDates),
    disableMobile: "true",
    onChange: function(date, str, inst) {
        let agendaId = '';
        if (date.length) {
            console.log(eventDates[str].length);
            for (let i = 0; i < eventDates[str].length; i++) {
                if (typeof window.CP !== 'undefined' && window.CP.shouldStopExecution(0)) break;
                agendaId = eventDates[str][i];

                return getSpotsView(agendaId);
            }
        }
    },
    locale: {
        weekdays: {
            shorthand: ["S", "M", "T", "W", "T", "F", "S"],
            longhand: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ]
        }
    }
});





eventCaledarResize($(window));
$(window).on('resize', function() {
    eventCaledarResize($(this));
});

function eventCaledarResize($el) {
    var width = $el.width();
    if (width < 400) {
        flatpickr.set('showMonths', 1);

        flatpickr.set('maxDate', maxDate[0]);
        $('.flatpickr-calendar').css('width', '220px');
    }

    if (flatpickr.selectedDates.length) {
        flatpickr.clear();
    }

    if (width >= 992 && flatpickr.config.showMonths !== 3) {
        flatpickr.set('showMonths', 1);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
    
    if (width < 992 && width >= 768 && flatpickr.config.showMonths !== 2) {
        flatpickr.set('showMonths', 1);
        console.log(width);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
    if (width < 768 && flatpickr.config.showMonths !== 1) {
        console.log(width);
        flatpickr.set('showMonths', 1);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
    
}

function formatDate(date) {
    let d = date.getDate();
    let m = date.getMonth() + 1; //Month from 0 to 11
    let y = date.getFullYear();
    return '' + y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
}