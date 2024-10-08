import {Controller} from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['links']

    connect() {
        console.log('The nav conroller is OK !')
    }

    trigger(e) {
        e.stopPropagation()
        if (e.target.parentNode.id === 'trigger-on') {
            e.preventDefault()
        }
        this.linksTarget.classList.toggle('-mt-[200vh]')
    }
}
