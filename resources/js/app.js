import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('alpine:init', () => {
    Alpine.data('otp', (length = 6) => ({
        digits: Array(length).fill(''),

        get isComplete() {
            return this.digits.every(d => d !== '');
        },

        moveNext(index) {
            if (this.digits[index].length === 1 && index < this.digits.length - 1) {
                this.$el.querySelectorAll('input')[index + 1].focus();
            }
        },

        movePrev(index) {
            if (this.digits[index] === '' && index > 0) {
                this.$el.querySelectorAll('input')[index - 1].focus();
            }
        },

        combineCode() {
            this.$refs.finalCode.value = this.digits.join('');
        }
    }))
})


