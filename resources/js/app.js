import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

const button_delete = document.querySelectorAll('.button_delete');

button_delete.forEach((button) => {

    button.addEventListener('click', (event) => {

        event.preventDefault();

        const modal_delete = document.getElementById('modal_delete');

        const new_modal = new bootstrap.Modal(modal_delete);

        new_modal.show();

        const modal_save = document.getElementById('modal_save');

        modal_save.addEventListener('click', function(){

            button.parentElement.submit();
        });
    });
})