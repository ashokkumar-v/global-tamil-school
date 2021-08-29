<?php
class DataTableHelper{
    private $conn;
    private $sql_query;
    private $count_query;
    private $filter_count_query;

    private $main_part;
    private $where_part;
    private $order_part;
    private $limit_part;

    private $total_row;
    private $filtered_row;

    function __construct(){
        $this->conn=new \MySQLi;
        $this->sql_query="";
        $this->filter_count_query="";
        $this->main_part="";
        $this->where_part="";
        $this->order_part="";
        $this->total_row="";
        $this->filtered_row="";
    }

    public function dbExec($mysql_conn_details,$request,$query,$columns){
        if($this->connect($mysql_conn_details))
        {
            $this->conn->query("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
            $ret_data=array();
            $ret_data["draw"]=isset ( $request['draw'] ) ? intval( $request['draw'] ) : 0;
            $bindings = array();
            $this->limit_part = self::limit( $request, $columns );
            $this->order_part = self::order( $request, $columns );
            $this->where_part = self::filter( $request, $columns, $bindings );

            // Main query
            $this->count_query="SELECT * FROM (".$query.") AS `temp_table` $this->where_part $this->order_part $this->limit_part";
		//	echo "SELECT * FROM (".$query.") AS `temp_table` $this->where_part $this->order_part $this->limit_part";
            $res=$this->conn->query($this->count_query);
            $rows_set=array();
            $data=$this->count_query;
            if($res->num_rows>0){
                while($values = $res->fetch_assoc()){
                    $rows_set[]=$values;
                }
                $ret_data["data"]=self::data_output( $columns,$rows_set );
            }
            else{
                $ret_data["data"]="";
               // $ret_data["error"]="No data found!";
            }

            // Count Query
            $this->count_query="SELECT COUNT(*) AS `total` FROM (".$query.") AS `temp_table`";
            $res=$this->conn->query($this->count_query);
            if($res->num_rows==1){
                $values = $res->fetch_assoc();
                $this->total_row=$values["total"];
            }
            else{
                $this->total_row=0;
            }



            $this->filter_count_query="SELECT COUNT(*) AS `total` FROM (".$query.") AS `temp_table` ".$this->where_part;
            $res=$this->conn->query($this->filter_count_query);
            if($res->num_rows==1){
                $values = $res->fetch_assoc();
                $this->filtered_row=$values["total"];
            }
            else{
                $this->filtered_row=0;
            }

            $this->limit_part = '';
            if ( isset($request['start']) && $request['length'] != -1 ) {
                $this->limit_part = " LIMIT ".intval($request['start']).", ".intval($request['length']);
            }

            $this->sql_query="SELECT COUNT(*) AS `total` FROM (".$query.") AS `temp_table`".$this->limit_part;

            $ret_data["recordsTotal"]=intval( $this->total_row );
            $ret_data["recordsFiltered"]=intval( $this->filtered_row );
            return $ret_data;
        }
        else{
            return array("recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"","error"=>"We could not connect database!");
        }
    }

    function connect($mysql_conn_details){
        @$this->conn->connect($mysql_conn_details["host"],$mysql_conn_details["user"],$mysql_conn_details["pass"],$mysql_conn_details["database"]);
        if($this->conn->connect_errno){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    static function filter ( $request, $columns, &$bindings )
    {
		//print_r($request);
		
		if($request['draw'] > 1){
          // print_r($bindings); echo " bindings<br>";
        }
		
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck( $columns, 'dt' );
        if ( isset($request['search']) && $request['search']['value'] != '' ) {
            $str = $request['search']['value'];
            for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['searchable'] == 'true' ) {
                    $binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    $globalSearch[] = "`".$column['db']."` LIKE '%".$str."%'";
                }
            }
        }
        // Individual column filtering
        if ( isset( $request['columns'] ) ) {
            for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                $str = $requestColumn['search']['value'];
                if ( $requestColumn['searchable'] == 'true' &&
                    $str != '' ) {
                    $binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    $columnSearch[] = "`".$column['db']."` LIKE '%".$str."%'";
                }
            }
        }
        // Combine the filters into a single string
        $where = '';
        if ( count( $globalSearch ) ) {
             $where = '('.implode(' OR ', $globalSearch).')';
        }
        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                 $where .' AND '. implode(' AND ', $columnSearch);
        }
        if ( $where !== '' ) {
             $where = 'WHERE '.$where;
        }
		//print_r($where);
        return $where;
    }

    static function limit ( $request)
    {
        $limit = '';
        if ( isset($request['start']) && $request['length'] != -1 ) {
            $limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
        }
        return $limit;
    }

    static function bind ( &$a, $val, $type )
    {
        $key = ':binding_'.count( $a );
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );
        return $key;
    }

    static function order ( $request, $columns )
    {
        $order = '';
        if ( isset($request['order']) && count($request['order']) ) {
            $orderBy = array();
            $dtColumns = self::pluck( $columns, 'dt' );
            for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];
                if ( $requestColumn['orderable'] == 'true' ) {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';
                    $orderBy[] = '`'.$column['db'].'` '.$dir;
                }
            }
            if ( count( $orderBy ) ) {
                $order = 'ORDER BY '.implode(', ', $orderBy);
            }
        }
        return $order;
    }

    static function data_output ( $columns, $data)
    {
        $out = array();
        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();
            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];
                // Is there a formatter?
                if ( isset( $column['formatter'] )) {
                    $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                }
                else {
                    $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db']];
                }
                if(isset( $column['highlight'])){
                    $row["DT_RowClass"]=$column['highlight']( $data[$i][ $column['db'] ], $data[$i] );
                }
                if(isset($column["row_data"])){
                    $row["DT_RowData"]=$column['row_data']( $data[$i][ $column['db'] ], $data[$i] );
                }
            }

            $out[] = $row;
        }
        return $out;
    }

    static function pluck ( $a, $prop )
    {
        $out = array();
        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }
}