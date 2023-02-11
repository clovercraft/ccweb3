const axios = require('axios').default;
const { AlertTypes, AjaxAlert } = require('./alert')

const submitFormStep = (endpoint, data) => {
    const userid = document.getElementById('input-user').value
    data['user'] = userid

    axios
        .post(endpoint, data)
        .then((response) => {
            if (response.status !== 200) {
                formError(response)
                return
            }

            const data = response.data
            if (!data.success) {
                formError(data.message, true)
            }

            $("#ajaxFormTarget").html(data.html)
        })
        .catch((error) => {
            formError(error)
        })
}

const formError = (error, verbose = false) => {
    if (verbose) {
        AjaxAlert(AlertTypes.error, error)
    } else {
        AjaxAlert(AlertTypes.error, "Sorry, something went wrong.")
    }
    console.log(error)
}

module.exports = {
    'SubmitFormStep': submitFormStep
}
