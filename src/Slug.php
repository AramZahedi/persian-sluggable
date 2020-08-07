<?php

namespace AramZahedi\Sluggable;

class Slug
{
    /**
     * @var Slug
     */
    protected static $instance;

    /**
     * Characters to replace
     *
     * @var array
     */
    protected $to_replace = [
        ' ', "\u{200C}", "\u{FEFF}", "\u{200B}", "\u{180E}", '_', '-', '.',
        '?', '؟', '!', ',', '،', ':', '«', '»', ')', '(', '\\', '/', '<', '>',
        '#', '@', '&', '*', '"', '\'', '+', '~', '^', '`'
    ];

    /**
     * @var string
     */
    protected $separator;

    /**
     * @var string
     */
    protected $slug;

    /**
     * Get a singleton of class
     *
     * @return Slug
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new Slug();
        }

        return self::$instance;
    }

    /**
     * Generate slug from string
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function slug($string, $separator = '-')
    {
        return self::instance()
            ->setSeparator($separator)
            ->setSlug($string)
            ->process();
    }

    /**
     * Set separator character
     *
     * @param string $separator
     * @return Slug
     */
    protected function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Set string to slug
     *
     * @param string $slug
     * @return Slug
     */
    protected function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Process the slug
     *
     * @return string
     */
    protected function process()
    {
        $this->convertNumbers();

        $this->convertCharacters();

        $this->convertWhitespaces();

        $this->cleanSlug();

        $this->removeMultipleSeparators();

        $this->trimSlug();

        $this->convertToLowercase();

        return $this->slug;
    }

    /**
     * Convert any number to english
     */
    protected function convertNumbers()
    {
        $this->slug = Persian::convertNumbersToEnglish(
            $this->slug
        );
    }

    /**
     * Convert any Arabic character to Persian
     */
    protected function convertCharacters()
    {
        $this->slug = Persian::convertArabicCharacters(
            $this->slug
        );
    }

    /**
     * Convert whitespaces to separator
     */
    protected function convertWhitespaces()
    {
        $this->slug = str_replace($this->to_replace,
            $this->separator, $this->slug);
    }

    /**
     * Remove multiple separators
     */
    protected function removeMultipleSeparators()
    {
        $this->slug = preg_replace('/'
            . (ctype_alpha($this->separator)
                ? $this->separator : '\\' . $this->separator)
            . '+/',
            $this->separator, $this->slug);
    }

    /**
     * Clean the slug from unwanted characters
     */
    protected function cleanSlug()
    {
        $this->slug = mb_ereg_replace(
            '[^' . 'آابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهیئء'
            . 'a-zA-Z0-9'
            . (ctype_alpha($this->separator) ? $this->separator : '\\' . $this->separator)
            . ']',
            '', $this->slug
        );
    }

    /**
     * Trim slug for unwanted separators
     */
    protected function trimSlug()
    {
        $this->slug = ltrim(
            rtrim($this->slug,
                $this->separator
            ), $this->separator
        );
    }

    /**
     * Convert the string to lowercase characters
     */
    protected function convertToLowercase()
    {
        $this->slug = mb_strtolower($this->slug);
    }
}
