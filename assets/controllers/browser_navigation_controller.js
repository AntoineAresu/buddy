import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
       static values = {url: String};

       back() {
              this.hasUrlValue ? window.location.href = this.urlValue : window.history.back();
       }
}
