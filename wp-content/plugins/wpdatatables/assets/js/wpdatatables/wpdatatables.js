/** New JS controller for wpDataTables **/

var wpDataTables = {};
var wpDataTableDialogs = {};
var wpDataTablesSelRows = {};
var wpDataTablesFunctions = {};
var wpDataTablesUpdatingFlags = {};
var wpDataTablesResponsiveHelpers = {};
var wdtBreakpointDefinition = {
    tablet: 1024,
    phone: 480
};
var wdtCustomUploader = null;

(function ($) {
    $(function () {

        $('table.wpDataTable').each(function () {
            var tableDescription = $.parseJSON($('#' + $(this).data('described-by')).val());

            // Parse the DataTable init options
            var dataTableOptions = tableDescription.dataTableParams;

            
            
            // Apply the selecter to show entries
            dataTableOptions.fnInitComplete = function( oSettings, json ) {
                jQuery('#' + tableDescription.tableId + '_length select').selecter();
            }
            // Init the DataTable itself
            wpDataTables[tableDescription.tableId] = $(tableDescription.selector).dataTable(dataTableOptions);

            

            // Add the draw callback
            wpDataTables[tableDescription.tableId].addOnDrawCallback = function (callback) {
                if (typeof callback !== 'function') {
                    return;
                }

                var index = wpDataTables[tableDescription.tableId].fnSettings().aoDrawCallback.length + 1;

                wpDataTables[tableDescription.tableId].fnSettings().aoDrawCallback.push({
                    sName: 'user_callback_' + index,
                    fn: callback
                });

            }

            

            // Init row grouping if enabled
            if ((tableDescription.columnsFixed == 0) && (tableDescription.groupingEnabled)) {
                wpDataTables[tableDescription.tableId].rowGrouping({iGroupingColumnIndex: tableDescription.groupingColumnIndex});
            }

            

            $(window).load(function () {
                // Show table if it was hidden
                if (tableDescription.hideBeforeLoad) {
                    $(tableDescription.selector).show(300);
                }
            });

        });

        

    })

    

})(jQuery);



function wdtDialog(str, title) {
    var dialogId = Math.floor((Math.random() * 1000) + 1);
    var dialog_str = '<div class="remodal wpDataTables wdtRemodal" id="remodal-' + dialogId + '"><h3>' + title + '</h3>';
    dialog_str += str;
    dialog_str += '</div>';
    jQuery(dialog_str).remodal({
        type: 'inline',
        preloader: false
    });
    return jQuery('#remodal-' + dialogId);
}

function wdtAddOverlay(table_selector) {
    jQuery(table_selector).addClass('overlayed');
}

function wdtRemoveOverlay(table_selector) {
    jQuery(table_selector).removeClass('overlayed');
}

jQuery.fn.dataTableExt.oStdClasses.sWrapper = "wpDataTables wpDataTablesWrapper";
