<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Reservation_model extends AbstractSet_model implements InterfaceCrud_model
    {
        public $id;
        public $areaId;
        public $persons;
        public $from;
        public $to;

        private $table = 'tbl_area_reservations';

        protected function setValueType(string $property,  &$value): void
        {
            if ($property === 'id' || $property === 'areaId' || $property === 'persons') {
                $value = intval($value);
            }
            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function get_floorplan ($id)
        {
            $this->db->where('id', $id);
            $query = $this->db->get($this->table);
            return $query->row();
        }   
        public function getReservations($floorplanID, $persons, $from = null, $to = null): ?array
        {
            $query =
                "SELECT

					`tbl_floorplan_areas`.`id` AS `id`,
					`tbl_floorplan_areas`.`area_id` AS `area_id`,
                    `tbl_floorplan_areas`.`occupied_color` AS `occupied_color`,
                    `tbl_floorplan_areas`.`free_color` AS `free_color`,
                    `tbl_floorplan_areas`.`unavailable_color` AS `unavailable_color`,
                    `tbl_floorplan_areas`.`label_color` AS `label_color`,
                    `tbl_floorplan_areas`.`area_label` AS `area_label`,
                    `tbl_floorplan_areas`.`area_count` AS `area_count`,
                    `tbl_floorplan_areas`.`available` AS `available`,
                    `tbl_area_reservations`.`to` as `endTime`,
                    `tbl_area_reservations`.`from` as `startTime`,
                    CASE
                        WHEN `tbl_floorplan_areas`.`available` = '0' OR `tbl_floorplan_areas`.`area_count` < {$persons} THEN 'unavailable'
                ";
                if ($from && $to) {
                    $query .=
                        "WHEN
                        (
                            SELECT `reserv`.`id` FROM `tbl_area_reservations` as `reserv` WHERE `reserv`.`areaId` = `tbl_floorplan_areas`.`id` 
                            AND
                                (
                                    
                                    (tbl_area_reservations.from < '{$from}' AND '{$from}' < tbl_area_reservations.to)
                                    OR
                                    
                                    (tbl_area_reservations.from < '{$to}' AND '{$to}' < tbl_area_reservations.to)
                                    OR
                                    
                                    ('{$from}' < tbl_area_reservations.from AND tbl_area_reservations.to < '{$to}')
                                    OR
                                    
                                    (
                                        (tbl_area_reservations.from <= '{$from}' AND '{$from}' < tbl_area_reservations.to)
                                        AND
                                        tbl_area_reservations.to < '{$to}'
                                    )
                                    OR
                                    
                                    (
                                        '{$from}' < tbl_area_reservations.from
                                        AND
                                        (tbl_area_reservations.from < '{$to}' AND '{$to}' <= tbl_area_reservations.to)
                                    )
                                    OR
                                    
                                    (tbl_area_reservations.from = '{$from}' AND tbl_area_reservations.to = '{$to}')
                                )
                            LIMIT 1
                        ) IS NOT NULL THEN 'occupied'";
                }   
                $query .=
                        "ELSE 'free'
                    END as `area_status`
                FROM
                    `tbl_floorplan_areas`
                    
                LEFT JOIN `tbl_area_reservations` ON `tbl_area_reservations`.`areaId` = `tbl_floorplan_areas`.`id`
                WHERE `tbl_floorplan_areas`.`floorplanID` = {$floorplanID}";
            $result = $this->db->query($query);
            return $result->result_array();
        }

        public function checkIsSpotFree($persons, $from, $to, $areaId): bool
        {
            $query =
                "SELECT 
                    COUNT(`tbl_area_reservations`.`id`) AS `reservationId`,
                    tbl_floorplan_areas.available,
                    IF (tbl_floorplan_areas.area_count >= {$persons}, 1, 0) AS persons
                FROM 
                    tbl_area_reservations
                INNER JOIN
                    tbl_floorplan_areas ON tbl_floorplan_areas.id = tbl_area_reservations.areaId
                WHERE
                    tbl_area_reservations.areaId = {$areaId}                    
                    AND
                    (
                        (tbl_area_reservations.from < '{$from}' AND '{$from}' < tbl_area_reservations.to)
                        OR                        
                        (tbl_area_reservations.from < '{$to}' AND '{$to}' < tbl_area_reservations.to)
                        OR                        
                        ('{$from}' < tbl_area_reservations.from AND tbl_area_reservations.to < '{$to}')
                        OR                        
                        (
                            (tbl_area_reservations.from <= '{$from}' AND '{$from}' < tbl_area_reservations.to)
                            AND
                            tbl_area_reservations.to < '{$to}'
                        )
                        OR                        
                        (
                            '{$from}' < tbl_area_reservations.from
                            AND
                            (tbl_area_reservations.from < '{$to}' AND '{$to}' <= tbl_area_reservations.to)
                        )
                        OR
                        (tbl_area_reservations.from = '{$from}' AND tbl_area_reservations.to = '{$to}')
                    );";
            $result = $this->db->query($query);
            $check = $result->result_array();
            $check = reset($check);
            if ($check['reservationId'] === '0' && $check['available'] === '1' && $check['persons'] === '1') {
                return true;
            } else {
                return false;
            }
        }
    }