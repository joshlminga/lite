<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FilterField extends CI_Model
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

	// ------------------------------------------------------------------------

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
		$column_field = $this->CoreForm->get_column_name($title, 'field');
		$column_id = $this->CoreForm->get_column_name($title, 'id');
		$column_stamp = $this->CoreForm->get_column_name($title, 'stamp');
		$column_default = $this->CoreForm->get_column_name($title, 'default');
		$column_flg = $this->CoreForm->get_column_name($title, 'flg');

		// SQL
		$sql = "SELECT field_id as `id`,field_id as `$column_field`,field_id as `$column_id`,";
		// Pre Select
		$sql .= "field_stamp as `$column_stamp`,field_default as `$column_default`,field_flg as `$column_flg`, ";

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
	 */
	public function filter_table($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'])
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
		$clause = $this->filter_all_clause($module, $where, $limit, $sort);

		// Full Query
		$run_sql .= "$clause";

		// Get SQL
		$sql = $this->filter_query_type($title, $filtered, $run_sql);

		// Execute
		$query = $this->db->query($sql);
		$results = $query->result();

		// Return
		return (count($results) > 0) ? $results : null;
	}

	/**
	 * Todo:: Get Filtered Table => Using With
	 * 
	 * @param string $filter customfields title/ ['title' => 'customfields title','filtered' => true]
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 */
	public function filter_table_with($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'])
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
		$clause = $this->filter_all_clause($module, $where, $limit, $sort);

		// Full Query
		$run_sql .= "$clause";

		// Get SQL
		$sql = $this->filter_query_type($title, $filtered, $run_sql, 'with');

		// Execute
		$query = $this->db->query($sql);
		$results = $query->result();

		// Return
		return (count($results) > 0) ? $results : null;
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
	public function filter_table_temp($filter, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $exc = false)
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
		$clause = $this->filter_all_clause($module, $where, $limit, $sort);

		// Full Query
		$run_sql .= "$clause";

		// Sql - Execute
		if ($exc) {
			// Get SQL
			$sql = $this->filter_query_type($title, $filtered, $run_sql, 'temporary');
			// Execute
			$query = $this->db->query($sql);
			$results = $query->result();
		} else {
			// Get SQL -Temp Table
			$sql_temp = $this->filter_query_type($title, $filtered, "", 'temporary');
			// Execute
			$this->db->query($sql_temp);

			// Get SQL - Table Execute
			$query = $this->db->query($run_sql);
			$results = $query->result();
		}

		// Return
		return (count($results) > 0) ? $results : null;
	}

	/**
	 * Todo: Get All Clauses
	 * 
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 */
	private function filter_all_clause($module, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'])
	{
		// Get Where, Sort and Limit
		$where_sql = $this->filter_clause($module, $where, $limit, $sort, 'where');
		$sort_sql = $this->filter_clause($module, $where, $limit, $sort, 'sort');
		$limit_sql = $this->filter_clause($module, $where, $limit, $sort, 'limit');

		// Join
		$clause = " $where_sql $sort_sql $limit_sql";

		// Return
		return $clause;
	}

	/**
	 * Todo:: Filtered Clauses
	 * 
	 * @param array $where The where clauses
	 * @param array optional $limit Array or Integer or Null  [start from, max results] | Int max results
	 * @param array $order The order by clauses [column, order]
	 * @param string $type where, sort, limit
	 */
	private function filter_clause($module, $where = ['flg' => 1], $limit = null, $sort = ['id' => 'DESC'], $get = "where")
	{
		//Modules
		$module = $this->plural->singularize($module);

		// Filter
		$filter_sql = "";

		// Where
		if ($get == "where") {
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

		// Order By
		elseif ($get == "sort") {
			$order_by = "";
			foreach ($sort as $key => $value) {
				$column = $this->CoreForm->get_column_name($module, $key);
				$order_by = " ORDER BY `$column` $value "; //Set Proper Column Name 
			}
			$filter_sql .= $order_by;
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
				$select_values[$i] = "'$value'";
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

			$val = $select_values[$i];
			$select_column_value[$i] = "`$col` $sign $val";
		}

		array_values($select_column_value);

		// Return
		return $select_column_value;
	}
}

/* End of file FilterField.php */
