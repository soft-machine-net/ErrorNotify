<?php

namespace Plugin\ErrorNotify\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\ErrorNotify\Entity\Config', false)) {
    /**
     * Config
     *
     * @ORM\Table(name="plg_error_notify_config")
     * @ORM\Entity(repositoryClass="Plugin\ErrorNotify\Repository\ConfigRepository")
     */
    class Config  extends \Eccube\Entity\AbstractEntity
    {
        /**
         * @var int
         *
         * @ORM\Column(name="id", type="integer", options={"unsigned":true})
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="IDENTITY")
         */
        private $id;

        /**
         * @var string
         * 
         * @ORM\Column(name="from_mail", type="string", length=255)
         */
        private $from_mail;

        /**
         * @var string
         * 
         * @ORM\Column(name="send_mail", type="string", length=255)
         */
        private $send_mail;

        /**
         * @var boolean
         * 
         * @ORM\Column(name="is_send", type="boolean")
         */
        private $is_send;

        /**
         * @var integer
         * 
         * @ORM\Column(name="send_level", type="integer", length=1)
         */
        private $send_level;

        /**
         * @var boolean
         * 
         * @ORM\Column(name="is_record", type="boolean")
         */
        private $is_record = true;

        /**
         * @var integer
         * 
         * @ORM\Column(name="record_level", type="integer", length=1)
         */
        private $record_level;

        /**
         * @var integer
         * 
         * @ORM\Column(name="record_deduplicated_time", type="integer", length=255)
         */
        private $record_deduplicated_time;

        /**
         * @var integer
         * 
         * @ORM\Column(name="send_deduplicated_time", type="integer", length=255)
         */
        private $send_deduplicated_time;

        
        /**
         * @param $options 
         */
        // function __construct(){

        // }



        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Get the value of from_mail
         */ 
        public function getFromMail()
        {
                return $this->from_mail;
        }

        /**
         * Set the value of from_mail
         *
         * @return  self
         */ 
        public function setFromMail($from_mail)
        {
                $this->from_mail = $from_mail;

                return $this;
        }

        /**
         * Get the value of send_mail
         */ 
        public function getSendMail()
        {
                return $this->send_mail;
        }

        /**
         * Set the value of send_mail
         *
         * @return  self
         */ 
        public function setSendMail($send_mail)
        {
                $this->send_mail = $send_mail;

                return $this;
        }

        /**
         * Get the value of is_send
         *
         * @return  bool
         */ 
        public function getIsSend()
        {
                return $this->is_send;
        }

        /**
         * Set the value of is_send
         *
         * @param  bool  $is_send
         *
         * @return  self
         */ 
        public function setIsSend(bool $is_send)
        {
                $this->is_send = $is_send;

                return $this;
        }

        /**
         * Get the value of send_level
         *
         * @return  integer
         */ 
        public function getSendLevel()
        {
                return $this->send_level;
        }

        /**
         * Set the value of send_level
         *
         * @param  integer  $send_level
         *
         * @return  self
         */ 
        public function setSendLevel($send_level)
        {
                $this->send_level = $send_level;

                return $this;
        }

        /**
         * Get the value of is_record
         *
         * @return  bool
         */ 
        public function getIsRecord()
        {
                return $this->is_record;
        }

        /**
         * Set the value of is_record
         *
         * @param  bool  $is_record
         *
         * @return  self
         */ 
        public function setIsRecord(bool $is_record)
        {
                $this->is_record = $is_record;

                return $this;
        }

        /**
         * Get the value of record_level
         *
         * @return  integer
         */ 
        public function getRecordLevel()
        {
                return $this->record_level;
        }

        /**
         * Get the value of send_deduplicated_time
         *
         * @return  integer
         */ 
        public function getSendDeduplicatedTime()
        {
                return $this->send_deduplicated_time;
        }

        /**
         * Set the value of send_deduplicated_time
         *
         * @param  integer  $send_deduplicated_time
         *
         * @return  self
         */ 
        public function setSendDeduplicatedTime($send_deduplicated_time)
        {
                $this->send_deduplicated_time = $send_deduplicated_time;

                return $this;
        }

        /**
         * Get the value of record_deduplicated_time
         *
         * @return  integer
         */ 
        public function getRecordDeduplicatedTime()
        {
                return $this->record_deduplicated_time;
        }

        /**
         * Set the value of record_deduplicated_time
         *
         * @param  integer  $record_deduplicated_time
         *
         * @return  self
         */ 
        public function setRecordDeduplicatedTime($record_deduplicated_time)
        {
                $this->record_deduplicated_time = $record_deduplicated_time;

                return $this;
        }

    }
}
