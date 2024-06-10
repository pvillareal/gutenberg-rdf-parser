<?php

namespace Gutenberg\Models;

use Gutenberg\Traits\JsonSerialize;
use JsonSerializable;
use Symfony\Component\DomCrawler\Form;

class GutenbergBook implements JsonSerializable
{
    public string $id;
    public string $title;
    public string $language;
    public string $releaseDate;

    /** @var Author[] $authors */
    public array $authors;
    /** @var Compiler[] $compilers */
    public array $compilers;
    public array $subjects;
    public array $locc;
    public array $categories;
    public string $notes;
    public string $credits;
    public string $contents;
    public string $downloads;
    public string $rights;
    public array $bookshelves;
    public array $formats;
    public string $alternativeTitle;
    public string $originalPublication;
    public string $featureType;

    use JsonSerialize;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return GutenbergBook
     */
    public function setId(string $id): GutenbergBook
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return GutenbergBook
     */
    public function setTitle(string $title): GutenbergBook
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return GutenbergBook
     */
    public function setLanguage(string $language): GutenbergBook
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @return GutenbergBook
     */
    public function setReleaseDate(string $releaseDate): GutenbergBook
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param array $authors
     * @return GutenbergBook
     */
    public function setAuthors(array $authors): GutenbergBook
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @return array
     */
    public function getCompilers(): array
    {
        return $this->compilers;
    }

    /**
     * @param array $compilers
     * @return GutenbergBook
     */
    public function setCompilers(array $compilers): GutenbergBook
    {
        $this->compilers = $compilers;
        return $this;
    }

    /**
     * @return array
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @param array $subjects
     * @return GutenbergBook
     */
    public function setSubjects(array $subjects): GutenbergBook
    {
        $this->subjects = $subjects;
        return $this;
    }

    /**
     * @return array
     */
    public function getLocc(): array
    {
        return $this->locc;
    }

    /**
     * @param array $locc
     * @return GutenbergBook
     */
    public function setLocc(array $locc): GutenbergBook
    {
        $this->locc = $locc;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     * @return GutenbergBook
     */
    public function setCategories(array $categories): GutenbergBook
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     * @return GutenbergBook
     */
    public function setNotes(string $notes): GutenbergBook
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string
     */
    public function getCredits(): string
    {
        return $this->credits;
    }

    /**
     * @param string $credits
     * @return GutenbergBook
     */
    public function setCredits(string $credits): GutenbergBook
    {
        $this->credits = $credits;
        return $this;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     * @return GutenbergBook
     */
    public function setContents(string $contents): GutenbergBook
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return string
     */
    public function getDownloads(): string
    {
        return $this->downloads;
    }

    /**
     * @param string $downloads
     * @return GutenbergBook
     */
    public function setDownloads(string $downloads): GutenbergBook
    {
        $this->downloads = $downloads;
        return $this;
    }

    /**
     * @return string
     */
    public function getRights(): string
    {
        return $this->rights;
    }

    /**
     * @param string $rights
     * @return GutenbergBook
     */
    public function setRights(string $rights): GutenbergBook
    {
        $this->rights = $rights;
        return $this;
    }

    /**
     * @return array
     */
    public function getBookshelves(): array
    {
        return $this->bookshelves;
    }

    /**
     * @param array $bookshelves
     * @return GutenbergBook
     */
    public function setBookshelves(array $bookshelves): GutenbergBook
    {
        $this->bookshelves = $bookshelves;
        return $this;
    }

    /**
     * @return array
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param array $formats
     * @return GutenbergBook
     */
    public function setFormats(array $formats): GutenbergBook
    {
        $this->formats = $formats;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternativeTitle(): string
    {
        return $this->alternativeTitle;
    }

    /**
     * @param string $alternativeTitle
     * @return GutenbergBook
     */
    public function setAlternativeTitle(string $alternativeTitle): GutenbergBook
    {
        $this->alternativeTitle = $alternativeTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalPublication(): string
    {
        return $this->originalPublication;
    }

    /**
     * @param string $originalPublication
     * @return GutenbergBook
     */
    public function setOriginalPublication(string $originalPublication): GutenbergBook
    {
        $this->originalPublication = $originalPublication;
        return $this;
    }

    public function getCustomCover() : string
    {

        /** @var Format $format */
        foreach ($this->formats as $format) {
            if (stripos($format->fileUrl, 'cover.medium.jpg') != FALSE) {
                return $format->fileUrl;
            }
        }
        return "";
    }

    /**
     * @return string
     */
    public function getFeatureType(): string
    {
        return $this->featureType;
    }

    /**
     * @param string $featureType
     */
    public function setFeatureType(string $featureType): void
    {
        $this->featureType = $featureType;
    }
}