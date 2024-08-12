import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['container', 'chevron']

    connect() {
        console.log('The list toggle is OK !')
    }

    click(e) {
        e.stopPropagation()
        e.preventDefault()
        this.chevronTarget.classList.toggle('rotate-90')
        this.containerTarget.classList.toggle('h-0')
        this.containerTarget.classList.toggle('h-auto')
    }
}
