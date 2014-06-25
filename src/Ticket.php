<?php
namespace Buddy;

class Ticket
{
    private $id;
    private $number;
    private $title;

    function __construct($id, $number, $title)
    {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


}