<?php
/**
 * Forum Entity
 * @author Salar
 */

include("mother_entity.php");

class Forum extends Entity {
    private int $_theme;
    private string $_title = '';
    private string $_message = '';
    private string $_createdate = '';
    private int $_author;
    private int $_isvalide;
    private int $_isclose;

    public function __construct() {
        $this->_prefixe = "forum_";
    }

    // Getters & Setters

    /**
     * Setter
     * @param int $intTheme = Forum theme
     * @return void
     */
    public function setTheme(int $intTheme): void {
        $this->_theme = $intTheme;
    }

    /**
     * Getter
     * @return int Theme
     */
    public function getTheme(): int {
        return $this->_theme;
    }

    /**
     * Setter
     * @param string $strTitle = Forum title 
     * @return void
     */
    public function setTitle(string $strTitle): void {
        $this->_title = $strTitle;
    }

    /**
     * Getter
     * @return string Title
     */
    public function getTitle(): string {
        return $this->_title;
    }

    /**
     * Setter
     * @param string $strMessage = Forum message
     * @return void
     */
    public function setMessage(string $strMessage): void {
        $this->_message = $strMessage;
    }

    /**
     * Getter
     * @return string Message
     */
    public function getMessage(): string {
        return $this->_message;
    }

    /**
     * Setter
     * @param string $strDate = Forum date  
     * @return void
     */
    public function setDate(string $strDate): void {
        $this->_createdate = $strDate;
    }

    /**
     * Getter
     * @return string Date
     */
    public function getDate(): string {
        return $this->_createdate;
    }

    /**
     * Setter
     * @param int $intUser = Forum author
     * @return void
     */
    public function setAuthor(int $intAuthor): void {
        $this->_author = $intAuthor;
    }

    /**
     * Getter
     * @return int Author
     */
    public function getAuthor(): int {
        return $this->_author;
    }

    /**
     * Setter
     * @param int $intIsvalide = Forum is valide or not
     * @return void
     */
    public function setIsvalide(int $intIsvalide): void {
        $this->_isvalide = $intIsvalide;
    }

    /**
     * Getter
     * @return int is Valide or not
     */
    public function getIsvalide(): int {
        return $this->_isvalide;
    }

    /**
     * Setter
     * @param int $intIsclose = Forum is closed or not
     * @return void
     */
    public function setIsclose(int $intIsclose): void {
        $this->_isclose = $intIsclose;
    }

    /**
     * Getter
     * @return int is closed or not
     */
    public function getIsclose(): int {
        return $this->_isclose;
    }
}

class Theme extends Entity {
    private int $_theme_id;
    private string $_theme_nom = '';
    private string $_theme_description = '';
    private string $_theme_update = '';

    public function __construct() {
        $this->_prefixe = "theme_";
    }

    public function hydrate($data) {
        $this->setThemeId($data['theme_id'] ?? null);
        $this->setThemeName($data['theme_nom'] ?? null);
        $this->setThemeDescription($data['theme_description'] ?? null);
        $this->setDate($data['theme_update'] ?? null);
    }

    // Getters & Setters

    /**
     * Setter
     * @param int $intTheme_id = Theme id
     * @return void
     */
    public function setThemeId(int $intTheme_id): void {
        $this->_theme_id = $intTheme_id;
    }

    /**
     * Getter
     * @return int Theme id
     */
    public function getThemeId(): int {
        return $this->_theme_id;
    }

    /**
     * Setter
     * @param string $strThemeName = Theme Name 
     * @return void
     */
    public function setThemeName(string $strThemeName): void {
        $this->_theme_nom = $strThemeName;
    }

    /**
     * Getter
     * @return string Theme Name
     */
    public function getThemeName(): string {
        return $this->_theme_nom;
    }

    /**
     * Setter
     * @param string $strThemeDescription = Theme Description
     * @return void
     */
    public function setThemeDescription(string $strThemeDescription): void {
        $this->_theme_description = $strThemeDescription;
    }

    /**
     * Getter
     * @return string Theme Description
     */
    public function getThemeDescription(): string {
        return $this->_theme_description;
    }

    /**
     * Setter
     * @param string $strDate = Theme date
     * @return void
     */
    public function setDate(string $strDate): void {
        $this->_theme_update = $strDate;
    }

    /**
     * Getter
     * @return string Date
     */
    public function getDate(): string {
        return $this->_theme_update;
    }
}
?>
