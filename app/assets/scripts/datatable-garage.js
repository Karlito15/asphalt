import jQuery from 'jquery';
import 'bootstrap-table';
import '../libraries/bootstrap-table/1.27/dist/bootstrap-table.min.css';

jQuery('#Garage').bootstrapTable({
    columns: [
        {
            field: 'loop',
            title: '#',
            searchable: false,
            sortable: false,
        },
        {
            field: 'update',
            title: 'update',
            searchable: true,
            sortable: false,
        },
        {
            field: 'class',
            title: 'Class',
            searchable: true,
            sortable: false,
        },
        {
            field: 'unblock',
            title: 'unblock',
            searchable: true,
            sortable: false,
        },
        {
            field: 'gold',
            title: 'gold',
            searchable: true,
            sortable: false,
        },
        {
            field: 'brand',
            title: 'Brand',
            searchable: true,
            sortable: false,
        },
        {
            field: 'model',
            title: 'model',
            searchable: false,
            sortable: false,
        },
        {
            field: 'action',
            title: 'action',
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
    pageList: [12, 24, 36, 48, 'all'],
    pageSize: 12,
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
    // buttonsToolbar: '.datatable-toolbar',
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
