import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['panel']

    toggle(e) {
        e.stopPropagation()
        this.panelTarget.classList.toggle('hidden')
    }

    close(e) {
        e.stopPropagation()
        this.panelTarget.classList.add('hidden')
    }
}
