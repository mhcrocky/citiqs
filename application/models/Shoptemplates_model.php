<?php
    declare(strict_types=1);

    require_once APPPATH . 'interfaces/InterfaceCrud_model.php';
    require_once APPPATH . 'interfaces/InterfaceValidate_model.php';
    require_once APPPATH . 'abstract/AbstractSet_model.php';

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    Class Shoptemplates_model extends AbstractSet_model implements InterfaceCrud_model, InterfaceValidate_model
    {
        public $id;
        public $user_id;
        public $template_file;
        public $template_name;
        public $template_subject;
        public $template_type;
        public $unlayerDesign;

        private $table = 'tbl_email_templates';

        private $templateFolder;
        private $templateFile;

        protected function setValueType(string $property,  &$value): void
        {
            $this->load->helper('validate_data_helper');
            if (!Validate_data_helper::validateNumber($value)) return;

            if ($property === 'id' || $property === 'user_id') {
                $value = intval($value);
            }

            return;
        }

        protected function getThisTable(): string
        {
            return $this->table;
        }

        public function insertValidate(array $data): bool
        {
            if (isset($data['template_name'])) {
                return $this->updateValidate($data);
            }
            $message = 'Mandatory data are not set';
            array_push($this->errorMessages, $message);
            return false;
        }

        public function updateValidate(array $data): bool
        {
            $this->load->helper('validate_data_helper');

            if (!count($data)) return false;
            if (isset($data['template_name']) &&  !Validate_data_helper::validateString($data['template_name'])) return false;
            if (isset($data['unlayerDesign']) &&  !Validate_data_helper::validateStringImproved($data['unlayerDesign'])) return false;
            
            return true;
        }

        private function setTemplateFolder(): void
        {
            $this->load->config('custom');
            $this->templateFolder =  FCPATH . $this->config->item('emailTemplatesFolder') .  $this->user_id . DIRECTORY_SEPARATOR;
            $this->makeTemplateFolder();

            return;
        }

        private function makeTemplateFolder(): void
        {
            if (!is_dir($this->templateFolder)) {
                mkdir($this->templateFolder);
            }
            return;
        }

        private function setTemplateFile(): void
        {
            $this->setTemplateFolder();

            $this->templateFile = $this->templateFolder . $this->template_file  . '.' . $this->config->item('template_extension');
            return;
        }

        public function getTemplateFile(string $name = ''): string
        {
            if ( !$this->templateFile ) {
                $this->setTemplateFile($name);
            }

            return $this->templateFile;
        }

        public function saveTemplate(string $templateName, string $templateSubject, string $html, string $templateType, int $userId, int $id, string $unlayerDesign): bool
        {
            $this->template_name = $templateName;
            $this->template_subject = $templateSubject;
            $this->user_id = $userId;
            $this->id = $id ? $id : null;
            $this->unlayerDesign = $unlayerDesign;
            $filename = str_replace(' ', '_', $templateName);
            $filename .= '_' . time();
            $this->template_file = $filename;
            $this->template_type = $templateType;


            if ($this->checkIsExists()) return false;

            $this->setTemplateFile($templateName);

            if (!$this->saveTemplateHtml($html)) return false;

            if (!$this->id) {
                if ($this->create()) return true;
            } else {
                if ($this->update()) return true;
            }

            unlink($this->templateFile);

            return false;
        }

        private function insertInTable(string $templateName, int $userId): bool
        {
            $data = [
                'template_name' => $templateName,
            ];

            if (!$this->insertValidate($data)) return false;

            $query = $this->prepareInsertQuery($data);

            return $this->db->query($query);
        }

        private function saveTemplateHtml(string $html): bool
        {
            if (file_put_contents($this->templateFile, $html)) return true;

            return false;
        }

        public function fetchTemplates(): ?array
        {
            return $this->readImproved([
                'what' => ['id', 'template_name', 'template_type'],
                'where' => [
                    $this->table . '.user_id' => $this->user_id
                ]
            ]);
        }

        public function countTemplates(): int
        {
            $count = $this->readImproved([
                'what' => ['COUNT(' . $this->table . '.id) AS ids'],
                'where' => [
                    $this->table . '.user_id' => $this->user_id
                ]
            ]);

            $count = reset($count);
            return intval($count['ids']);
        }

        public function checkIsExists(): bool
        {
            $where = [
                //$this->table . '.template_name' => $this->template_name,
                $this->table . '.template_file' => $this->template_file,
                $this->table . '.user_id' => $this->user_id,
            ];

            if ($this->id) {
                $where[$this->table . '.id !='] = $this->id;
            }

            $id = $this->readImproved([
                'what' => ['id'],
                'where' => $where
            ]);

            return !is_null($id);
        }

    }
