<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CoreSearch extends CI_Model
{
	/**
	 *
	 * To load libraries/Model/Helpers/Add custom code which will be used in this Model
	 * This can ease the loading work 
	 * 
	 */
	public function __construct()
	{

		parent::__construct();

		//libraries

		//Helpers

		//Models

		// Your own constructor code
	}

	/*********** SMART SEARCH */

	/**
	 * Todo:: Search From Filtred Field Data
	 * 
	 * @param string $query_string
	 * @param string $find // The string of what you are searching for
	 * @param array $look_in // Hierachy of the search priority
	 * @param integer/array $limit
	 * @param array $getcolumns // Filter the search
	 */
	public function search($query_string, $find, $limit = null, $getcolumns = ['field_id,field_title,field_data,field_stamp,field_flg'], $look_in = ['field_plain'])
	{
		// Word
		$word_stripped = $this->remove_common_words($find);
		$word_array = explode(' ', $word_stripped); // Turn To Array
		$word_array_count = count($word_array); // Total words

		// Get Call to string
		$getcolumns = (is_array($getcolumns)) ? implode(',', $getcolumns) : $getcolumns;

		// Word as Total
		$as_word_count = '';
		if (count($look_in) > 0) {
			// Loop words in array ($word_array)
			foreach ($word_array as $word_key => $word_value) {
				$as_word_count .= "( " . $look_in[0] . " LIKE '%" . $word_value . "%') + ";
			}

			// Check Length of $as_word_count
			$look_in_lenght = strlen($as_word_count); // If has ( " . xx . " LIKE '%" . xx . "%') + should be more than 5
			if ($look_in_lenght > 5) {
				$as_word_count = "(" . substr($as_word_count, 0, $look_in_lenght - 2) . ") AS total_" . $look_in[0];
				// Add To Get Columns | getcolumns
				$getcolumns = (is_null($getcolumns)) ? $as_word_count : $getcolumns . ", " . $as_word_count;
			}
		}

		// Check $getcolumns
		$getcolumns = (is_null($getcolumns)) ? ' * ' : $getcolumns;

		// Search
		$percnt = '%';
		$and = ''; // begin by not adding word AND
		$or = ' OR ';
		// Hierarchy Order
		$hierarchy_order = [];
		$order_no = 0;

		// Where Clause
		$where_clause = '';

		// Where | loop through $look_in AND
		foreach ($look_in as $column_name) {
			$hierarchy_order[$order_no] = [];
			foreach ((array) $word_array as $term) {
				// First step - LIKE escaping
				$term = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $term);
				// Second step - literal escaping
				$term = $this->db->escape_str($term);

				// Add to Where Clause
				$where_clause .= "{$and}({$column_name} LIKE '{$percnt}{$term}{$percnt}')";
				array_push($hierarchy_order[$order_no], "{$column_name} LIKE '{$percnt}{$term}{$percnt}'");
				$and = ' AND '; // Start adding And on the next iteration
			}
			$order_no++;
			$and = $or; // Change and to OR since we are starting a new OR statement
		}

		// Where | loop through $look_in OR
		if (count($word_array) > 1) { // Only Add or when search has more than 1 word
			foreach ($look_in as $column_name) {
				foreach ((array) $word_array as $term) {
					// First step - LIKE escaping
					$term = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $term);
					// Second step - literal escaping
					$term = $this->db->escape_str($term);
					// Add to Where Clause
					$where_clause .= "{$or}({$column_name} LIKE '{$percnt}{$term}{$percnt}')";
				}
			}
		}

		// prepare variable for generating ORDER BY clause
		$q = [
			'search_columns' => $look_in,
			'search_colCount' => count($look_in),
			'search_terms_count' => $word_array_count,
			'search_orderby_title' => $hierarchy_order[0],
			's' => $find
		];
		$search_orderby = '';
		if ($word_array_count > 1) {
			// multiple words search
			$search_orderby = ' ORDER BY ' . $this->parse_search_order($q);
		} else {
			// Single word or sentence search.
			$search_orderby = ' ORDER BY (' . reset($q['search_orderby_title']) . ')';
		}

		// Order By Total_plain
		if (strlen($as_word_count) > 5) {
			$search_orderby .= ",  total_" . $look_in[0] . " DESC";
		}

		// Check Limit
		$query_limit = true;
		if (!is_array($limit)) {
			$query_limit = (strtolower(trim($limit)) == 'all') ? false : true;
		}

		// Limit
		$start_limit = 0;
		$result_limit = $limit;
		if (is_array($limit)) {
			$start_limit = (array_key_exists('start', $limit)) ? $limit['start'] : 0;
			$result_limit = (array_key_exists('limit', $limit)) ? $limit['limit'] : $limit;
		}
		$result_limit = (!is_null($result_limit)) ? $result_limit : $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'post_per_page', 'flg' => 1));

		// Prepaire Query
		$sql = "SELECT " . $getcolumns . " FROM " . "($query_string)" . " `fields` " . " WHERE " . $where_clause . " " . $search_orderby . " LIMIT " . $start_limit . ", " . $result_limit;
		// Execute
		$query = $this->db->query($sql);
		$results = $query->result();
		// Return
		return (count($results) > 0) ? $results : null;
	}

	/**
	 * Todo:: Search From Filtred Field Data
	 * 
	 * @param string $query_string
	 * @param string $find // The string of what you are searching for
	 * @param array $look_in // Hierachy of the search priority
	 * @param integer/array $limit
	 * @param array $getcolumns // Filter the search
	 */
	public function search_nolimit($query_string, $find, $getcolumns = ['field_id,field_title,field_data,field_stamp,field_flg'], $look_in = ['field_plain'])
	{
		// Word
		$word_stripped = $this->remove_common_words($find);
		$word_array = explode(' ', $word_stripped); // Turn To Array
		$word_array_count = count($word_array); // Total words

		// Get Call to string
		$getcolumns = (is_array($getcolumns)) ? implode(',', $getcolumns) : $getcolumns;

		// Word as Total
		$as_word_count = '';
		if (count($look_in) > 0) {
			// Loop words in array ($word_array)
			foreach ($word_array as $word_key => $word_value) {
				$as_word_count .= "( " . $look_in[0] . " LIKE '%" . $word_value . "%') + ";
			}

			// Check Length of $as_word_count
			$look_in_lenght = strlen($as_word_count); // If has ( " . xx . " LIKE '%" . xx . "%') + should be more than 5
			if ($look_in_lenght > 5) {
				$as_word_count = "(" . substr($as_word_count, 0, $look_in_lenght - 2) . ") AS total_" . $look_in[0];
				// Add To Get Columns | getcolumns
				$getcolumns = (is_null($getcolumns)) ? $as_word_count : $getcolumns . ", " . $as_word_count;
			}
		}

		// Check $getcolumns
		$getcolumns = (is_null($getcolumns)) ? ' * ' : $getcolumns;

		// Search
		$percnt = '%';
		$and = ''; // begin by not adding word AND
		$or = ' OR ';
		// Hierarchy Order
		$hierarchy_order = [];
		$order_no = 0;

		// Where Clause
		$where_clause = '';

		// Where | loop through $look_in AND
		foreach ($look_in as $column_name) {
			$hierarchy_order[$order_no] = [];
			foreach ((array) $word_array as $term) {
				// First step - LIKE escaping
				$term = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $term);
				// Second step - literal escaping
				$term = $this->db->escape_str($term);

				// Add to Where Clause
				$where_clause .= "{$and}({$column_name} LIKE '{$percnt}{$term}{$percnt}')";
				array_push($hierarchy_order[$order_no], "{$column_name} LIKE '{$percnt}{$term}{$percnt}'");
				$and = ' AND '; // Start adding And on the next iteration
			}
			$order_no++;
			$and = $or; // Change and to OR since we are starting a new OR statement
		}

		// Where | loop through $look_in OR
		if (count($word_array) > 1) { // Only Add or when search has more than 1 word
			foreach ($look_in as $column_name) {
				foreach ((array) $word_array as $term) {
					// First step - LIKE escaping
					$term = str_replace(array('\\', '_', '%'), array('\\\\', '\\_', '\\%'), $term);
					// Second step - literal escaping
					$term = $this->db->escape_str($term);
					// Add to Where Clause
					$where_clause .= "{$or}({$column_name} LIKE '{$percnt}{$term}{$percnt}')";
				}
			}
		}

		// prepare variable for generating ORDER BY clause
		$q = [
			'search_columns' => $look_in,
			'search_colCount' => count($look_in),
			'search_terms_count' => $word_array_count,
			'search_orderby_title' => $hierarchy_order[0],
			's' => $find
		];
		$search_orderby = '';
		if ($word_array_count > 1) {
			// multiple words search
			$search_orderby = ' ORDER BY ' . $this->parse_search_order($q);
		} else {
			// Single word or sentence search.
			$search_orderby = ' ORDER BY (' . reset($q['search_orderby_title']) . ')';
		}

		// Order By Total_plain
		if (strlen($as_word_count) > 5) {
			$search_orderby .= ",  total_" . $look_in[0] . " DESC";
		}

		// Prepaire Query
		$sql = "SELECT " . $getcolumns . " FROM " . "($query_string)" . " `fields` " . " WHERE " . $where_clause . " " . $search_orderby;
		// Execute
		$query = $this->db->query($sql);
		$results = $query->result();
		// Return
		return (count($results) > 0) ? $results : null;
	}

	/**
	 * Todo:: Remove Common Words
	 * 
	 * @param string $word
	 * @param array $common_words - default is null
	 */
	private function remove_common_words($word, $common_words = [])
	{
		// words to be removed
		# used words as key for better performance
		$stopwords = [
			'about' => 1, 'a' => 1, 'an' => 1, 'are' => 1, 'as' => 1, 'at' => 1, 'be' => 1, 'by' => 1, 'com' => 1,
			'for' => 1, 'from' => 1, 'how' => 1, 'in' => 1, 'is' => 1, 'it' => 1, 'of' => 1, 'on' => 1, 'or' => 1,
			'that' => 1, 'the' => 1, 'this' => 1, 'to' => 1, 'was' => 1, 'what' => 1, 'when' => 1, 'where' => 1,
			'who' => 1, 'will' => 1, 'with' => 1, 'www' => 1
		];

		// Load Model
		$this->load->model('CoreTrigger');
		$stopwords = ((method_exists('CoreTrigger', 'filterCommonWords'))) ? $this->CoreTrigger->filterCommonWords($stopwords, $common_words) : array_merge($stopwords, $common_words);

		// 1.) break string into words
		// [^-\w\'] matches characters, that are not [0-9a-zA-Z_-']
		// if input is unicode/utf-8, the u flag is needed: /pattern/u
		$words = preg_split('/[^-\w\']+/', $word, -1, PREG_SPLIT_NO_EMPTY);

		// 2.) if we have at least 2 words, remove stopwords
		if (count($words) > 1) {
			$words = array_filter($words, function ($w) use (&$stopwords) {
				return !isset($stopwords[strtolower($w)]);
				# if utf-8: mb_strtolower($w, "utf-8")
			});
		}

		// check if not too much was removed such as "the the" would return empty
		if (!empty($words)) {
			return implode(" ", $words);
		}

		// if too much was removed, return original string
		return $words;
	}

	/**
	 * Todo:: Search Order
	 * 
	 * @param array $order_array
	 */
	private function parse_search_order($order_array)
	{

		if ($order_array['search_terms_count'] > 1) {
			$num_terms = count($order_array['search_orderby_title']);

			// If the search terms contain negative queries, don't bother ordering by sentence matches.
			$like = '';
			if (!preg_match('/(?:\s|^)\-/', $order_array['s'])) {
				$like = '%' . $this->db->escape_str($order_array['s']) . '%';
			}

			$search_orderby = '';

			// Sentence match in 'plain'. //or the first passed column under $look_in
			if ($like) {
				$search_orderby .= "WHEN {$order_array['search_columns'][0]} LIKE '{$like}' THEN 1 ";
			}

			// Sanity limit, sort as sentence when more than 6 terms
			// (few searches are longer than 6 terms and most titles are not).
			if ($num_terms < 7) {
				// All words in title.
				$search_orderby .= 'WHEN ' . implode(' AND ', $order_array['search_orderby_title']) . ' THEN 2 ';
				// Any word in title, not needed when $num_terms == 1.
				if ($num_terms > 1) {
					$search_orderby .= 'WHEN ' . implode(' OR ', $order_array['search_orderby_title']) . ' THEN 3 ';
				}
			}

			$thenCnt = 4;
			// Sentence match in 'post_content' and 'post_excerpt'.
			if ($like) {
				for ($i = 1; $i < $order_array['search_colCount']; $i++) {
					$search_orderby .= "WHEN {$order_array['search_columns'][$i]} LIKE '{$like}' THEN {$thenCnt} ";
					$thenCnt++;
				}
			}

			if ($search_orderby) {
				$search_orderby = "(CASE " . $search_orderby . "ELSE {$thenCnt} END)";
			}
		} else {
			// Single word or sentence search.
			$search_orderby = reset($order_array['search_orderby_title']) . ' DESC';
		}

		// If the search terms contain negative queries, don't bother ordering by sentence matches.
		return $search_orderby;
	}

	/*********** END SMART SEARCH */

	/**
	 * Todo:: By Defaulr get Filtered Fields Only
	 * 
	 * @param string customfields title/ field ID
	 * @param string $filtered true to only focus on filtered fields
	 * 
	 * @return array
	 */
	private function filter_keys($field, $filtered = true)
	{
		// Check if is not numeric
		if (is_numeric($field)) {
			// Select Title from field table using selectSingle
			$field = $this->CoreCrud->selectSingleValue('field', 'title', ['id' => $field]);
		}

		// Check customfields version
		$selectData = $this->db->select('*')->where(['customfield_title' => $field])->limit(1)->get('customfields')->result();
		$custom_found = (count($selectData) > 0) ? $selectData : null;
		if (!is_array($custom_found)) {
			return null;
		}

		// Check if property 'customfield_required' exist
		if (property_exists($custom_found[0], 'customfield_required')) {
			$customfield_required = (property_exists($custom_found[0], 'customfield_required')) ? json_decode($custom_found[0]->customfield_required) : [];
			// Check if property 'customfield_options' exist
			$customfield_optional = (property_exists($custom_found[0], 'customfield_optional')) ? json_decode($custom_found[0]->customfield_optional) : [];
			$customfield_filters = json_decode($custom_found[0]->customfield_filters);
			// Filtered Only
			if ($filtered) {
				// Filtered Keys
				$column = $customfield_filters;
			} else {
				// Merge Keys
				$keys = array_merge($customfield_required, $customfield_optional);
				// loop through keys replace space with underscore
				foreach ($keys as $key => $value) {
					$column[$key] = trim(str_replace(' ', '_', $value));
				}
			}
		} else {
			// Get Custom Fields
			$columns = $this->CoreCrud->selectMultipleValue('customfields', 'filters as filters,keys as keys', ['title' => $field]);

			// Filtered Only
			if ($filtered) {
				// Filtered Keys
				$column = json_decode($columns[0]->filters, True);
			} else {
				// All Keys
				$column = json_decode($columns[0]->keys, True);
			}
		}

		// Return Keys
		return (count($column) > 0) ? $column : null;
	}

	/**
	 * Todo:: Prepaire SQL for Filtering
	 * 
	 * @param string $field customfields title/ field ID
	 * @param string $filtered true to only focus on filtered fields
	 */
	private function filter_sql($field, $filtered = true)
	{

		// Get customfields Title 
		$customfield_title = $field;
		// Check if is not numeric
		if (is_numeric($customfield_title)) {
			// Select Title from field table using selectSingle
			$customfield_title = $this->CoreCrud->selectSingleValue('field', 'title', ['id' => $customfield_title]);
		}

		//Modules
		$title = $this->plural->singularize($customfield_title);
		$filterTables = $this->plural->pluralize($customfield_title);

		// Get Columns
		$columns = $this->filter_keys($customfield_title, $filtered);
		if (!is_array($columns)) {
			return null;
		}

		// Get Column Name Field,Stamp,default,flg
		$column_id = $this->CoreForm->get_column_name($title, 'id');
		$column_field = $this->CoreForm->get_column_name($title, 'field');
		$column_stamp = $this->CoreForm->get_column_name($title, 'stamp');
		$column_default = $this->CoreForm->get_column_name($title, 'default');
		$column_flg = $this->CoreForm->get_column_name($title, 'flg');

		// SQL
		$sql = "SELECT field_id,field_id as `$column_field`,field_id as `$column_id`,field_title,field_plain,";
		// Pre Select
		$sql .= "field_data,field_stamp,field_stamp as `$column_stamp`,field_default,field_default as `$column_default`,field_flg,field_flg as `$column_flg`, ";

		// Loop Columns to add to SQL
		foreach ($columns as $column) {
			// Get Column Name
			$column_name = $this->CoreForm->get_column_name($title, $column);
			// sql_string
			$sql_string = " JSON_UNQUOTE(JSON_EXTRACT(`field_data`, '$.$column')) AS $column_name ";
			// Check if is not the last column & Add to SQL
			$sql .= ($column != end($columns)) ? " $sql_string," : " $sql_string";
		}

		// From & Where
		$sql .= " FROM `fields` WHERE `field_title`= '$title'";

		// Return
		return $sql;
	}

	/**
	 * Todo:: Using Temporary Table / WITH / SELECT
	 * 
	 * @param string $title customfields title
	 * @param string $filtered true to only focus on filtered fields
	 * @param string $query final query section
	 * @param string $type | temporary | with | select
	 */
	private function filter_query_type($title, $filtered = true, $query = '', $type = 'select')
	{

		// Get customfields Title 
		$customfield_title = $title;
		// Check if is not numeric
		if (is_numeric($customfield_title)) {
			// Select Title from field table using selectSingle
			$customfield_title = $this->CoreCrud->selectSingleValue('field', 'title', ['id' => $customfield_title]);
		}
		//Modules
		$title = $this->plural->singularize($customfield_title);
		$filterTables = $this->plural->pluralize($customfield_title);

		// Switch
		switch ($type) {
			case 'temporary':
				// open
				$sql = "CREATE TEMPORARY TABLE $filterTables AS ";

				// Temporary Table
				$sql .= $this->filter_sql($title, $filtered);

				// Close
				$sql .= "; $query;";
				// Return
				return $sql;
				break;
			case 'with':
				// open
				$sql = "WITH $filterTables AS (";
				// With
				$sql .= $this->filter_sql($title, $filtered);
				// Close
				$sql .= ") $query ;";
				// Return
				return $sql;
				break;
			default:
				// Open
				$sql = "SELECT * FROM (";
				// Select
				$sql .= $this->filter_sql($title, $filtered);
				// Close
				$sql .= ") $query;";
				// Return
				return $sql;
				break;
		}
	}

	/**
	 * Todo:: Get Filtered Table
	 * 
	 * @param string $filter customfields title/ ['title' => 'customfields title','filtered' => true]
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param boolean $runquery true == execute | false == sql
	 */
	public function filter_table($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $runquery = true)
	{
		// Get Title & Filtered
		$filter = $this->filter_title_filtres($filter);
		// Title
		$title = $filter['title'];
		// Filtered
		$filtered = $filter['filtered'];

		//Modules
		$module = $this->plural->singularize($title);
		$filterTables = $this->plural->pluralize($title);

		// Run SQL -> Using Select
		$run_sql = "$filterTables ";

		// Clause
		$clause = $this->filter_all_clause($module, $where, $limit, $sort, $runquery);

		// Full Query
		$run_sql .= "$clause";

		// Get SQL
		$sql = $this->filter_query_type($title, $filtered, $run_sql);

		// Run Query
		if ($runquery) {
			// Execute
			$query = $this->db->query($sql);
			$results = $query->result();

			// Return
			return (count($results) > 0) ? $results : null;
		}

		//Check if the last character is semi-colon and remove it
		$sql = (substr($sql, -1) == ';') ? substr($sql, 0, -1) : $sql;

		// Return
		return ['run' => $sql];
	}

	/**
	 * Todo:: Get Filtered Table => Using With
	 * 
	 * @param string $filter customfields title/ ['title' => 'customfields title','filtered' => true]
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param boolean $runquery true == execute | false == sql
	 */
	public function filter_table_with($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $runquery = true)
	{

		// Get Title & Filtered
		$filter = $this->filter_title_filtres($filter);
		// Title
		$title = $filter['title'];
		// Filtered
		$filtered = $filter['filtered'];

		//Modules
		$module = $this->plural->singularize($title);
		$filterTables = $this->plural->pluralize($title);

		// Run SQL -> Using Select
		$run_sql = "SELECT * FROM $filterTables ";

		// Clause
		$clause = $this->filter_all_clause($module, $where, $limit, $sort, $runquery);

		// Full Query
		$run_sql .= "$clause";

		// Get SQL
		$sql = $this->filter_query_type($title, $filtered, $run_sql, 'with');

		// Run Query
		if ($runquery) {
			// Execute
			$query = $this->db->query($sql);
			$results = $query->result();

			// Return
			return (count($results) > 0) ? $results : null;
		}

		//Check if the last character is semi-colon and remove it
		$sql = (substr($sql, -1) == ';') ? substr($sql, 0, -1) : $sql;

		// Return
		return ['run' => $sql];
	}

	/**
	 * Todo:: Get Filtered Table => Using Temporary Table
	 * 
	 * @param string $filter customfields title/ ['title' => 'customfields title','filtered' => true]
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param boolean $exc true == both | false == single
	 */
	public function filter_table_temp($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $exc = false, $runquery = true)
	{

		// Get Title & Filtered
		$filter = $this->filter_title_filtres($filter);
		// Title
		$title = $filter['title'];
		// Filtered
		$filtered = $filter['filtered'];

		//Modules
		$module = $this->plural->singularize($title);
		$filterTables = $this->plural->pluralize($title);

		// Run SQL -> Using Select
		$run_sql = "SELECT * FROM $filterTables ";

		// Clause
		$clause = $this->filter_all_clause($module, $where, $limit, $sort, $runquery);

		// Full Query
		$run_sql .= "$clause";

		// Run
		$run = ['run' => $run_sql];

		// Sql - Execute
		if ($exc) {
			// Get SQL
			$sql = $this->filter_query_type($title, $filtered, $run_sql, 'temporary');
			// Run Query
			if ($runquery) {
				// Execute
				$query = $this->db->query($sql);
				$results = $query->result();
			}

			// Run Temp
			$run['temp'] = $sql;
		} else {
			// Get SQL -Temp Table
			$sql_temp = $this->filter_query_type($title, $filtered, "", 'temporary');

			// Run Query
			if ($runquery) {
				// Execute
				$this->db->query($sql_temp);

				// Get SQL - Table Execute
				$query = $this->db->query($run_sql);
				$results = $query->result();
			}

			// Run Temp
			$run['temp'] = $sql_temp;
		}

		// Run Query
		if ($runquery) {
			// Return
			return (count($results) > 0) ? $results : null;
		}
		//Check if the last character is semi-colon and remove it
		$run['run'] = (substr($run['run'], -1) == ';') ? substr($run['run'], 0, -1) : $run['run'];
		$run['temp'] = (substr($run['temp'], -1) == ';') ? substr($run['temp'], 0, -1) : $run['temp'];

		// Return
		return $run;
	}

	/**
	 * Todo: Get All Clauses
	 * 
	 * @param string $module filter name
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param boolean $allow_limit true == allow | false == don't allow
	 */
	private function filter_all_clause($module, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $allow_limit = true)
	{
		// Get Where, Sort and Limit
		$where_sql = (!is_null($where)) ? $this->filter_clause($module, $where, $limit, $sort, 'where') : '';
		$sort_sql = $this->filter_clause($module, $where, $limit, $sort, 'sort');

		// Limit
		$limit_sql = ($allow_limit) ? $this->filter_clause($module, $where, $limit, $sort, 'limit') : '';

		// Join
		$clause = " $where_sql $sort_sql $limit_sql";

		// Return
		return $clause;
	}

	/**
	 * Todo:: Filtered Clauses
	 * 
	 * @param string $module filter name
	 * @param array $where The where clauses
	 * @param integer $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param string $get where, sort, limit
	 */
	private function filter_clause($module, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $get = "where")
	{
		//Modules
		$module = $this->plural->singularize($module);

		// Filter
		$filter_sql = "";

		// Where
		if ($get == "where") {
			if (is_array($where)) {
				$where_column = null;
				foreach ($where as $key => $value) {
					$column = $this->CoreForm->get_column_name($module, $key);
					$where_column[$column] = $value; //Set Proper Column Name 
				}
				if (is_array($where_column)) {
					$where = implode(' AND ', $this->filter_where($where_column));
					$filter_sql .= " WHERE $where";
				}
			}
		}

		// Order By
		elseif ($get == "sort") {
			if (is_array($sort)) {
				$order_by = "";
				foreach ($sort as $key => $value) {
					$column = $this->CoreForm->get_column_name($module, $key);
					$order_by = " ORDER BY `$column` $value "; //Set Proper Column Name 
				}
				$filter_sql .= $order_by;
			}
		}

		// Check Limit
		elseif ($get == "limit") {
			$query_limit = true;
			if (!is_array($limit)) {
				$query_limit = (strtolower(trim($limit)) == 'all') ? false : true;
			}

			// Limit
			$start_limit = 0;
			$result_limit = $limit;
			if (is_array($limit)) {
				$start_limit = (array_key_exists('start', $limit)) ? $limit['start'] : 0;
				$result_limit = (array_key_exists('limit', $limit)) ? $limit['limit'] : $limit;
			}
			$result_limit = (!is_null($result_limit)) ? $result_limit : $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'post_per_page', 'flg' => 1));
			// Limit
			if ($query_limit) {
				$filter_sql .= " LIMIT $start_limit,$result_limit";
			}
		}

		// Return
		return $filter_sql;
	}

	/**
	 * Todo:: Get Filtred & title
	 * 
	 * @param string $passed customfields title/ ['title' => 'customfields title','filtered' => true]
	 */
	private function filter_title_filtres($passed)
	{
		// Title
		$title = $passed;
		// Filtered
		$filtered = true;

		// Check if is array $title
		if (is_array($title)) {
			// Check if key title exist
			if (!array_key_exists('title', $title)) {
				// Add title key
				$title = $title['title'];
			}

			// Check if key filtered exist
			if (!array_key_exists('filtered', $title)) {
				// Add filtered key
				$filtered = $title['filtered'];
			}
		}

		// Return
		return array('title' => $title, 'filtered' => $filtered);
	}

	/**
	 * Todo:: Get Where Values
	 * 
	 * @param array $where The where clauses
	 */
	private function filter_where($select)
	{
		// Columns
		$columns = array_keys($select);

		$values = array_values($select);
		$select_values = array();

		//Get Values
		for ($i = 0; $i < count($values); $i++) {
			$value = $values[$i];
			if (!is_numeric($value)) {
				$select_values[$i] = (!is_array($value)) ? "'$value'" : $value;
			} else {
				$select_values[$i] = $value;
			}
		}

		// Get Select
		$select_column_value = array();
		for ($i = 0; $i < count($columns); $i++) {
			$sign = '=';

			$col_sign = explode(' ', $columns[$i]);
			$col = $col_sign[0];
			$sign = (array_key_exists(1, $col_sign)) ? $col_sign[1] : $sign;

			// Arthmetic Sign
			$arthmetic_sign = array('=', '!=', '>', '<', '>=', '<=');
			// Check if sign is String
			if (is_string($sign) && !in_array($sign, $arthmetic_sign)) {
				// String Clause - 
				$all_signs = $col_sign;
				//unset index 0
				unset($all_signs[0]);
				// Implode
				$sign = implode(' ', $all_signs);
				// Toupper
				$sign = strtoupper($sign);

				// All of MySQL clauses eg: in,not in,like,not like,between,not between
				//$all_clauses = array('IN', 'NOT IN', 'LIKE', 'NOT LIKE', 'BETWEEN', 'NOT BETWEEN');
				// All of MySQL clauses which require value in brackets eg: in,not in,between,not between
				$all_clauses_brackets = array('IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN');
				if (in_array($sign, $all_clauses_brackets)) {
					// Check if value is array
					if (is_array($select_values[$i])) {
						// Implode
						for ($xi = 0; $xi < count($select_values[$i]); $xi++) {
							// Check To Add Quotes
							$select_values[$i][$xi] = (!is_numeric($select_values[$i][$xi])) ? "'" . $select_values[$i][$xi] . "'" : $select_values[$i][$xi];
						}
					}
					$select_values[$i] = (is_array($select_values[$i])) ? implode(',', $select_values[$i]) : $select_values[$i];

					// Add Brackets
					$select_values[$i] = "($select_values[$i])";
				} else {
					// Add Brackets
					$select_values[$i] = "$select_values[$i]";
				}

				// $select_column_value[$i] = "`$col` $sign $select_values[$i]";
			}


			$val = $select_values[$i];
			$select_column_value[$i] = "`$col` $sign $val";
		}

		array_values($select_column_value);

		// Return
		return $select_column_value;
	}
}

/* End of file CoreSearch.php */
