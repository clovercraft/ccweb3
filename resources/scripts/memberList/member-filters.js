class MemberList {

    constructor() {

        this.el = {
            'list': '.member-list',
            'search': '#member-search',
            'filterStatus': '#member-filter-status .dropdown-menu a',
            'filterRole': '#member-filter-role .dropdown-menu a',
            'clear': '#member-filter-clear'
        }

        this.cards = $(this.el.list).find('.member-card')
        this.members = this.loadMembers()
        this.filters = {
            'text': '',
            'status': [],
            'role': []
        }

        this.bindControls()
    }

    loadMembers() {
        let members = {}
        for (const card of this.cards) {
            let member = {
                'uuid': $(card).data('uuid'),
                'id': $(card).data('id'),
                'name': $(card).data('name'),
                'role': $(card).data('role'),
                'status': $(card).data('status')
            }
            members[$(card).data('uuid')] = member
        }
        return members
    }

    bindControls() {
        $(document).on('input', this.el.search, (e) => this.onSearchChange(e))
        $(document).on('click', this.el.filterStatus, (e) => this.onFilterStatusClick(e))
        $(document).on('click', this.el.filterRole, (e) => this.onFilterRoleClick(e))
        $(document).on('click', this.el.clear, (e) => this.clearFilters(e))
    }

    onSearchChange(e) {
        let searchTerm = $(this.el.search).val()

        // ignore strings that are less than 2 characters
        if (searchTerm.length <= 2) {
            searchTerm = ''
        }

        this.filters.search = searchTerm
        this.applyFilters()
    }

    onFilterStatusClick(e) {
        e.preventDefault()
        let $clicked = $(e.target)
        const filterValue = $clicked.data('value')

        $clicked.toggleClass('selected')

        const index = this.filters.status.indexOf(filterValue)
        if (index > -1) {
            this.filters.status.splice(index, 1)
        } else {
            this.filters.status.push(filterValue)
        }
        this.applyFilters()
    }

    onFilterRoleClick(e) {
        e.preventDefault()
        let $clicked = $(e.target)
        const filterValue = $clicked.data('value')

        $clicked.toggleClass('selected')

        const index = this.filters.role.indexOf(filterValue)
        if (index > -1) {
            this.filters.role.splice(index, 1)
        } else {
            this.filters.role.push(filterValue)
        }
        this.applyFilters()
    }

    applyFilters() {
        // check if we should show all
        if (this.filters.role.length == 0 && this.filters.status.length == 0 && this.filters.search.length == 0) {
            this.cards.removeClass('hidden')
            return
        }

        for (const uuid in this.members) {
            const member = this.members[uuid]

            // check role
            const roleMatched = this.filters.role.length > 0 && (this.filters.role.indexOf(member.role) > -1)

            // check status
            const statusMatched = this.filters.status.length > 0 && (this.filters.status.indexOf(member.status) > -1)

            // check text
            const textMatched = this.filters.search.length > 0 && this.checkTextMatch(member)

            let filterMatches = (roleMatched || statusMatched || textMatched)

            const $card = $(`#member-card-${member.uuid}`)
            if (filterMatches) {
                $card.removeClass('hidden')
            } else {
                $card.addClass('hidden')
            }
        }

        this.updateClearButton()
    }

    checkTextMatch(member) {
        const filterText = this.filters.search.toLowerCase()
        const filterName = member.name.toLowerCase()

        const pattern = new RegExp(filterText, 'gi')
        const matches = filterName.match(pattern)
        return (matches !== null && matches.length > 0)
    }

    updateClearButton() {
        if ($(this.el.clear).hasClass('disabled') == false) {
            $(this.el.clear).addClass('disabled')
        }
        const enabled = (this.filters.role.length > 0 || this.filters.status.length > 0 || this.filters.search.length > 0)
        if (enabled) {
            $(this.el.clear).removeClass('disabled')
        }
    }

    clearFilters(e) {
        e.preventDefault()
        if ($(this.el.clear).hasClass('disabled')) {
            return
        }

        $(this.el.filterRole).removeClass('selected')
        this.filters.role = []

        $(this.el.filterStatus).removeClass('selected')
        this.filters.status = []

        $(this.el.search).val('')
        this.filters.text = ''

        this.applyFilters()
    }
}

$(function () {
    if ($('#member-list').length) {
        let MemberFilters = new MemberList()
    }
})
