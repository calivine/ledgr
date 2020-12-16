class Ruler {
    constructor() {
        this.ruler = document.querySelector('.ruler');
        this.markTemplate = document.querySelector('#mark-template').innerHTML;
        this.sectionCount = 90;
        this.heightVal = document.querySelector('#height');
        this.onStart = this.onStart.bind(this);
        this.onEnd = this.onEnd.bind(this);
        this.onMove = this.onMove.bind(this);
        this.update = this.update.bind(this);

        this.targetBCR = null;
        this.target = null;

        this.touchStartX = null;
        this.touchCurrentX = null;
        this.touchEndX = null;

        this.startX = 0;
        this.currentX = 0;
        this.endX = null;

        this.startT = null;
        this.endT = null;

        this.speedX = null;
        this.deacceleration = 5;
        this.speedMultiplier = 100;

        this.screenX = 0;
        this.targetX = 0;
        this.slidingRuler = false;
        this.markWidth = window.innerWidth * 0.1; //10vh from CSS
        this.ruler.style.width = this.markWidth * this.sectionCount + 'px';
        this.screenXMax = window.innerWidth - this.ruler.clientWidth;
        this.screenXMin = 0;

        this._createRuler.apply(this);

        this.addEventListeners();
        requestAnimationFrame(this.update);

    }

    /*
  Add markers from template
  sectionCount number of times
  */
    _createRuler() {
        for (let i = 0; i < this.sectionCount; i++) {

            let tmp = document.createElement('div');
            let template = this.markTemplate;
            tmp.innerHTML = template;
            template = tmp.children[0];

            if (i >= 5 && i <= this.sectionCount - 5) {
                if ((i-5) % 4 === 0) {
                    template.querySelector('.line').style.height = '6vw';
                    template.querySelector('.measure').innerHTML = (i-5) / 4;
                }
                if ((i-5) % 2 === 0 && (i-5) % 4 !== 0) {
                    template.querySelector('.line').style.height = '3vw';
                }
            } else {
                template.querySelector('.line').style.height = '0';
            }

            this.ruler.appendChild(template);
        }

    }

    addEventListeners() {
        document.addEventListener('touchstart', this.onStart);
        document.addEventListener('touchmove', this.onMove);
        document.addEventListener('touchend', this.onEnd);

        document.addEventListener('mousedown', this.onStart);
        document.addEventListener('mousemove', this.onMove);
        document.addEventListener('mouseup', this.onEnd);
    }

        onStart(evt) {
            if (this.target)
                return;

            if (!evt.target.parentNode.classList.contains('ruler'))
                return;

            let date = new Date();
            this.startT = date.getTime();

            this.target = evt.target.parentNode;
            this.targetBCR = this.target.getBoundingClientRect();

            this.startX = parseFloat(this.target.style.transform.replace(/[^-\d\.]/g, '')) || 0;
            this.currentX = this.startX;

            this.touchStartX = evt.pageX || evt.touches[0].pageX;
            this.touchCurrentX = this.touchStartX;

            this.slidingRuler = true;
            this.target.style.willChange = 'transform';

            evt.preventDefault();
        }

        onMove(evt) {
            if (!this.target)
                return;
            this.touchCurrentX = evt.pageX || evt.touches[0].pageX;
        }

        onEnd(evt) {
            if (!this.target)
                return;

            let date = new Date();
            this.endT = date.getTime();

            this.speedX = this.speedMultiplier * Math.abs((this.touchCurrentX - this.touchStartX) / (this.endT - this.startT));

            this.slidingRuler = false;
        }

      /*
      Round to the nearest marker
      */
        _roundScreenX(disp) {
            return Math.round(disp / this.markWidth) * this.markWidth;
        }

      /*
      Set target transform style
      */
        _setTargetTransform() {
            if (this.screenX > this.screenXMin) {
                this.screenX = this.screenXMin;
            } else if (this.screenX < this.screenXMax) {
                this.screenX = this._roundScreenX(this.screenXMax);
            }

            this.target.style.transform = `translateX(${this.screenX}px)`;

            return;
        }

        update() {

            requestAnimationFrame(this.update);

            if (!this.target)
                return;

            let disp = this.touchCurrentX - this.touchStartX;
            let direction = disp / Math.abs(disp);

            if (this.slidingRuler) {

                this.screenX = this.startX + disp;

                this._setTargetTransform.apply(this);

                return;

            } else if (this.speedX > 0) {

                let date = new Date();
                let elapsed = (date.getTime() - this.endT) / 1000;

                let delta = (this.speedX * elapsed - this.deacceleration * elapsed * elapsed);

                delta = delta > 0 ? delta : 0;

                this.screenX = this.screenX + direction * delta;

                this._setTargetTransform.apply(this);
                this.speedX = this.speedX - this.deacceleration * elapsed;

                return;

            } else {
                this.screenX = this._roundScreenX(this.screenX);
                this._setTargetTransform.apply(this);
                this.heightVal.style.opacity = 1;
                this.heightVal.innerHTML = Math.round(-100*(this.screenX/this.markWidth)/4)/100 + ' in' ;
                this.target = null;
            }
        }

}
window.addEventListener('load', () => new Ruler());
