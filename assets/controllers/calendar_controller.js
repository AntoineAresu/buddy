import { Controller } from '@hotwired/stimulus';
// Use CDN waiting for this issue to be resolved : https://github.com/fullcalendar/fullcalendar/issues/7472
import {Calendar} from 'https://cdn.skypack.dev/@fullcalendar/core@6.1.15';
import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.15';
import timeGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.15';
import interaction from 'https://cdn.skypack.dev/@fullcalendar/interaction@6.1.15';

export default class extends Controller {
    static values = {nights: Array};
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
            events: this.formatNightsEvents(this.nightsValue),
        });
        calendar.render();
    }

    formatNightsEvents(nights) {
        return nights.map(night => ({
            start: night.end,
            title: `🌙 Nuit du ${this.getDayOfMonth(night.start)} au ${this.getDayOfMonth(night.end)} : ${night.duration}h`,
            allDay: true,
            backgroundColor: '#B8CDE0',
            borderColor: '#9BBFD4',
            textColor: '#1e272e',
        }));
    }

    getDayOfMonth(date) {
        return new Date(date).getDate();
    }
}
