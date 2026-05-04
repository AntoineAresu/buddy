import { Controller } from '@hotwired/stimulus';
// Use CDN waiting for this issue to be resolved : https://github.com/fullcalendar/fullcalendar/issues/7472
import {Calendar} from 'https://cdn.skypack.dev/@fullcalendar/core@6.1.15';
import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.15';
import timeGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.15';
import interaction from 'https://cdn.skypack.dev/@fullcalendar/interaction@6.1.15';

export default class extends Controller {
    static values = {nights: Array};
    connect() {
        let calendarEl = this.element;
        let calendar = new Calendar(calendarEl, {
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
        });
        calendar.render();
    }
}
