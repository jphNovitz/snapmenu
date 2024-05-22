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

    trigger(e){
        console.log("oui")
        e.stopPropagation()
        e.preventDefault()
        this.linksTarget.classList.toggle('-ml-96')
        this.linksTarget.addEventListener('click', (e)=>{
            this.linksTarget.classList.toggle('-ml-96')
        })
    }
}
