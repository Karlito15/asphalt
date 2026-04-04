import jQuery from 'jquery';
import 'bootstrap-table';
import '../libraries/bootstrap-table/1.27/dist/bootstrap-table.min.css';

jQuery('#Race').bootstrapTable({
    columns: [
        {
            field: 'mode',
            title: 'Mode',
            searchable: false,
            sortable: false,
        },
        {
            field: 'season',
            title: 'Season',
            searchable: true,
            sortable: false,
        },
        {
            field: 'region',
            title: 'Region',
            searchable: true,
            sortable: false,
        },
        {
            field: 'english',
            title: 'English',
            searchable: true,
            sortable: false,
        },
        {
            field: 'french',
            title: 'French',
            searchable: true,
            sortable: false,
        },
        {
            field: 'chapter',
            title: 'Chapter',
            searchable: false,
            sortable: false,
        },
        {
            field: 'order',
            title: 'Order',
            searchable: false,
            sortable: false,
        },
        {
            field: 'time',
            title: 'Time',
            searchable: false,
            sortable: false,
        },
        {
            field: 'finished',
            title: 'Finished',
            searchable: false,
            sortable: false,
        }
    ],
    // Icon
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
    // Pagination
    pageList: [20, 40, 60, 80, 100, 'all'],
    pageSize: 10,
    pagination: true,
    paginationHAlign: 'end',
    paginationVAlign: 'bottom',
    paginationLoop: true,
    // Search
    search: true,
    searchAlign: 'start',
    searchAccentNeutralise: true,
    searchHighlight: true,
    searchTimeOut: 200,
    visibleSearch: false,
    // Configuration
    buttonsToolbar: '.datatable-toolbar',
    cache: false,
    silentSort: false,
    showButtonIcons: true,
    showButtonText: false,
    showColumns: false,
    showColumnsSearch: true,
    showColumnsToggleAll: false,
    showExtendedPagination: true,
    showFullscreen: false,
    showPaginationSwitch: false,
    showSearchButton: false,
    showSearchClearButton: true,
});
