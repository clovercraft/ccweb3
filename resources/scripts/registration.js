const { SubmitFormStep } = require('./util/ajaxForm')

$(function () {
    $(document).on('click', '#submit-minecraft', function (e) {
        SubmitFormStep(
            '/api/registration/minecraft',
            { 'username': $('#input-username').val() }
        )
    })

    $(document).on('click', '#submit-verification', function (e) {
        SubmitFormStep(
            '/api/registration/verification',
            {
                'birthdate': $("#input-birthdate").val(),
                'pronouns': $("#input-pronouns").val()
            }
        )
    })
})
