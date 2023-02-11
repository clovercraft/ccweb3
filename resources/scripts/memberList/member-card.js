class MemberCard {

    constructor(uuid) {
        this.uuid = uuid
        this.bindControls()
    }

    bindControls() {
        $(document).on('click', '.member-controls a', (e) => this.onClickMemberControl(e))
    }

    onClickMemberControl(e) {
        e.preventDefault()
        // send API request, provide an alert for the response & update the card
    }
}
