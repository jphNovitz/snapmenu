import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['panel', 'alertCopy']

  toggle(e) {
    e.stopPropagation()
    this.panelTarget.classList.toggle('hidden')
  }

  close(e) {
    e.stopPropagation()
    this.panelTarget.classList.add('hidden')
  }

  copy(e) {
    navigator.clipboard.writeText(e.params.uri)
             .then(() => {
                  console.log('copié')
                  this.showCopy()
               })
             .catch(err => console.error(err))
  }

  showCopy(){
    this.alertCopyTarget.style.opacity = "1"
    this.alertCopyTarget.style.transform = "translateY(-12px)"

    setTimeout(() => {
      this.alertCopyTarget.style.opacity = "0"
      this.alertCopyTarget.style.transform = "translateY(0px)"
    }, 1500);
  }
}

