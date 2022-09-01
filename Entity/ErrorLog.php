<?php

namespace Plugin\ErrorNotify\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\ErrorNotify\Entity\ErrorLog', false)) {
    /**
     * ErrorLog
     *
     * @ORM\Table(name="plg_error_notify_error_log")
     * @ORM\Entity(repositoryClass="Plugin\ErrorNotify\Repository\ErrorLogRepository")
     */
    class ErrorLog extends \Eccube\Entity\AbstractEntity
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
         * @var \DateTime
         *
         * @ORM\Column(name="datetime", type="datetime")
         */
        private $datetime;

        /**
         * @var string
         *
         * @ORM\Column(name="level", type="string", length=255)
         */
        private $level;

        /**
         * @var string
         *
         * @ORM\Column(name="method", type="string", length=255, nullable=true)
         */
        private $method;

        /**
         * @var string
         *
         * @ORM\Column(name="url", type="string", nullable=true)
         */
        private $url;

        /**
         * @var string
         *
         * @ORM\Column(name="user_agent", type="string", nullable=true)
         */
        private $user_agent;

        /**
         * @var string
         *
         * @ORM\Column(name="ip_address", type="string", nullable=true)
         */
        private $ip_address;

        /**
         * @var string
         *
         * @ORM\Column(name="content", type="string", nullable=true, length=20000)
         */
        private $content;

        /**
         * @var string
         *
         * @ORM\Column(name="referrer", type="string", nullable=true)
         */
        private $referrer;

        /**
         * @var boolean
         *
         * @ORM\Column(name="is_fixed", type="boolean")
         */
        private $is_fixed;

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        // public function setId($id = null)
        // {
        //     $this->id = $id;
        //     return $this;
        // }


        /**
         * @return Datetime
         */
        public function getDatetime()
        {
            return $this->datetime;
        }

        /**
         * @param Datetime $datetime
         *
         * @return $this;
         */
        public function setDatetime($datetime)
        {
            $this->datetime = $datetime;

            return $this;
        }

        /**
         * @return string
         */
        public function getLevel()
        {
            return $this->level;
        }

        /**
         * @param string $level
         *
         * @return $this;
         */
        public function setLevel($level)
        {
            $this->level = $level;

            return $this;
        }


        /**
         * @return string
         */
        public function getMethod()
        {
            return $this->method;
        }

        /**
         * @param string $method
         *
         * @return $this;
         */
        public function setMethod($method)
        {
            $this->method = $method;

            return $this;
        }

        /**
         * @return string
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * @param string $url
         *
         * @return $this;
         */
        public function setUrl($url)
        {
            $this->url = $url;

            return $this;
        }

        /**
         * @return string
         */
        public function getContent()
        {
            return $this->content;
        }

        /**
         * @param string $content
         *
         * @return $this;
         */
        public function setContent($content)
        {
            $this->content = $content;

            return $this;
        }

        /**
         * Get the value of user_agent
         *
         * @return  string
         */ 
        public function getUserAgent()
        {
                return $this->user_agent;
        }

        /**
         * Set the value of user_agent
         *
         * @param  string  $user_agent
         *
         * @return  self
         */ 
        public function setUserAgent(string $user_agent)
        {
                $this->user_agent = $user_agent;

                return $this;
        }

        /**
         * Get the value of ip_address
         *
         * @return  string
         */ 
        public function getIpAddress()
        {
                return $this->ip_address;
        }

        /**
         * Set the value of ip_address
         *
         * @param  string  $ip_address
         *
         * @return  self
         */ 
        public function setIpAddress(string $ip_address)
        {
                $this->ip_address = $ip_address;

                return $this;
        }

        /**
         * Get the value of is_fixed
         *
         * @return  boolean
         */ 
        public function getIsFixed()
        {
                return $this->is_fixed;
        }

        /**
         * Set the value of is_fixed
         *
         * @param  bool  $is_fixed
         *
         * @return  self
         */ 
        public function setIsFixed(bool $is_fixed)
        {
                $this->is_fixed = $is_fixed;

                return $this;
        }

        /**
         * Get the value of referrer
         *
         * @return  string
         */ 
        public function getReferrer()
        {
                return $this->referrer;
        }

        /**
         * Set the value of referrer
         *
         * @param  string  $referrer
         *
         * @return  self
         */ 
        public function setReferrer(string $referrer)
        {
                $this->referrer = $referrer;

                return $this;
        }
    }

        
}
