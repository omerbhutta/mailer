<?php



class Subcategory{
    private $id;
    private $id_cat;
    private $nazva;
    private $eng_name;


    public function setSubCategory($row){
        $this->id = (int)$row['id'];
        $this->nazva = $row['nazva'];
        $this->id_cat = intval($row['id_cat']);
        $this->eng_name = $row['eng_name'];
    }

    public function setEngName($name){
        $this->eng_name = $name;
    }

    /**
     * @return mixed
     */
    public function getEngName()
    {
        return $this->eng_name;
    }

    /**
     * @return mixed
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * @param mixed $id_cat
     */
    public function setIdCat($id_cat)
    {
        $this->id_cat = (int)$id_cat;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
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
    public function getNazva()
    {
        return $this->nazva;
    }
}