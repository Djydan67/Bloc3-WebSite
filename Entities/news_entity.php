<?php

/**
 * Entité des articles*
 */
include("entities/mother_entity.php");

class News extends Entity
{
    // Attributs
    public int $_id = 0;
    private string $_title = '';
    private string $_img = '';
    private string $_content = '';
    private string $_createdate = '';
    private string $_creator = '';

    public function hydrate_news(array $data)
    {
        $this->setId($_GET['article_id'] ?? '');
        $this->setTitle($data['article_titre'] ?? '');
        $this->setImg($data['article_ImgID'] ?? '');
        $this->setContent($data['article_message'] ?? '');
        $this->setCreatedate($data['article_datecreation'] ?? '');
        $this->setCreator($data['user_id'] ?? '');
    }

    public function __construct()
    {
        $this->_prefixe = "article_";
    }
    // Getters et Setters

    /**
     * Setter de l'ID
     * @param $strTitle Titre de l'ID
     * @return void
     */
    public function setId($strId)
    {
        $this->_id = (int)$strId;
    }

    /**
     * Getter de l'ID
     * @return string ID
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Setter du titre
     * @param $strTitle Titre de l'article
     * @return void
     */
    public function setTitle($strTitle)
    {
        $this->_title = $strTitle;
    }

    /**
     * Getter du titre
     * @return string Titre
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Setter de l'image
     * @param $strImg Image de l'article
     * @return void
     */
    public function setImg($strImg)
    {
        $this->_img = $strImg;
    }

    /**
     * Getter de l'image
     * @return string Nom de l'image
     */
    public function getImg()
    {
        return $this->_img;
    }

    /**
     * Setter du createur
     * @param $strCreator Créateur de l'article
     * @return void
     */
    public function setCreator($strCreator)
    {
        $this->_creator = $strCreator;
    }

    /**
     * Getter du créateur
     * @return string Nom du créateur
     */
    public function getCreator()
    {
        return $this->_creator;
    }

    public function setContent($strContent)
    {
        $this->_content = $strContent;
    }
    public function getContent()
    {
        return $this->_content;
    }


    public function setCreatedate($strCreatedate)
    {
        $this->_createdate = $strCreatedate;
    }
    public function getCreatedate($strFormat = 'd/m/Y')
    {
        $objDate     = new DateTime($this->_createdate);
        $strDate    = $objDate->format($strFormat);
        return $strDate;
    }
}
