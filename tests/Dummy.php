<?php
namespace TurboLabIt\Foreachable\tests;


class Dummy
{
    protected $title    = '';
    protected $abstract = '';


    public function getTitle() : string
    {
        return $this->title;
    }


    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }


    public function getAbstract() : string
    {
        return $this->abstract;
    }


    public function setAbstract(string $abstract) : self
    {
        $this->abstract = $abstract;
        return $this;
    }
}
