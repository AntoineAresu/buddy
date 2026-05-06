import { Controller } from '@hotwired/stimulus';
import flatpickr from 'flatpickr';
import { French } from 'flatpickr/dist/l10n/fr.js';

import 'flatpickr/dist/flatpickr.min.css';

export default class extends Controller {
    static values = {
        enableTime: Boolean,
        defaultDate: String,
    }
    connect() {
        flatpickr(this.element, {
            enableTime: this.enableTimeValue,
            noCalendar: true,
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "H:i",
            locale: French,
            defaultDate: this.defaultDateValue,
        });
    }
}
