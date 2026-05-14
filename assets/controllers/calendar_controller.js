import { Controller } from '@hotwired/stimulus';
// Use CDN waiting for this issue to be resolved : https://github.com/fullcalendar/fullcalendar/issues/7472
import {Calendar} from 'https://cdn.skypack.dev/@fullcalendar/core@6.1.15';
import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.15';
import timeGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.15';
import interaction from 'https://cdn.skypack.dev/@fullcalendar/interaction@6.1.15';
import CalendarHelper from "./helpers/calendar/CalendarHelper.js";
import UrlBuilder from "./helpers/UrlBuilder.js";

export default class extends Controller {
    static values = {
        nights: Array,
        crossings: Array,
        dayUrl: String,
    };
    connect() {
        let calendar = new Calendar(this.element, {
            plugins: [dayGridPlugin, timeGridPlugin, interaction],
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridDay,timeGridWeek,dayGridMonth'
            },
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour',
                list: 'Liste',
            },
            firstDay: 1,
            dayHeaderFormat: { weekday: 'long' },
            editable: true,
            disableDragging: true,
            events: [
                ...CalendarHelper.formatNightsEvents(this.nightsValue),
                ...CalendarHelper.formatCrossingsEvents(this.crossingsValue)
            ],
            eventClick: (info) => {
                window.location = UrlBuilder.buildRoute(this.dayUrlValue, {date: CalendarHelper.getDateToString(info.event.start)})
            },
            dateClick: (info) => {
                window.location = UrlBuilder.buildRoute(this.dayUrlValue, {date: info.dateStr})
            }
        });
        calendar.render();
    }
}
