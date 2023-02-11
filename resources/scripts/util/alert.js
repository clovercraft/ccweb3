const alertTypes = {
    'success': 'alert-success',
    'error': 'alert-danger',
    'info': 'alert-info',
}

const alert = (message, type) => {

    const placeholder = document.getElementById('alertPlaceholder')

    // set the type
    if (!(type in alertTypes)) {
        type = 'info'
    }
    type = alertTypes[type]

    const wrapper = document.createElement('div')
    wrapper.innerHTML = [
        `<div class="alert ${type} alert-dismissable" role="alert"`,
        `    <div>${message}</div>`,
        `    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`,
        `</div>`
    ].join('')

    placeholder.append(wrapper)
}

module.exports = {
    'AlertTypes': alertTypes,
    'AjaxAlert': alert
}
