<?php



class Category{
    private $id;
    private $nazva;
    private $eng_name;
    private $sub;

    public function setCategory($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->eng_name = $row['eng_name'];
    }

    public function getEngName(){
        return $this->eng_name;
    }

    public function setEngName($engname){
        $this->eng_name = $engname;
    }
    /**
     * @return mixed
     */
    public function getNazva()
    {
        return $this->nazva;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
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
    public function getSub()
    {
        return $this->sub;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
    }

    /**
     * @param mixed $sub
     */
    public function setSub($sub)
    {
        $this->sub = $sub;
    }
}