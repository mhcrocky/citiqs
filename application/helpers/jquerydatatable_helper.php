<?php
    declare(strict_types=1);

    if(!defined('BASEPATH')) exit('No direct script access allowed');
    
    class Jquerydatatable_helper
    {
        public static function data_output(array  $columns, array $data ): array
        {
            $out = array();

            for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
                $row = array();

                for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                    $column = $columns[$j];

                    // Is there a formatter?
                    if ( isset( $column['formatter'] ) ) {
                        if(empty($column['db'])){
                            $row[ $column['dt'] ] = $column['formatter']( $data[$i] );
                        }
                        else{
                            $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                        }
                    }
                    else {
                        if(!empty($column['db'])){
                            $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                        }
                        else{
                            $row[ $column['dt'] ] = "";
                        }
                    }
                }

                $out[] = $row;
            }

            return $out;
        }
    }