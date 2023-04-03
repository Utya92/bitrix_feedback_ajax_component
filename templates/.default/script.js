document.addEventListener('DOMContentLoaded', () => {
    $('#btn-send-form').on('click', function (oEvent) {
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let message = document.getElementById('message').value;

        BX.ajax.runComponentAction('my_feedback', 'send',
            {
                mode: 'class',
                data: {
                    name: name,
                    email: email,
                    message: message
                }
            })
    });
});