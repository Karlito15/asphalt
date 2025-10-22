import jQuery from 'jquery';
import 'bootstrap-table';

let RaceColumns = [{
    field: 'mode',
    searchable: true,
    sortable: false,
    title: 'Mode'
}, {
    field: 'chapter',
    searchable: false,
    sortable: true,
    title: 'Chapitre'
}, {
    field: 'order',
    searchable: false,
    sortable: true,
    title: 'Ordre'
}, {
    field: 'season',
    searchable: true,
    sortable: true,
    title: 'Saison'
}, {
    field: 'english',
    searchable: true,
    sortable: true,
    title: 'Anglais'
}, {
    field: 'french',
    searchable: true,
    sortable: true,
    title: 'Français'
}, {
    field: 'time',
    searchable: true,
    sortable: true,
    title: 'Temps'
}, {
    field: 'finished',
    searchable: false,
    sortable: false,
    title: 'Fini'
}];

jQuery('#table').bootstrapTable({
    columns: RaceColumns,
    buttonsAlign: 'end',
    // buttonsClass: '',
    buttonsToolbar: '.table-toolbar',

    cache: false,

    icons: {
        paginationSwitchDown: 'fa-caret-square-down',
        paginationSwitchUp: 'fa-caret-square-up',
        refresh: 'fa-sync',
        toggleOff: 'fa-toggle-off',
        toggleOn: 'fa-toggle-on',
        columns: 'fa-th-list',
        fullscreen: 'fa-arrows-alt',
        detailOpen: 'fa-plus',
        detailClose: 'fa-minus'
    },
    iconSize: 'sm',
    iconsPrefix: 'fa',

    pageList: [20, 40, 60, 80, 100, 'all'],
    pageSize: 100,
    pagination: true,
    paginationHAlign: 'end',
    paginationVAlign: 'bottom',
    paginationLoop: true,

    search: true,
    searchAlign: 'start',
    searchAccentNeutralise: true,
    searchHighlight: true,
    searchTimeOut: 200,
    visibleSearch: false,

    silentSort: false,

    showButtonIcons: true,
    showButtonText: false,
    showColumns: true,
    showColumnsSearch: true,
    showColumnsToggleAll: true,
    showExtendedPagination: true,
    showFullscreen: false,
    showPaginationSwitch: true,
    showSearchButton: false,
    showSearchClearButton: true,

    // Extensions
    // stickyHeader: true,
    // stickyHeaderOffsetLeft: 0,
    // stickyHeaderOffsetRight: 0,
    // stickyHeaderOffsetY: 0,
});
