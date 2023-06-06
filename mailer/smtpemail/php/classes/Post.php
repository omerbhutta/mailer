<?php


class Post{
    private $id;
    private $id_cat;
    private $id_subcat;
    private $nazva;
    private $description;
    private $img;
    private $text;
    private $datee;
    private $sort;


    public function setPost($row){
        $this->id = (int) $row['id'];
        $this->id_cat = (int) $row['id_cat'];
        $this->id_subcat = (int) $row['id_subcat'];
        $this->nazva = $row['nazva'];
        $this->description = $row['description'];
        $this->img = $row['img'];
        $this->text = $row['text'];
        $this->datee = $row['datee'];
        $this->sort = (int)$row['sort'];
    }

    public function getSort(){
        return $this->sort;
    }

    public function getDatee(){
        return $this->datee;
    }

    public function setDatee($datee){
        $this->datee = $datee;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getIdCat()
    {
        return $this->id_cat;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param mixed $nazva
     */
    public function setNazva($nazva)
    {
        $this->nazva = $nazva;
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
    public function getIdSubcat()
    {
        return $this->id_subcat;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getNazva()
    {
        return $this->nazva;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @param mixed $id_cat
     */
    public function setIdCat($id_cat)
    {
        $this->id_cat = (int) $id_cat;
    }

    /**
     * @param mixed $id_sub
     */
    public function setIdSubcR($id_subcat)
    {
        $this->id_subcat = (int) $id_subcat;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }


}