import jQuery from 'jquery';
import 'bootstrap-table';

let GarageColumns = [{
    field: 'game',
    searchable: false,
    sortable: true,
    title: 'N°'
}, {
    field: 'class',
    searchable: false,
    sortable: true,
    title: 'Class'
}, {
    field: 'lock',
    searchable: true,
    sortable: true,
    title: 'Débloquer'
}, {
    field: 'gold',
    searchable: true,
    sortable: true,
    title: 'Or'
}, {
    field: 'brand',
    searchable: true,
    sortable: true,
    title: 'Marque'
}, {
    field: 'model',
    searchable: true,
    sortable: true,
    title: 'Modèle'
}, {
    field: 'actions',
    searchable: false,
    sortable: false,
    title: 'Boutons'
}];

jQuery('#table').bootstrapTable({
    columns: GarageColumns,
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
