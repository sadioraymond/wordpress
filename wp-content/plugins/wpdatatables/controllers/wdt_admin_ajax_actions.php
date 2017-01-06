<?php
/**
 * @package wpDataTables
 * @version 1.6.0
 */
/**
 * Controller for admin panel AJAX actions
 */
?>
<?php

	/**
	 * Handler which returns the AJAX preview
	 */
	 function wdt_get_ajax_preview(){
	 	$no_scripts = !empty($_POST['no_scripts']) ? 1 : 0;
                
		$js_ext = get_option('wdtMinifiedJs') ? '.min.js' : '.js';
                
	 	if(!$no_scripts){
				$scripts = array(
					WDT_JS_PATH.'jquery-datatables/jquery.dataTables.min.js',
					WDT_JS_PATH.'export-tools/dataTables.buttons.js',
					WDT_JS_PATH.'export-tools/buttons.html5.min.js',
					WDT_JS_PATH.'export-tools/buttons.print.min.js',
					WDT_JS_PATH.'export-tools/pdfmake.min.js',
					WDT_JS_PATH.'export-tools/jszip.min.js',
					WDT_JS_PATH.'export-tools/buttons.colVis.js',
					WDT_JS_PATH.'export-tools/vfs_fonts.js',
					WDT_JS_PATH.'php-datatables/wpdatatables.funcs'.$js_ext,
					WDT_JS_PATH.'jquery-datatables/jquery.dataTables.rowGrouping.min.js',
					
					WDT_JS_PATH.'wpdatatables/wpdatatables'.$js_ext
				);
	 	}else{
				$scripts = array(WDT_JS_PATH.'wpdatatables/wpdatatables'.$js_ext);
	 	}
		echo wdt_output_table((int)$_POST['table_id'], $no_scripts);
		foreach($scripts as $script){
			echo '<script type="text/javascript" src="'.$script.'"></script>';
	 	}
		exit();
	 }	 
	add_action( 'wp_ajax_wdt_get_preview', 'wdt_get_ajax_preview' );


	
	/**
	 * Function which saves the global settings for the plugin
	 */
	function wdt_save_settings(){

		if( !current_user_can('manage_options') || !wp_verify_nonce( $_POST['wdtSettingsNonce'], 'wdt_settings_nonce_'.get_current_user_id() ) ){ exit(); }
		$_POST = apply_filters( 'wpdatatables_before_save_settings', $_POST );
		
		// Get and write main settings
		$wdtSiteLink = $_POST['wdtSiteLink'];

		$wpRenderFilter = sanitize_text_field($_POST['wpRenderFilter']);
		$wpInterfaceLanguage = sanitize_text_field($_POST['wpInterfaceLanguage']);
		$wpDateFormat = sanitize_text_field($_POST['wpDateFormat']);
		$wpTimeFormat = sanitize_text_field($_POST['wdtTimeFormat']);
		$wpTopOffset = (int)$_POST['wpTopOffset'];
		$wpLeftOffset = (int)$_POST['wpLeftOffset'];
		$wdtBaseSkin = sanitize_text_field($_POST['wdtBaseSkin']);
		$wdtTablesPerPage = (int)$_POST['wdtTablesPerPage'];
		$wdtNumberFormat = (int)$_POST['wdtNumberFormat'];
		$wdtDecimalPlaces = (int)$_POST['wdtDecimalPlaces'];
		$wdtTimepickerRange = (int)( $_POST['wdtTimepickerRange'] ) ? $_POST['wdtTimepickerRange'] : 5;
		$wdtNumbersAlign = (int)$_POST['wdtNumbersAlign'];
		$wdtCustomJs = esc_js($_POST['wdtCustomJs']);
		$wdtCustomCss = sanitize_text_field($_POST['wdtCustomCss']);
		$wdtMinifiedJs = (int)($_POST['wdtMinifiedJs']);
		$wdtMobileWidth = (int)$_POST['wdtMobileWidth'];
		$wdtTabletWidth = (int)$_POST['wdtTabletWidth'];

		update_option('wdtSiteLink', $wdtSiteLink);
		
		update_option('wdtRenderCharts', 'below'); // Deprecated, delete after 1.6
		update_option('wdtRenderFilter', $wpRenderFilter);
		update_option('wdtInterfaceLanguage', $wpInterfaceLanguage);
		update_option('wdtDateFormat', $wpDateFormat);
		update_option('wdtTimeFormat', $wpTimeFormat );
		update_option('wdtTopOffset', $wpTopOffset);
		update_option('wdtLeftOffset', $wpLeftOffset);
		update_option('wdtBaseSkin', $wdtBaseSkin);
		update_option('wdtTablesPerPage', $wdtTablesPerPage);
		update_option('wdtNumberFormat', $wdtNumberFormat);
		update_option('wdtDecimalPlaces', $wdtDecimalPlaces);
		update_option('wdtTimepickerRange', $wdtTimepickerRange);
		update_option('wdtNumbersAlign', $wdtNumbersAlign);
		update_option('wdtCustomJs', $wdtCustomJs);
		update_option('wdtCustomCss', $wdtCustomCss);
		update_option('wdtMinifiedJs', $wdtMinifiedJs);
		update_option('wdtMobileWidth', $wdtMobileWidth);
		update_option('wdtTabletWidth', $wdtTabletWidth);
		
		
		// Get font and color settings
		$wdtFontColorSettings = array();
		
		
		// Serialize settings and save to DB
		update_option('wdtFontColorSettings',serialize($wdtFontColorSettings));
		
		do_action( 'wpdatatables_after_save_settings' );
		die( 'success' );
	}
	add_action( 'wp_ajax_wdt_save_settings', 'wdt_save_settings');
	
	/**
	 * Saves the general settings for the table, tries to generate the table 
	 * and default settings for the columns
	 */
	function wdt_save_table(){
		global $wpdb;

		if( !current_user_can('manage_options') || !wp_verify_nonce( $_POST['wdtSaveTableNonce'], 'wdt_save_table_nonce_'.get_current_user_id() ) ){ exit(); }

		$_POST = apply_filters( 'wpdatatables_before_save_table', $_POST );
		$table_id = (int)$_POST['table_id'];
		$show_title = (int)$_POST['show_title'];
		$table_title = sanitize_text_field($_POST['table_title']);
		$table_type = sanitize_text_field($_POST['table_type']);

		if ( $table_type == 'mysql' || $table_type == 'google_spreadsheet' ) {
		    echo  __('Sorry, this function is available only in FULL version of wpDataTables along with many others! Please go to our <a href="http://wpdatatables.com/?utm_source=wdtlite">website</a> to see the full list and to purchase!') ;
		    die();
		}

		if(($table_type == 'csv') || ($table_type == 'xls')){
			$uploads_dir = wp_upload_dir();
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$table_content = str_replace($uploads_dir['baseurl'], str_replace('\\', '/', $uploads_dir['basedir']), esc_url($_POST['table_content']));
			}else{
				$table_content = str_replace($uploads_dir['baseurl'], $uploads_dir['basedir'], esc_url($_POST['table_content']));
			}
		}else{
				$table_content = esc_url($_POST['table_content']);
		}
		$table_hide_before_loaded = ($_POST['hide_before_loaded'] == 'true');
		$table_tools = ($_POST['table_tools'] == 'true');
		if( $table_tools ){
			$table_tools_config = serialize( $_POST['table_tools_config'] );
		}else{
			$table_tools_config = serialize( array() );
		}
		$table_sorting = ($_POST['table_sorting'] == 'true');
		$table_fixed_layout = ($_POST['fixed_layout'] == 'true');
		$table_word_wrap = ($_POST['word_wrap'] == 'true');
		$table_display_length = sanitize_text_field($_POST['table_display_length']);
		$table_fixheader = ($_POST['table_fixheader'] == 'true');
		$table_fixcolumns = sanitize_text_field($_POST['table_fixcolumns']);
		
		
		if(!$table_fixheader){
			$table_fixcolumns = -1;
		}else{
			$table_fixcolumns = $table_fixcolumns;
		}
		if(!$table_id){
			// adding new table
			// trying to generate a WPDataTable
			$res = wdt_try_generate_table( $table_type, $table_content );
			if( !empty( $res['error'] ) ){
					// if WPDataTables returns an error, replying to the page
					echo json_encode( $res ); die();
			}else{
				// if no problem reported, first saving the table parameters to DB
				$table_array = array(
										'title' => $table_title,
										'show_title' => $show_title,
										'table_type' => $table_type,
										'content' => $table_content,
										'sorting' => $table_sorting,
										'fixed_layout' => $table_fixed_layout,
										'word_wrap' => $table_word_wrap,
										'tools' => $table_tools,
										'display_length' => $table_display_length,
										'fixed_columns' => $table_fixcolumns,
										'chart' => 'none', // deprecated, delete after 1.6
										'chart_title' => '', // deprecated, delete after 1.6
										'hide_before_load' => $table_hide_before_loaded,
					                    'tabletools_config' => $table_tools_config,
					                    
								);

				$table_array = apply_filters('wpdatatables_filter_insert_table_array', $table_array);
				
				$wpdb->insert($wpdb->prefix .'wpdatatables', $table_array);
				// get the newly generated table ID
				$table_id = $wpdb->insert_id;
				$res['table_id'] = $table_id;
				// creating default columns for the new table
				$res['columns'] = wdt_create_columns_from_table( $res['table'], $table_id );
				do_action( 'wpdatatables_after_save_table', $table_id );
				echo json_encode($res); die();
			}
		}else{
                        // Trying to rebuild the table and reloading the columnset
                        $res = wdt_try_generate_table( $table_type, $table_content );
                        if(!empty($res['error'])){
                                // if WPDataTables returns an error, replying to the page
                                do_action( 'wpdatatables_after_save_table' );
                                echo json_encode( $res ); die();
                        }else{
                                // otherwise updating the table
                                $table_array = array(
                                                    'title' => $table_title,
                                                    'show_title' => $show_title,
                                                    'table_type' => $table_type,
                                                    'content' => $table_content,
                                                    'sorting' => $table_sorting,
                                                    'fixed_layout' => $table_fixed_layout,
                                                    'word_wrap' => $table_word_wrap,
                                                    'tools' => $table_tools,
                                                    'display_length' => $table_display_length,
                                                    'fixed_columns' => $table_fixcolumns,
                                                    'chart' => 'none',  // deprecated, delete after 1.6
                                                    'chart_title' => '',  // deprecated, delete after 1.6
									                'hide_before_load' => $table_hide_before_loaded,
									                'tabletools_config' => $table_tools_config,
									                
                                                );

                                $table_array = apply_filters( 'wpdatatables_filter_update_table_array', $table_array, $table_id );

                                $wpdb->update(
												$wpdb->prefix.'wpdatatables',
												$table_array,
												array(
														'id' => $table_id
														)
												);
                                $res['table_id'] = $table_id;
                                // rebuilding the columnset
                                $res['columns'] = wdt_create_columns_from_table( $res['table'], $table_id );
                                do_action( 'wpdatatables_after_save_table' );
                                echo json_encode($res); die();				 	
                        }
		}
		
	}
	add_action( 'wp_ajax_wdt_save_table', 'wdt_save_table');
	
	/**
	 * Saves the settings for columns
	 */
	function wdt_save_columns(){
		global $wpdb;

		if( !current_user_can('manage_options') || !wp_verify_nonce( $_POST['wdtColumnsNonce'], 'wdt_columns_nonce_'.get_current_user_id() ) ){ exit(); }

		$_POST = apply_filters( 'wpdatatables_before_save_columns', $_POST );
		
		$table_id = (int)( $_POST['table_id'] );
		$columns = json_decode( stripslashes_deep( $_POST['columns'] ), true );

		foreach($columns as $column){
			if( $column['orig_header'] == 'wdt_ID' ){
				$column['id_column'] = 'true';
			}
			if( !empty( $column['id'] ) ){
				// Updating existing columns
				$wpdb->update(
					$wpdb->prefix.'wpdatatables_columns',
					array(
						'display_header' => sanitize_text_field($column['display_header']),
						'css_class' => sanitize_text_field($column['css_class']),
						'column_type' => sanitize_text_field($column['column_type']),
						'id_column' => (int)($column['id_column'] == 'true'),
						'group_column' => (int)($column['group_column'] == 'true'),
						'sort_column' => (int)($column['sort_column']),
						'use_in_chart' => 0,  // deprecated, delete after 1.6
						'chart_horiz_axis' => 0,  // deprecated, delete after 1.6
						'visible' => (int)($column['visible'] == 'true'),
						'width' => sanitize_text_field($column['width']),
						'text_before' => sanitize_text_field($column['text_before']),
						'text_after' => sanitize_text_field($column['text_after']),
						'formatting_rules' => sanitize_text_field($column['formatting_rules']),
						'color' => isset( $column['color'] ) ? sanitize_text_field($column['color']) : '',
						'pos' => sanitize_text_field($column['pos']),
					),
					array(
						'id' => $column['id']
					)
				);
			}
			
		}
		$res['columns'] = wdt_get_columns_by_table_id( $table_id );
		
		do_action( 'wpdatatables_after_save_columns' );
		
		echo json_encode($res); exit();
	}
	add_action( 'wp_ajax_wdt_save_columns', 'wdt_save_columns');
	
	/**
	 * Duplicate the table
	 */
	 function wpdatatables_duplicate_table(){
	 	global $wpdb;

		 if( !current_user_can('manage_options') || !wp_verify_nonce( $_POST['wdtDuplicateNonce'], 'wdt_duplicate_nonce_'.get_current_user_id() ) ){ exit(); }

	 	$table_id = (int)$_POST['table_id'];
		if( empty( $table_id ) ){ return false; }
		$manual_duplicate_input =  (int)$_POST['manual_duplicate_input'];
		$new_table_name = sanitize_text_field( $_POST['new_table_name'] );

	 	// Getting the table data
	 	$table_data = wdt_get_table_by_id( $table_id );
		$mysql_table_name = $table_data['mysql_table_name'];
		$content =  $table_data['content'];
        if(get_option('wdtUseSeparateCon')) {
			$sql = new PDTSql(WDT_MYSQL_HOST, WDT_MYSQL_DB, WDT_MYSQL_USER, WDT_MYSQL_PASSWORD, WDT_MYSQL_PORT);
		}

		// Create duplicate version of input table if checkbox is selected
		if ($manual_duplicate_input) {

			// Generating new input table name
			$cnt = 1;
			$new_name_generated = false;
			while( !$new_name_generated ){
				$new_name = sanitize_text_field( $table_data['mysql_table_name'].'_'.$cnt );
				$check_table_query = "SHOW TABLES LIKE '{$new_name}'";
				if(!get_option('wdtUseSeparateCon')) {
					$res = $wpdb->get_results($check_table_query);
				}else{
					$res = $sql->getRow($check_table_query);
				}
				if( !empty( $res ) ){
					$cnt++;
				}else{
					$new_name_generated = true;
				}
			}

			// Input table queries
			$query1 = "CREATE TABLE {$new_name} LIKE {$table_data['mysql_table_name']};";
			$query2 = "INSERT INTO {$new_name} SELECT * FROM {$table_data['mysql_table_name']};";

			if(!get_option('wdtUseSeparateCon')) {
				$wpdb->query($query1);
				$wpdb->query($query2);
			}else{
				$sql->doQuery($query1);
				$sql->doQuery($query2);
			}
			$mysql_table_name = $new_name;
			$content = str_replace($table_data['mysql_table_name'], $new_name, $table_data['content']);
		}

	 	// Creating new table
	 	$wpdb->insert(
	 		$wpdb->prefix.'wpdatatables',
	 		array(
	 			'title' => $new_table_name,
				'show_title' => $table_data['show_title'],
	 			'table_type' => $table_data['table_type'],
	 			'content' => $content,
	 			'sorting' => $table_data['sorting'],
	 			'tools' => $table_data['tools'],
	 			'display_length' => $table_data['display_length'],
	 			'fixed_columns' => $table_data['fixed_columns'],
	 			'chart' => 'none',
	 			'chart_title' => '',
	 			'fixed_layout' => $table_data['fixed_layout'],
	 			'word_wrap' => $table_data['word_wrap'],
				'hide_before_load' => $table_data['hide_before_load'],
				'tabletools_config' => $table_data['tabletools_config'],
				
	 		)
	 	);
	 	
	 	$new_table_id = $wpdb->insert_id;
	 	
	 	// Getting the column data
	 	$columns = wdt_get_columns_by_table_id( $table_id );
	 	
	 	// Creating new columns
	 	foreach($columns as $column){
	 		$wpdb->insert(
	 			$wpdb->prefix.'wpdatatables_columns',
	 			array(
	 				'table_id' => $new_table_id,
	 				'orig_header' => $column->orig_header,
					'css_class' => $column->css_class,
	 				'display_header' => $column->display_header,
	 				'column_type' => $column->column_type,
	 				'group_column' => $column->group_column,
	 				'use_in_chart' => $column->use_in_chart,
	 				'chart_horiz_axis' => $column->chart_horiz_axis,
	 				'visible' => $column->visible,
	 				'width' => $column->width,
					'text_before' => $column->text_before,
					'text_after' => $column->text_after,
					'formatting_rules' => $column->formatting_rules,
					'color' => $column->color,
	 				'pos' => $column->pos,
	 				'id_column' => $column->id_column,
	 				'sort_column' => $column->sort_column,
					'css_class' => $column->css_class,
					'text_before' => $column->text_before,
					'text_after' => $column->text_after,
					'formatting_rules' => $column->formatting_rules,
					'color' => $column->color,
					
	 			)
	 		);
	 	}
	 	
	 	exit();
	 	
	 }
	add_action( 'wp_ajax_wpdatatables_duplicate_table', 'wpdatatables_duplicate_table');


         
         /**
          * Return all columns for a provided table
          */
         function wpdatatables_get_columns_data_by_table_id(){
			 if( !current_user_can('manage_options') ) { exit(); }

             $table_id = (int)$_POST['table_id'];
             echo json_encode( wdt_get_columns_by_table_id( $table_id ) );
             exit();
         }
         add_action( 'wp_ajax_wpdatatables_get_columns_data_by_table_id', 'wpdatatables_get_columns_data_by_table_id' );
         
         /**
          * Returns the complete table for the range picker
          */
         function wpdatatables_get_complete_table_json_by_id(){
			 if( !current_user_can('manage_options') ) { exit(); }

            $table_id = (int)$_POST['table_id'];
			$tbl = wdt_get_wpdatatable( $table_id, true );
            echo json_encode( $tbl->getDataRows() );
            exit();
         }
         add_action( 'wp_ajax_wpdatatables_get_complete_table_json_by_id', 'wpdatatables_get_complete_table_json_by_id' );


                 
         /**
          * List all tables in JSON
          */
         function wpdatatable_list_all_tables(){
			 if( !current_user_can('manage_options') ) { exit(); }

             echo json_encode( wdt_get_all_tables_nonpaged() );
             exit();
         }
         add_action( 'wp_ajax_wpdatatable_list_all_tables', 'wpdatatable_list_all_tables' );
         
         /**
          * List all charts in JSON
          */
         function wpdatatable_list_all_charts(){
			 if( !current_user_can('manage_options') ) { exit(); }

             echo json_encode( wdt_get_all_charts_nonpaged() );
             exit();
         }
         add_action( 'wp_ajax_wpdatatable_list_all_charts', 'wpdatatable_list_all_charts' );


?>
